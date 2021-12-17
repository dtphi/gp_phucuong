<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\DongModel as DongSv;
use App\Http\Requests\DongRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class DongController extends ApiController
{
  /**
   * @var string
   */
  protected $resourceName = 'dong';

  /**
   * @var null
   */
  private $dongSv = null;

  /**
   * @author: dtphi .
   * DongController constructor.
   * @param DongSv $dongSv
   * @param array $middleware
   */
  public function __construct(DongSv $dongSv, array $middleware = [])
  {
    $this->dongSv = $dongSv;
    parent::__construct($middleware);
    $this->_initAuthor(new DongRequest);
  }

  /**
   * @author : dtphi .
   * @param Request $request
   * @return mixed
   */
  public function index(DongRequest $request)
  {
    $data = $request->all();
    $page = 1;
    if ($request->query('page')) {
      $page = $request->query('page');
    }
    try {
      $limit       = $this->_getPerPage();
      $collections = $this->dongSv->apiGetList($data, $limit);
      $pagination  = $this->_getTextPagination($collections);
      $results = [];

      foreach ($collections as $key => $info) {
        $results[] = [
          'id' => (int)$info->id,
          'name'           => $info->name,
          'dia_chi'         => $info->dia_chi,
          'dien_thoai'          => $info->dien_thoai,
          'email'    => $info->email,
          'viet'    => $info->viet,
          'latin'    => $info->latin,
          'active'     => $info->active
        ];
      }
    } catch (HandlerMsgCommon $e) {
      throw $e->render();
    }

    $json = [
      'data' => [
        'results'    => $results,
        'pagination' => $pagination,
        'page'       => $page
      ]
    ];

    return $this->respondWithCollectionPagination($json);
  }

  /**
   * @author : dtphi .
   * @param null $id
   * @return mixed
   */
  public function show($id = null)
  {
    try {
      $json = $this->dongSv->apiGetResourceDetail($id);
    } catch (HandlerMsgCommon $e) {
      throw $e->render();
    }

    return $json;
  }

  /**
   * @author : dtphi .
   * @param DongRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(DongRequest $request)
  {
    $storeResponse = $this->__handleStore($request);

    if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
      return $storeResponse;
    }

    $resourceId = ($this->getResource()) ? $this->getResource()->id : null;

    return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
  }

  /**
   * @author : dtphi .
   * @param DongRequest $request
   * @param null $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(DongRequest $request, $id = null)
  {
    try {
      $model = $this->dongSv->apiGetDetail($id);
    } catch (HandlerMsgCommon $e) {
      Log::debug('Dong not found, Request ID = ' . $id);

      throw $e->render();
    }
    return $this->__handleStoreUpdate($model, $request);
  }

  /**
   * @author : dtphi .
   * @param null $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id = null)
  {
    try {
      $model = $this->dongSv->apiGetDetail($id);
    } catch (HandlerMsgCommon $e) {
      throw $e->render();
    }

    $this->infoSv->deleteInformation($model);

    return $this->respondDeleted("{$this->resourceName} deleted.");
  }

  /**
   * @author : dtphi .
   * @param $request
   * @return \Illuminate\Http\JsonResponse
   */
  private function __handleStore(&$request)
  {
    $formData = $request->all();

    if ($result = $this->dongSv->apiInsertOrUpdate($formData)) {
      return $this->respondUpdated($result);
    }

    return $this->respondBadRequest();
  }

  /**
   * @author : dtphi .
   * @param $model
   * @param $request
   * @return \Illuminate\Http\JsonResponse
   */
  private function __handleStoreUpdate(&$model, &$request)
  {
    $formData = $request->all();
    if ($result = $this->dongSv->apiUpdate($model, $formData)) {
      return $this->respondUpdated($result);
    }

    return $this->respondBadRequest();
  }

  /**
   * @author : dtphi .
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse|void
   */
  public function uploadImage(DongRequest $request)
  {
    if ($request->is('options')) {
      return;
    }

    return $this->respondBadRequest();
  }
}
