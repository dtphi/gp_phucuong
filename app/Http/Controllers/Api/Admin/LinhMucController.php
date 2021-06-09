<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucModel as LinhMucSv;
use App\Http\Requests\InformationRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class LinhMucController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'linh-muc';

    /**
     * @var null
     */
    private $linhMucSv = null;

    /**
     * @author: dtphi .
     * InformationController constructor.
     * @param LinhMucSv $linhMucSv
     * @param array $middleware
     */
    public function __construct(LinhMucSv $linhMucSv, array $middleware = [])
    {
        $this->linhMucSv = $linhMucSv;
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
            $collections = $this->linhMucSv->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            
            $staticImgThum = self::$thumImgNo;
            foreach ($collections as $key => $info) {
                if (file_exists(public_path($info->image))) {
                    $staticImgThum = $info->image;
                }
                $results[] = [
                    'id' => (int)$info->id,
                    'ten'           => $info->ten,
                    'ten_thanh'         => $info->ten_thanh,
                    'image'          => $info->image,
                    'imgThum'        => url($this->getThumbnail($staticImgThum, 0, 40)),
                    //'status_text'    => $info->status_text,
                    'active'     => $info->active,
                    'updatetime' => $info->updatetime,
                    //'created_at'     => $info->created_at
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
            $json = $this->infoSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param InformationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InformationRequest $request)
    {
        $storeResponse = $this->__handleStore($request);

        if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        $resourceId = ($this->getResource()) ? $this->getResource()->information_id : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    /**
     * @author : dtphi .
     * @param InformationRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InformationRequest $request, $id = null)
    {
        try {
            $model = $this->infoSv->apiGetDetail($id);

        } catch (HandlerMsgCommon $e) {
            Log::debug('User not found, Request ID = ' . $id);

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
            $model = $this->infoSv->apiGetDetail($id);
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

        if ($result = $this->infoSv->apiInsert($formData)) {
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

        if ($result = $this->infoSv->apiUpdate($model, $formData)) {
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

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdown(Request $request)
    {
        $data = $request->all();

        $results     = $this->infoSv->apiGetList($data);
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
