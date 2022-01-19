<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\DongModel;
use App\Http\Resources\Dongs\DongCollection;
use App\Http\Resources\Dongs\DongResource;
use App\Models\Dong;
use App\Http\Common\Tables;
use DB;

final class DongService implements BaseModel, DongModel
{
  /**
   * @var Dong|null
   */
  private $model = null;

  /**
   * @author : dtphi .
   * AdminService constructor.
   */
  public function __construct()
  {
    $this->model    = new Dong();
  }

  public function apiGetList(array $options = [], $limit = 5)
  {
    // TODO: Implement apiGetList() method.
    $query = $this->apiGetDongs($options);

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
   * @return DongResource
   */
  public function apiGetResourceDetail($id = null)
  {
    // TODO: Implement apiGetResourceDetail() method.
    return new DongResource($this->apiGetDetail($id));
  }

  /**
   * @author : dtphi .
   * @param array $data
   * @return Dong|bool|null
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

  public function apiGetDongs($data = array(), $limit = 5)
  {
    $query = $this->model->select()
      ->orderBy('id', 'DESC');

    return $query;
  }
  
  // update dong
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
