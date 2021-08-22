<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\CongDoanTuSiModel as CdtsSv;
use App\Http\Requests\CongDoanTuSiRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class CongDoanTuSiController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'cong-doan-tu-si';

    /**
     * @var null
     */
    private $cdtsSv = null;

    /**
     * @author: dtphi .
     * CongDoanTuSiController constructor.
     * @param CdtsSv $cdtsSv
     * @param array $middleware
     */
    public function __construct(CdtsSv $cdtsSv, array $middleware = [])
    {
        $this->cdtsSv = $cdtsSv;
        parent::__construct($middleware);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->cdtsSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            
            foreach ($collections as $key => $info) {
                $results[] = [
                    'id' => (int)$info->id,
                    'name'           => $info->name,
                    'dia_chi'         => $info->dia_chi,
                    'dien_thoai'          => $info->dien_thoai,
                    'ghi_chu'    => $info->ghi_chu,
                    'active'     => $info->active,
                    'active_text' => $info->active?'Xảy ra':'Ẩn'
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
            $json = $this->cdtsSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param CongDoanTuSiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CongDoanTuSiRequest $request)
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
     * @param CongDoanTuSiRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CongDoanTuSiRequest $request, $id = null)
    {
        try {
            $model = $this->cdtsSv->apiGetDetail($id);

        } catch (HandlerMsgCommon $e) {
            Log::debug('Giao phan not found, Request ID = ' . $id);

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
            $model = $this->cdtsSv->apiGetDetail($id);
            $model->forceDelete();
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

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

        if ($result = $this->cdtsSv->apiInsert($formData)) {
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

        if ($result = $this->cdtsSv->apiInsertOrUpdate($formData, $model)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function uploadImage(Request $request)
    {
        if ($request->is('options')) {
            return;
        }

        return $this->respondBadRequest();
    }
}
