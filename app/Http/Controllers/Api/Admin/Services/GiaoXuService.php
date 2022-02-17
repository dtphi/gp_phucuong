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
use App\Models\LinhmucThuyenchuyen;
use App\Models\Linhmuc;

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
		$this->modelThuyenChuyen = new LinhmucThuyenchuyen();
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

	public function apiGetThuyenChuyen($infoId){
		$query = $this->modelThuyenChuyen->select()
		->where('giao_xu_id', $infoId)
		->get();

		return $query;
	}

	public function apiAddThuyenChuyen($data = []) 
    {		
				$hat = LinhMucThuyenChuyen::create(
				[
						'linh_muc_id' => $data['linh_muc_id'],
						'giao_xu_id' => $data['giaoxuId'],
						'chuc_vu_id' => $data['chuc_vu_id'],
						'from_giao_xu_id' => 0,
						'from_chuc_vu_id' => 0,
						'from_date' => $data['from_date'],
						'to_date' => $data['to_date'],
						'duc_cha_id' => '',
						'co_so_gp_id' => $data['co_so_gp_id'],
						'dong_id' => $data['dong_id'],
						'ban_chuyen_trach_id' => $data['ban_chuyen_trach_id'],
						'du_hoc' => $data['du_hoc'],
						'quoc_gia' => '',
						'active' => $data['active'],
						'ghi_chu' => $data['ghi_chu'],
						'chuc_vu_active' => $data['chuc_vu_active']
				]
			);

        return new GiaoXuCollection(LinhMucThuyenChuyen::where('giao_xu_id', $data['giaoxuId'])->get());
    }
		public function apiUpdateActiveThuyenChuyen($data = []) 
		{
				$this->modelThuyenChuyen = $this->modelThuyenChuyen->findOrFail($data['item']['id']);
				$this->modelThuyenChuyen->chuc_vu_active == 1 ? $this->modelThuyenChuyen->chuc_vu_active = 0 : $this->modelThuyenChuyen->chuc_vu_active = 1;
				DB::beginTransaction();
				if (!$this->modelThuyenChuyen->save()) {
						DB::rollBack();
						return false;
				}
				DB::commit();
				return $this->modelThuyenChuyen;
		}

		public function apiRemoveThuyenChuyen($data = []) {
			 	LinhmucThuyenChuyen::fcDeleteByGiaoXuThuyenChuyenId($data['giaoxuId'], $data['item']['id']);
		}

		public function apiUpdateThuyenChuyen($data = []) 
		{
				$this->modelThuyenChuyen = $this->modelThuyenChuyen->findOrFail($data['id_thuyen_chuyen']);
				$this->modelThuyenChuyen->linh_muc_id = $data['data']['linh_muc_id'];
				$this->modelThuyenChuyen->chuc_vu_id = $data['data']['chuc_vu_id'];
				$this->modelThuyenChuyen->from_date = $data['data']['from_date'];
				$this->modelThuyenChuyen->to_date = $data['data']['to_date'];

				DB::beginTransaction();
				if (!$this->modelThuyenChuyen->save()) {
						DB::rollBack();
						return false;
				}
				DB::commit();

				return new GiaoXuCollection(LinhMucThuyenChuyen::where('giao_xu_id', $data['giaoxuId'])->get());
	 	}
}
