<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoHatModel;
use App\Http\Resources\GiaoHats\GiaoHatCollection;
use App\Http\Resources\GiaoHats\GiaoHatResource;
use App\Models\GiaoHat;
use App\Http\Common\Tables;
use DB;

final class GiaoHatService implements BaseModel, GiaoHatModel
{
    private $model = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model    = new GiaoHat();
    }

    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetGiaoHats($options);

        return $query->paginate($limit);
    }

    
    public function apiGetResourceCollection(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetResourceCollection() method.
        return null;
    }

    public function apiGetDetail($id = null)
    {
        // TODO: Implement apiGetDetail() method.
        $this->model = $this->model->findOrFail($id);

        return $this->model;
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return GiaoHatResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new GiaoHatResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return GiaoHat|bool|null
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

    public function apiGetGiaoHats($data = array(), $limit = 5)
    {
        $query = $this->model->select()
        ->orderBy('id', 'DESC');

        return $query;
    }
}
