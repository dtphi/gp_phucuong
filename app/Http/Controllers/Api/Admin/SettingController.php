<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\SettingModel as SettingSv;
use App\Http\Requests\SettingRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

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
        $this->_initAuthor(new SettingRequest);
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function show($code = null)
    {
        try {
            $json = $this->settingSv->apiGetResourceCollection(['code' => $code]);
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

        $resourceId = ($this->getResource()) ? $this->getResource() : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
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
