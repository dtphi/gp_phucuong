<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucChucThanhModel as LinhMucChucThanhSv;
use App\Http\Requests\LinhMucChucThanhRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Common\Tables;
use Log;

class LinhMucChucThanhController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'linh_muc_bang_cap';

    /**
     * @var null
     */
    private $chucThanhSv = null;

    /**
     * @author: dtphi .
     * LinhMucChucThanhController constructor.
     * @param LinhMucChucThanhSv $chucThanhSv
     * @param array $middleware
     */
    public function __construct(LinhMucChucThanhSv $chucThanhSv, array $middleware = [])
    {
        $this->chucThanhSv = $chucThanhSv;
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
            $collections = $this->chucThanhSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            
            foreach ($collections as $key => $info) {
                $results[] = [
                    'id' => (int)$info->id,
                    'nguoi_thu_phong'           => $info->nguoi_thu_phong,
                    'noi_thu_phong'         => $info->noi_thu_phong,
                    'linh_muc_url' => url('admin/linh-mucs/edit/' . $info->linh_muc_id),
                    'ten_linh_muc' => $info->ten_linh_muc,
                    'chuc_thanh_id' => $info->chuc_thanh_id,
                    'ten_chuc_thanh' => Tables::$chucThanhs[$info->chuc_thanh_id],
                    'ngay_thang' => $info->ngay_thang_nam_chuc_thanh,
                    'ghi_chu'          => $info->ghi_chu,
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
            $json = $this->chucThanhSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param LinhMucChucThanhRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LinhMucChucThanhRequest $request)
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
     * @param LinhMucChucThanhRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LinhMucChucThanhRequest $request, $id = null)
    {
        try {
            $model = $this->chucThanhSv->apiGetDetail($id);

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
            $model = $this->chucThanhSv->apiGetDetail($id);
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

        if ($result = $this->chucThanhSv->apiInsert($formData)) {
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

        if ($result = $this->chucThanhSv->apiUpdate($model, $formData)) {
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
