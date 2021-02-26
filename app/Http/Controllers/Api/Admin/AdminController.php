<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Http\Resources\Admins\AdminCollection;
use App\Http\Resources\Admins\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;

class AdminController extends ApiController
{
    protected $resourceName = 'admin';

    public function index(Request $request)
    {
        return new AdminCollection(Admin::orderByDesc('id')->paginate($this->_getPerPage()));
    }

    public function show(Request $request, $id = null)
    {
        return new AdminResource(Admin::findOrFail($id));
    }

    public function store(AdminRequest $request)
    {
        $user = new Admin();

        $storeResponse = $this->__handleStore($user, $request);

        if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        return $this->respondCreated("New {$this->resourceName} created.", $user->id);
    }

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
}
