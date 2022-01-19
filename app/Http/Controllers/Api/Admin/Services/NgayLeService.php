<?php

namespace App\Http\Controllers\Api\Admin\Services;

use DB;
use App\Models\NgayLe;
use App\Http\Resources\NgayLes\NgayLeResource;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\NgayLeModel;

final class NgayLeService implements BaseModel, NgayLeModel
{
  
    /**
     * @var NgayLe|null
     */
    private $model = null;

    /**
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model    = new NgayLe();
    }

    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetNgayLes($options);
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
     * @param null $id
     * @return NgayLeResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new NgayLeResource($this->apiGetDetail($id));
    }

    /**
     * @param array $data
     * @return LeChinh|bool|null
     */
    public function apiInsertOrUpdate(array $data = [])
    {
        // TODO: Implement apiInsertOrUpdate() method.
        $this->model->fill($data);
        /**d
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

    public function apiGetNgayLes($data = array(), $limit = 5)
    {
        $query = $this->model->select()
        ->orderBy('id', 'DESC');
        return $query;
    }

    public function apiUpdate($model, $data = [])
  {
    $this->model->fill($data);
    DB::beginTransaction();
    if (!$this->model->save()) {
      DB::rollBack();
      return false;
    }
    DB::commit();
    return $this->model;
  }
}
