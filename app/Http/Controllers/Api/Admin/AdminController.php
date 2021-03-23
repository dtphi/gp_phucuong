<?php

namespace App\Http\Controllers\Api\Admin;

use App\Events\SearchUserEvent;
use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use App\Http\Controllers\Api\Admin\Services\Contracts\AdminModel as AdminSv;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Log;

class AdminController extends ApiController
{
    /**
     * @var string
     */
    protected $resourceName = 'admin';

    /**
     * @var null
     */
    private $adSv = null;

    /**
     * @author: dtphi .
     * AdminController constructor.
     * @param AdminSv $adSv
     * @param array $middleware
     */
    public function __construct(AdminSv $adSv, array $middleware = [])
    {
        $this->adSv = $adSv;
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
            $collections = $this->adSv->apiGetResourceCollection([], $limit);
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
            $json = $this->adSv->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param AdminRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdminRequest $request)
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
     * @param AdminRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdminRequest $request, $id = null)
    {
        try {
            $this->adSv->apiGetDetail($id);

        } catch (HandlerMsgCommon $e) {
            Log::debug('User not found, Request ID = ' . $id);

            throw $e->render();
        }

        return $this->__handleStore($request);
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id = null)
    {
        try {
            $user = $this->adSv->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $user->destroy($id);

        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    /**
     * @author : dtphi .
     * @param Admin $user
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStore(&$request)
    {
        $requestParams = $request->all();

        if ($result = $this->adSv->apiInsertOrUpdate($requestParams)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Http\JsonResponse
     */
    public function search()
    {
        $collections = $this->adSv->apiGetResourceCollection(['email'], 0);

        event(new SearchUserEvent($collections));

        return response()->json("ok");
    }
}
