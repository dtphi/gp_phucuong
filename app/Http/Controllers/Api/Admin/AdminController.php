<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Http\Resources\Admins\AdminCollection;
use App\Http\Resources\Admins\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
use App\Events\SearchUserEvent;
use App\Http\Controllers\Api\Admin\Services\Contracts\AdminModel as AdminSv;

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
     * @return AdminCollection|array
     */
    public function index(Request $request)
    {
        try {
            $limit = $this->_getPerPage();
            $json = $this->adSv->apiGetList([], $limit);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $this->respondWithCollectionPagination($json);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @param null $id
     * @return AdminResource
     */
    public function show(Request $request, $id = null)
    {
        return new AdminResource(Admin::findOrFail($id));
    }

    /**
     * @author : dtphi .
     * @param AdminRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdminRequest $request)
    {
        $user = new Admin();

        $storeResponse = $this->__handleStore($user, $request);

        if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        return $this->respondCreated("New {$this->resourceName} created.", $user->id);
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
            $user = Admin::findOrFail($id);

        } catch (ModelNotFoundException $e) {
            Log::debug('User not found, Request ID = ' . $id);

            return $this->respondNotFound();
        }

        return $this->__handleStore($user, $request);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id = null)
    {
        try {
            $user = Admin::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound("No {$this->resourceName} found.");
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
    private function __handleStore(Admin $user, &$request)
    {
        $requestParams = $request->all();
        $user->fill($requestParams);

        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        if (!$user->save()) {
            DB::rollBack();

            return $this->respondBadRequest();
        }

        DB::commit();

        return $this->respondUpdated();
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Http\JsonResponse
     */
    public function search () {
        $users = new AdminCollection(Admin::orderByDesc('email')->paginate());

        event(new SearchUserEvent($users));

        return response()->json("ok");
    }
}
