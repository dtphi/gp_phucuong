<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\ChucVuModel;
use App\Http\Resources\ChucVus\ChucVuCollection;
use App\Http\Resources\ChucVus\ChucVuResource;
use App\Models\ChucVu;
use App\Http\Common\Tables;
use DB;

final class ChucVuService implements BaseModel, ChucVuModel
{
    /**
     * @var ChucVu|null
     */
    private $model = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model    = new ChucVu();
    }

    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetChucVus($options);

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
     * @return ChucVuResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new ChucVuResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return ChucVu|bool|null
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

        return $model;
    }

    public function apiGetChucVus($data = array(), $limit = 5)
    {
        $query = $this->model->select()
        ->orderBy('id', 'DESC');

        return $query;
    }
}
