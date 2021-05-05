<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Helpers\Helper;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\SettingModel as SettingSv;
use App\Http\Requests\SettingRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class SettingController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'setting';

    /**
     * @var null
     */
    private $settingSv = null;

    /**
     * @author: dtphi .
     * SettingController constructor.
     * @param newsGpSv $settingSv
     * @param array $middleware
     */
    public function __construct(SettingSv $settingSv, array $middleware = [])
    {
        $this->settingSv = $settingSv;
        parent::__construct($middleware);
    }

        /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function show($id = null)
    {
        try {
            $json = $this->settingSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param SettingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SettingRequest $request)
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
     * @param SettingRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SettingRequest $request, $id = null)
    {
        try {
            $this->settingSv->apiGetDetail($id);

        } catch (HandlerMsgCommon $e) {
            Log::debug('User not found, Request ID = ' . $id);

            throw $e->render();
        }

        return $this->__handleStore($request);
    }

    /**
     * @author : dtphi .
     * @param Setting $setting
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStore(&$request)
    {
        $requestParams = $request->all();

        if ($result = $this->settingSv->apiInsertOrUpdate($requestParams)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }
}
