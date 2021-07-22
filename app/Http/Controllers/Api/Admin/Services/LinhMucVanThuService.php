<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucVanThuModel;
use App\Http\Resources\LinhMucVanThus\LinhMucVanThuCollection;
use App\Http\Resources\LinhMucVanThus\LinhMucVanThuResource;
use App\Models\LinhmucVanthu;
use App\Http\Common\Tables;
use DB;

final class LinhMucVanThuService implements BaseModel, LinhMucVanThuModel
{
    /**
     * @var LinhmucVanthu|null
     */
    private $model = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model    = new LinhmucVanthu();
    }

    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetLinhMucVanThus($options);

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
     * @return LinhMucVanThuResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new LinhMucVanThuResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return LinhMucVanThu|bool|null
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

    public function apiGetLinhMucVanThus($data = array(), $limit = 5)
    {
        $query = $this->model->select()
        ->orderBy('linh_muc_id', 'DESC');

        return $query;
    }
}
