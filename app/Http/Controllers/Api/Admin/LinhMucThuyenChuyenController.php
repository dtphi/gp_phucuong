<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucThuyenChuyenModel as LinhMucThuyenChuyenSv;
use App\Http\Requests\LinhMucThuyenChuyenRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Common\Tables;
use Log;

class LinhMucThuyenChuyenController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'linh_muc_thuyen_chuyen';

    /**
     * @var null
     */
    private $thuyenChuyenSv = null;

    /**
     * @author: dtphi .
     * LinhMucThuyenChuyenController constructor.
     * @param LinhMucThuyenChuyenSv $thuyenChuyenSv
     * @param array $middleware
     */
    public function __construct(LinhMucThuyenChuyenSv $thuyenChuyenSv, array $middleware = [])
    {
        $this->thuyenChuyenSv = $thuyenChuyenSv;
        parent::__construct($middleware);
        $this->_initAuthor(new LinhMucThuyenChuyenRequest);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(LinhMucThuyenChuyenRequest $request)
    {
        $data = $request->all();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->thuyenChuyenSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            
            foreach ($collections as $key => $info) {
                $results[] = [
                    'id' => (int)$info->id,
                    'linh_muc_url' => url('admin/linh-mucs/edit/' . $info->linh_muc_id),
                    'ten_linh_muc' => $info->ten_linh_muc,
                    'fromGiaoXuName'      => $info->ten_from_giao_xu,
                    'fromchucvuName' => $info->ten_from_chuc_vu,
                    'label_from_date' => ($info->from_date)?date_format(date_create($info->from_date),"d-m-Y"):'',
                    'ducchaName' => $info->ten_duc_cha,
                    'label_to_date' => ($info->to_date)?date_format(date_create($info->to_date),"d-m-Y"):'',
                    'chucvuName' => $info->ten_to_chuc_vu,
                    'giaoxuName' => $info->ten_to_giao_xu,
                    'cosogpName' => $info->ten_co_so,
                    'dongName' => $info->ten_dong,
                    'banchuyentrachName' => $info->ten_ban_chuyen_trach,
                    'du_hoc' => $info->du_hoc,
                    'quoc_gia' => $info->quoc_gia,
                    'ghi_chu' => $info->ghi_chu,
                    'active' => $info->active,
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
            $json = $this->thuyenChuyenSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param LinhMucThuyenChuyenRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LinhMucThuyenChuyenRequest $request)
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
     * @param LinhMucThuyenChuyenRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LinhMucThuyenChuyenRequest $request, $id = null)
    {
        try {
            $model = $this->thuyenChuyenSv->apiGetDetail($id);

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
            $model = $this->thuyenChuyenSv->apiGetDetail($id);
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

        if ($result = $this->thuyenChuyenSv->apiInsert($formData)) {
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

        if ($result = $this->thuyenChuyenSv->apiInsertOrUpdate($formData, $model)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function uploadImage(LinhMucThuyenChuyenRequest $request)
    {
        if ($request->is('options')) {
            return;
        }

        return $this->respondBadRequest();
    }
}
