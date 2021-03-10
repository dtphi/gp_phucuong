<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\AdminModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Resources\Admins\AdminCollection;
use App\Http\Resources\Admins\AdminResource;
use App\Models\Admin;
use DB;

final class AdminService implements BaseModel, AdminModel
{
    /**
     * @var Admin|null
     */
    private $model = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model = new Admin();
    }

    /**
     * @author: dtphi .
     * @param array $options
     * @param int $limit
     * @return AdminCollection
     */
    public function apiGetList(array $options = [], $limit = 15)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->model->orderByDescById();

        return $query->paginate($limit);
    }

    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return AdminCollection
     */
    public function apiGetResourceCollection(array $options = [], $limit = 15)
    {
        // TODO: Implement apiGetResourceCollection() method.
        return new AdminCollection($this->apiGetList($options, $limit));
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return AdminResource
     */
    public function apiGetDetail($id = null)
    {
        // TODO: Implement apiGetDetail() method.
        $this->model = $this->model->findOrFail($id);

        return $this->model;
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return AdminResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new AdminResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return Admin|bool|null
     */
    public function apiInsertOrUpdate(array $data = [])
    {
        // TODO: Implement apiInsertOrUpdate() method.
        $this->model->fill($data);

        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        if (!$this->model->save()) {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }
}
