<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\ChucVuModel as ChucVuSv;
use App\Http\Requests\ChucVuRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class ChucVuController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'chuc_vu';

    /**
     * @var null
     */
    private $thanhSv = null;

    /**
     * @author: dtphi .
     * ChucVuController constructor.
     * @param ChucVuSv $thanhSv
     * @param array $middleware
     */
    public function __construct(ChucVuSv $thanhSv, array $middleware = [])
    {
        $this->thanhSv = $thanhSv;
        parent::__construct($middleware);
        $this->_initAuthor(new ChucVuRequest);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(ChucVuRequest $request)
    {
        $data = $request->all();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        $data['s_name'] = $request->query('name');
        $data['s_type_giao_xu'] = $request->query('type_giao_xu');
        $data['s_active'] = ($request->query('active') >= 0) ? $request->query('active') : -1;

        try {
            $limit       = $this->_getPerPage();
            $collections = $this->thanhSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            
            foreach ($collections as $key => $info) {
                $results[] = [
                    'id' => (int)$info->id,
                    'name'           => $info->name,
                    'sort_id'         => $info->sort_id,
                    'type_giao_xu'          => $info->type_giao_xu,
                    'vtbn'    => html_entity_decode($info->vtbn),
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
     * @param ChucVuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ChucVuRequest $request)
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
     * @param ChucVuRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ChucVuRequest $request, $id = null)
    {
        try {
            $model = $this->thanhSv->apiGetDetail($id);

        } catch (HandlerMsgCommon $e) {
            Log::debug('Chức vụ not found, Request ID = ' . $id);

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

        if ($result = $this->thanhSv->apiInsertOrUpdate($formData)) {
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
    public function uploadImage(ChucVuRequest $request)
    {
        if ($request->is('options')) {
            return;
        }

        return $this->respondBadRequest();
    }
}
