<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucBangCapModel;
use App\Http\Resources\LinhMucBangCaps\LinhMucBangCapCollection;
use App\Http\Resources\LinhMucBangCaps\LinhMucBangCapResource;
use App\Models\LinhmucBangcap;
use App\Http\Common\Tables;
use DB;

final class LinhMucBangCapService implements BaseModel, LinhMucBangCapModel
{
    /**
     * @var LinhmucBangcap|null
     */
    private $model = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model    = new LinhmucBangcap();
    }

    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetLinhMucBangCaps($options);

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
     * @return LinhMucBangCapResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new LinhMucBangCapResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return LinhMucBangCap|bool|null
     */
    public function apiInsertOrUpdate(array $data = [], $model = null)
    {
        // TODO: Implement apiInsertOrUpdate() method.

        if (is_null($model)) {
            $model = $this->model;
        }

        $model->fill($data);

        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        if (!$model->save()) {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }

    public function apiGetLinhMucBangCaps($data = array(), $limit = 5)
    {
        $query = $this->model->select()
        ->orderBy('linh_muc_id', 'DESC');

        return $query;
    }
}
