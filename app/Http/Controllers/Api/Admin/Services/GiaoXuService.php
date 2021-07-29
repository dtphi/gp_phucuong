<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoXuModel;
use App\Http\Resources\GiaoXus\GiaoXuCollection;
use App\Http\Resources\GiaoXus\GiaoXuResource;
use App\Models\GiaoXu;
use App\Http\Common\Tables;
use DB;

final class GiaoXuService implements BaseModel, GiaoXuModel
{
  /**
   * @var GiaoXu|null
   */
  private $model = null;

  /**
   * @author : dtphi .
   * AdminService constructor.
   */
  public function __construct()
  {
    $this->model    = new GiaoXu();
  }

  public function apiGetList(array $options = [], $limit = 5)
  {
    // TODO: Implement apiGetList() method.
    $query = $this->apiGetGiaoXus($options);

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
   * @return GiaoXuResource
   */
  public function apiGetResourceDetail($id = null)
  {
    // TODO: Implement apiGetResourceDetail() method.
    return new GiaoXuResource($this->apiGetDetail($id));
  }

  /**
   * @author : dtphi .
   * @param array $data
   * @return GiaoXu|bool|null
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

  public function apiGetGiaoXus($data = array(), $limit = 5)
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
