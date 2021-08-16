<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoPhanTinTucModel as GpttSv;
use App\Http\Requests\GiaoPhanTinTucRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class GiaoPhanTinTucController extends ApiController
{
  /**
   * @var string
   */
  protected $resourceName = 'giaophantintucs';

  /**
   * @var null
   */
  private $gpttSv = null;

  
  public function __construct(GpttSv $gpttSv, array $middleware = [])
  {
    $this->gpttSv = $gpttSv;
    parent::__construct($middleware);
  }

  /**
   * @author : dtphi .
   * @param Request $request
   * @return mixed
   */
  public function index(GiaoPhanTinTucRequest $request)
  {
    $data = $request->all();
    $page = 1;
    if ($request->query('page')) {
      $page = $request->query('page');
    }
    try {
      $limit       = $this->_getPerPage();
      $collections = $this->gpttSv->apiGetList($data, $limit);

      if (isset($data['infoType']) && $data['infoType'] == 'module_special_info') {
        $pagination = [];
      } else {
        $pagination  = $this->_getTextPagination($collections);
      }
      
      $results = [];
      $staticImgThum = self::$thumImgNo;
      foreach ($collections as $key => $info) {
        if (file_exists(public_path($info->image['path'])) && $info->image['path']!='') {
          $staticImgThum = $info->image['path'];
        }
        
        $results[] = [
          'information_id' => (int)$info->information_id,
          'image'          => $info->image,
          'imgThum'        => url($this->getThumbnail($staticImgThum, 0, 40)),
          'name'           => $info->name,
          'status'         => $info->status,
          'status_text'    => $info->status_text,
          'sort_order'     => $info->sort_order,
          'date_available' => $info->date_available,
          'created_at'     => $info->created_at
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

  public function show($id = null, GiaoPhanTinTucRequest $request)
  {
    try {
      $json = $this->gpttSv->apiGetResourceDetail($id);
    } catch (HandlerMsgCommon $e) {
      throw $e->render();
    }

    return $json;
  }

  public function store(GiaoPhanTinTucRequest $request)
  {
    $storeResponse = $this->__handleStore($request);

    if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
      return $storeResponse;
    }

    $resourceId = ($this->getResource()) ? $this->getResource()->information_id : null;

    return $this->respondCreated("GiaoPhanTinTuc {$this->resourceName} created.", $resourceId);
  }

 
  public function update(GiaoPhanTinTucRequest $request, $id = null)
  {
    try {
      $model = $this->gpttSv->apiGetDetail($id);
    } catch (HandlerMsgCommon $e) {
      Log::debug('User not found, Request ID = ' . $id);

      throw $e->render();
    }

    return $this->__handleStoreUpdate($model, $request);
  }

  public function destroy($id = null, Request $request)
  {
    try {
      $model = $this->gpttSv->apiGetDetail($id);

    } catch (HandlerMsgCommon $e) {
      throw $e->render();
    }

    $this->gpttSv->deleteInformation($model);

    return $this->respondDeleted("{$this->resourceName} deleted.");
  }

  private function __handleStore(&$request)
  {
    $formData = $request->all();

    if ($result = $this->gpttSv->apiInsert($formData)) {
      return $this->respondUpdated($result);
    }

    return $this->respondBadRequest();
  }

  private function __handleStoreUpdate(&$model, &$request)
  {
    $formData = $request->all();

    if ($result = $this->gpttSv->apiUpdate($model, $formData)) {
      return $this->respondUpdated($result);
    }

    return $this->respondBadRequest();
  }

  public function uploadImage(Request $request)
  {
    if ($request->is('options')) {
      return;
    }

    return $this->respondBadRequest();
  }


  public function dropdown(Request $request)
  {
    $data = $request->all();

    $results     = $this->gpttSv->apiGetList($data);
    $collections = [];

    foreach ($results as $key => $value) {
      $collections[] = [
        'information_id' => $value->information_id,
        'name'           => $value->name,
      ];
    }

    return $this->respondWithCollectionPagination($collections);
  }
}
