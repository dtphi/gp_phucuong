<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Log;
use App\Exceptions\HandlerMsgCommon;
use App\Http\Requests\GiaoPhanDanhMucRequest;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoPhanDanhMucModel as gpdmSv;

class GiaoPhanDanhMucController extends ApiController
{
  protected $resourceName = 'DanhMucGiaoPhan';

  private $gpdmSv = null;

  public function __construct(gpdmSv $gpdmSv, array $middleware = [])
  {

    $this->gpdmSv = $gpdmSv;
    parent::__construct($middleware);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(GiaoPhanDanhMucRequest $request)
  {
    $data = $request->all();
    $page = 1;
    if ($request->query('page')) {
      $page = $request->query('page');
    }
    $data["page"] = $page;
    try {
      $limit      = $this->_getPerPage();
      $giaoPhanDMs = $this->gpdmSv->apiGetList($data, $limit);
      $pagination = $this->_getTextPagination($giaoPhanDMs);

      $results = [];
      foreach ($giaoPhanDMs as $key => $newsGroup) {
        $results[] = [
          'category_name' => $newsGroup->category_name,
          'sort_order'    => $newsGroup->sort_order,
          'category_id'   => $newsGroup->category_id
        ];
      }
    } catch (HandlerMsgCommon $e) {
      throw $e->render();
    }

    return Helper::successResponse([
      'results'    => $results,
      'pagination' => $pagination,
      'page'       => $page
    ]);
  }

  protected function _getTextPagination(LengthAwarePaginator $paginator)
  {
    $data = [];

    if ($paginator instanceof LengthAwarePaginator && $paginator->count()) {
      $data = $paginator->toArray();

      unset($data['data']);
    }

    return $data;
  }

  public function generateTree($data, $parent = -1, $depth = 0)
  {
    $newsGroupTree = [];

    for ($i = 0, $ni = count($data); $i < $ni; $i++) {
      if ($data[$i]['father_id'] == $parent) {
        $newsGroupTree[$data[$i]['id']]['id']            = $data[$i]['id'];
        $newsGroupTree[$data[$i]['id']]['fatherId']      = $data[$i]['father_id'];
        $newsGroupTree[$data[$i]['id']]['newsgroupname'] = $data[$i]['newsgroupname'];
        $newsGroupTree[$data[$i]['id']]['children']      = $this->generateTree(
          $data,
          $data[$i]['id'],
          $depth + 1
        );
      }
    }

    return $newsGroupTree;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(GiaoPhanDanhMucRequest $request)
  {
    $storeResponse = $this->__handleStore($request);

    if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
      return $storeResponse;
    }

    $resourceId = ($this->getResource()) ? $this->getResource()->category_id : null;

    return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
  }

  // handle insert giaophandanhmuc
  private function __handleStore(&$request)
  {
    $requestParams = $request->all();

    if ($result = $this->gpdmSv->apiInsert($requestParams)) {
      return $this->respondUpdated($result);
    }

    return $this->respondBadRequest();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id = null, GiaoPhanDanhMucRequest $request)
  {
    $json = [];

    try {
      if ($id) {
        $json = $this->gpdmSv->apiGetResourceDetail($id);
      }
    } catch (HandlerMsgCommon $e) {
      throw $e->render();
    }

    return $json;
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(GiaoPhanDanhMucRequest $request, $id = null)
  {
    $model = null;

    try {
      if ($id) {
        $model = $this->gpdmSv->getCateogryById($id);
      }
    } catch (HandlerMsgCommon $e) {
      Log::debug('GiaoPhanDanhMuc not found, Request ID = ' . $id);

      throw $e->render();
    }

    return $this->__handleStoreUpdate($model, $request);
  }


  // handle update giaophandanhmuc
  private function __handleStoreUpdate(&$model, &$request)
  {
    $formData = $request->all();

    if (!is_null($model)) {
      if ($result = $this->gpdmSv->apiUpdate($model, $formData)) {
        return $this->respondUpdated($result);
      }
    }
    return $this->respondBadRequest();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id = null, GiaoPhanDanhMucRequest $request)
  {
    try {
      $model = $this->gpdmSv->getCateogryById($id);
    } catch (HandlerMsgCommon $e) {
      throw $e->render();
    }

    $this->gpdmSv->deleteCategory($model);

    return $this->respondDeleted("{$this->resourceName} deleted.");
  }

  // dropdown list giaophandanhmuc
  public function dropdown(Request $request)
  {
    $data = $request->all();

    $results     = $this->gpdmSv->apiGetCategories($data, 0);
    $collections = [];

    foreach ($results as $key => $value) {
      $collections[] = [
        'category_id' => $value->category_id,
        'name'        => strip_tags(html_entity_decode($value->name, ENT_QUOTES, 'UTF-8')),
      ];
    }

    return $this->respondWithCollectionPagination($collections);
  }
}
