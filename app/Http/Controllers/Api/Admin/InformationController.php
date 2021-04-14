<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\InformationModel as InfoSv;
use App\Http\Requests\InformationRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class InformationController extends ApiController
{
    protected $resourceName = 'information';

    /**
     * @var null
     */
    private $infoSv = null;

    /**
     * @author: dtphi .
     * InformationController constructor.
     * @param InfoSv $infoSv
     * @param array $middleware
     */
    public function __construct(InfoSv $infoSv, array $middleware = [])
    {
        $this->infoSv = $infoSv;
        parent::__construct($middleware);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $limit       = $this->_getPerPage();
            $collections = $this->infoSv->apiGetResourceCollection([], $limit);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $this->respondWithCollectionPagination($collections);
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

        $resourceId = ($this->getResource()) ? $this->getResource()->id : null;

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
            $info = $this->infoSv->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $info->destroy($id);

        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    /**
     * @author : dtphi .
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStore(&$request)
    {
        $requestParams = $request->all();

        if ($result = $this->infoSv->apiInsert($requestParams)) {
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
    private function __handleStoreUpdate(&$model,&$request)
    {
        $requestParams = $request->all();

        if ($result = $this->infoSv->apiUpdate($model,$requestParams)) {
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

    public function dropdown(Request $request)
    {
        $data = $request->all();

        $results = $this->infoSv->apiGetInformations($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'information_id' => $value->information_id,
                'name' => strip_tags(html_entity_decode($value->name, ENT_QUOTES, 'UTF-8')),
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }
}
