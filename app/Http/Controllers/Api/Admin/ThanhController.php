<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\ThanhModel as ThanhSv;
use App\Http\Requests\ThanhRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class ThanhController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'thanh';

    /**
     * @var null
     */
    private $thanhSv = null;

    /**
     * @author: dtphi .
     * ThanhController constructor.
     * @param ThanhSv $thanhSv
     * @param array $middleware
     */
    public function __construct(ThanhSv $thanhSv, array $middleware = [])
    {
        $this->thanhSv = $thanhSv;
        parent::__construct($middleware);
        $this->_initAuthor(new ThanhRequest);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(ThanhRequest $request)
    {
        $data = $request->all();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->thanhSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            
            foreach ($collections as $key => $info) {
                $results[] = [
                    'id' => (int)$info->id,
                    'name'           => $info->name,
                    'latin' => $info->latin,
                    'bon_mang'         => $info->bon_mang,
                    'ghi_chu'          => $info->ghi_chu,
                    'cuoc_doi'    => $info->cuoc_doi,
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
            $json = $this->thanhSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param ThanhRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ThanhRequest $request)
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
     * @param ThanhRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ThanhRequest $request, $id = null)
    {
        try {
            $model = $this->thanhSv->apiGetDetail($id);

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
            $model = $this->thanhSv->apiGetDetail($id);
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

        if ($result = $this->thanhSv->apiInsert($formData)) {
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

        if ($result = $this->thanhSv->apiInsertOrUpdate($formData, $model)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function uploadImage(ThanhRequest $request)
    {
        if ($request->is('options')) {
            return;
        }

        return $this->respondBadRequest();
    }
}
