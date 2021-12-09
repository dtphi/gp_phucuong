<?php

namespace App\Http\Controllers\Api\Admin;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Exceptions\HandlerMsgCommon;
use App\Http\Requests\RestrictIpRequest;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\RestrictIpModel as ResIpSv;

class RestrictIpController extends ApiController
{
    private $ResIpSv = null;

    protected $resourceName = 'restrict-ip';

    public function __construct(ResIpSv $resIpSv, array $middleware = [])
    {
        $this->ResIpSv = $resIpSv;
        parent::__construct($middleware);
        $this->_initAuthor(new RestrictIpRequest);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RestrictIpRequest $request)
    {
        $data = $request->all();
        $page = 1;
        if($request->query('page')) {
          $page = (int)$request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->ResIpSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            foreach ($collections as $key => $info) {
                $results[] = [
                    'id' => (int)$info->id,
                    'ip' => $info->ip,
                    'active' => $info->active,
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestrictIpRequest $request)
    {
        $storeResponse = $this->__handleStore($request);
        if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
          return $storeResponse;
        }

        $resourceId = ($this->getResource()) ? $this->getResource()->id : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    private function __handleStore(&$request)
    {
        $formData = $request->all();
        if ($result = $this->ResIpSv->apiInsert($formData)) {
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
    public function show($id = null)
    {
       try {
            $json = $this->ResIpSv->apiGetResourceDetail($id);
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
    public function update(RestrictIpRequest $request, $id)
    {
        try {
            $model = $this->ResIpSv->apiGetDetail($id);
    
        } catch (HandlerMsgCommon $e) {
            Log::debug('Restrict ip not found, Request ID = ' . $id);
            throw $e->render();
        }
        return $this->__handleStoreUpdate($model, $request);
    }

    private function __handleStoreUpdate(&$model, &$request)
    {
        $formData = $request->all();
        if ($result = $this->ResIpSv->apiUpdate($model, $formData["data"])) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        $model = $this->ResIpSv->apiGetDetail($id);
      } catch (HandlerMsgCommon $e) {
        throw $e->render();
      }
      $this->ResIpSv->apiDelete($model);
      return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    public function search(RestrictIpRequest $request)
    {
      $data = $request->all();
      $page = 1;
      if($request->query('page')) {
        $page = (int)$request->query('page');
      }
      if($request->query('query')) {
        $query = $request->query('query');
      }
      try {
        $limit       = $this->_getPerPage();
        $collections = $this->ResIpSv->apiGetSearch($data, $limit, $query);
        $pagination  = $this->_getTextPagination($collections);
        $results = [];
        foreach ($collections as $key => $info) {
          $results[] = [
            'id' => (int)$info->id,
            'ip' => $info->ip,
            'active' => $info->active,
          ];
        }
      } catch (HandlerMsgCommon $e) {
        throw $e->render();
      }
      $json = [
        'data' => [
          'results'    => $results,
          'pagination' => $pagination,
          'page'       => $page,
        ]
      ];
      return $this->respondWithCollectionPagination($json);
    }

    public function changeStatus(Request $request) {
      $formData = $request->all();
      if ($result = $this->ResIpSv->apiChangeStatus($formData)) {
          return $this->respondUpdated($result);
      }
      return $this->respondBadRequest();
    }
}
