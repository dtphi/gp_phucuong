<?php

namespace App\Http\Controllers\Api\Admin\Services;

use DB;
use App\Models\GiaoXu;
use App\Models\GiaoHat;
use App\Http\Common\Tables;
use App\Models\GiaoPhanHatXu;
use App\Http\Resources\GiaoXus\GiaoXuResource;
use App\Http\Resources\GiaoXus\GiaoXuCollection;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoXuModel;

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
    $this->modelGiaoHat = new GiaoHat();
    $this->modelPhanHatXu = new GiaoPhanHatXu();
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
    if($data['idGiaoHat'] == 0 || $data['idGiaoHat'] == -1) {
      $query = $this->model->select()
      ->where('type', 'giaoxu')
      ->orderByDesc('id');
    }else {
      $query = $this->modelPhanHatXu->where('giao_hat_id', $data['idGiaoHat'])->with(['giaoXu']);
    }

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

  public function apiGetListGiaoHat() {
    $query = $this->modelGiaoHat->select()
            ->orderBy('id', 'ASC')->get();
    return $query;
  }

  public function apiGetListByIdGiaoHat($id = null, $limit) {
      $query = $this->modelPhanHatXu->where('giao_hat_id', $id)->with(['giaoXu']);
      return $query->paginate($limit);
  }
}
