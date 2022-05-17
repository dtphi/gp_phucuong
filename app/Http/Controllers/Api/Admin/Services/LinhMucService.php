<?php

namespace App\Http\Controllers\Api\Admin\Services;

use DB;
use App\Models\Dong;
use App\Models\Thanh;
use App\Models\ChucVu;
use App\Models\GiaoXu;
use App\Models\Linhmuc;
use App\Models\LinhmucTemp;
use App\Models\CoSoGiaoPhan;
use App\Models\LinhmucVanthu;
use App\Models\BanChuyenTrach;
use App\Models\LinhmucBangcap;
use App\Models\LinhmucBoNhiem;
use App\Models\LinhmucChucthanh;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\LinhmucThuyenchuyen;
use App\Models\LinhmucGpThuyenChuyen;
use SebastianBergmann\Diff\Exception;
use App\Models\LinhmucThuyenchuyenTemp;
use App\Http\Resources\LinhMucs\LinhmucResource;
use App\Http\Resources\LinhMucVanThus\LinhMucVanThuCollection;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Resources\LinhMucBangCaps\LinhMucBangCapCollection;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucModel;
use App\Http\Resources\LinhMucChucThanhs\LinhMucChucThanhCollection;
use App\Http\Resources\LinhMucThuyenChuyens\LinhMucThuyenChuyenCollection;

final class LinhMucService implements BaseModel, LinhMucModel
{
    /**
     * @var Linhmuc|null
     */
    private $model = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model = new Linhmuc();
        $this->modelTemp = new LinhmucTemp();
				$this->modelBoNhiem = new LinhmucBoNhiem();
				$this->modelLmGpThuyenChuyen = new LinhmucGpThuyenChuyen();
				$this->modelThuyenChuyen = new LinhmucThuyenchuyen();
        $this->modelThuyenChuyenTemp = new LinhmucThuyenchuyenTemp();
    }

    public function apiGetList(array $options = [], $limit = 15)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetLinhmucs($options);

        return $query->paginate($limit);
    }

    public function apiGetResourceCollection(array $options = [], $limit = 15)
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

    public function apiGetDetailTemp($id = null)
    {
      // TODO: Implement apiGetDetail() method.
      $this->modelTemp = $this->modelTemp->find($id);

      return $this->modelTemp;
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return LinhmucResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new LinhmucResource($this->apiGetDetail($id));
    }

    public function apiGetResourceDetailTemp($id = null)
    {
      // TODO: Implement apiGetResourceDetail() method.
      return new LinhmucResource($this->apiGetDetailTemp($id));
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

    public function apiGetLinhmucs($data = array(), $limit = 15)
    {
        $query = $this->model->select()
            ->orderByDesc('updated_at');

        if (!empty($data['s_name'])) {
            $name = '%' . $data['s_name'] . '%';
            $query->where('ten', 'like', $name);
        }
        if (!empty($data['s_phone'])) {
            $phone = '%' . $data['s_phone'] . '%';
            $query->where('phone', 'like', $phone);
        }
        if (!empty($data['s_ngay_sinh'])) {
            $arrNs = explode('-', $data['s_ngay_sinh']);
            $ngaySinh = '%' . $arrNs[2] . '-' . $arrNs[1] . '-' . $arrNs[0] . '%';
            $query->where('ngay_thang_nam_sinh', 'like', $ngaySinh);
        }
        if (!empty($data['s_email'])) {
            $email = '%' . $data['s_email'] . '%';
            $query->where('email', 'like', $email);
        }
        if (!empty($data['s_noi_sinh'])) {
            $noiSinh = '%' . $data['s_noi_sinh'] . '%';
            $query->where('noi_sinh', 'like', $noiSinh);
        }
        if (!empty($data['s_noi_rua_toi'])) {
            $noiRuaToi = '%' . $data['s_noi_rua_toi'] . '%';
            $query->where('noi_rua_toi', 'like', $noiRuaToi);
        }
        if (!empty($data['s_noi_them_suc'])) {
            $noiThemSuc = '%' . $data['s_noi_them_suc'] . '%';
            $query->where('noi_them_suc', 'like', $noiThemSuc);
        }
        if (!empty($data['s_cmnd'])) {
            $cmnd = '%' . $data['s_cmnd'] . '%';
            $query->where('so_cmnd', 'like', $cmnd);
        }
        if (!is_null($data['s_trieu_dong']) && $data['s_trieu_dong'] >= 0) {
            $query->where('trieu_dong', $data['s_trieu_dong']);
        }
        if (!is_null($data['s_active']) && $data['s_active'] >= 0) {
            $query->where('active', $data['s_active']);
        }

        return $query;
    }

    public function apiInsert($data = [])
    {
        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        $this->model->fill($data);

        if ($this->model->save()) {
            $linhmucId = $this->model->id;

            if (isset($data['bang_caps']) && !empty($data['bang_caps'])) {
                foreach ($data['bang_caps'] as $bangcap) {
                    LinhmucBangcap::insertByLinhmucId($linhmucId, $bangcap['name'], $bangcap['type'],
                        $bangcap['ghi_chu'], $bangcap['active']);
                }
            }

            if (isset($data['chuc_thanhs']) && !empty($data['chuc_thanhs'])) {
                foreach ($data['chuc_thanhs'] as $chucThanh) {
                    LinhmucChucthanh::insertByLinhmucId($linhmucId, $chucThanh['chuc_thanh_id'],
                        $chucThanh['ngay_thang_nam_chuc_thanh'], $chucThanh['noi_thu_phong'],
                        $chucThanh['nguoi_thu_phong'],
                        $chucThanh['active'], $chucThanh['ghi_chu']);
                }
            }

            if (isset($data['thuyen_chuyens']) && !empty($data['thuyen_chuyens'])) {
                foreach ($data['thuyen_chuyens'] as $thCh) {
                    LinhmucThuyenchuyen::insertByLinhmucId($linhmucId, $thCh['from_giao_xu_id'],
                        $thCh['from_chuc_vu_id'], $thCh['from_date'], $thCh['duc_cha_id'], $thCh['to_date'],
                        $thCh['chuc_vu_id'], $thCh['giao_xu_id'], $thCh['co_so_gp_id'], $thCh['dong_id'],
                        $thCh['ban_chuyen_trach_id'], $thCh['du_hoc'], $thCh['quoc_gia'], $thCh['active'],
                        $thCh['ghi_chu']);
                }
            }

            if (isset($data['van_thus']) && !empty($data['van_thus'])) {
                foreach ($data['van_thus'] as $vanThu) {
                    LinhmucVanthu::insertByLinhmucId($linhmucId, $vanThu['title'], $vanThu['type'], $vanThu['active'],
                        $vanThu['ghi_chu']);
                }
            }

            if (isset($data['bo_nhiems']) && !empty($data['bo_nhiems'])) {
                foreach ($data['bo_nhiems'] as $boNhiem) {
                    LinhmucBoNhiem::insertByLinhmucId($linhmucId, $boNhiem['chuc_vu_id'], $boNhiem['cong_viec'],
                        $boNhiem['cong_viec_tu_ngay'], $boNhiem['cong_viec_tu_thang'], $boNhiem['cong_viec_tu_nam'],
                        $boNhiem['cong_viec_den_ngay'], $boNhiem['cong_viec_den_thang'], $boNhiem['cong_viec_den_nam'],
                        $boNhiem['active']);
                }
            }
        } else {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }

    private function _addBoNhiem($linhmucId, $boNhiem)
    {
        LinhmucBoNhiem::insertByLinhmucId($linhmucId, $boNhiem['chuc_vu_id'], $boNhiem['cong_viec'],
            $boNhiem['cong_viec_tu_ngay'], $boNhiem['cong_viec_tu_thang'], $boNhiem['cong_viec_tu_nam'],
            $boNhiem['cong_viec_den_ngay'], $boNhiem['cong_viec_den_thang'], $boNhiem['cong_viec_den_nam'],
            $boNhiem['active']);
    }

    private function _removeBoNhiem($linhmucId, $boNhiem)
    {
        LinhmucBoNhiem::fcDeleteById($linhmucId, $boNhiem['id']);
    }

    private function _addLmThuyenChuyen($linhmucId, $model)
    {
        LinhmucGpThuyenChuyen::insertByLinhmucId($linhmucId, $model['chuc_vu_id'], $model['dia_diem_id'], $model['dia_diem_loai'],
            $model['dia_diem_tu_ngay'], $model['dia_diem_tu_thang'], $model['dia_diem_tu_nam'],
            $model['dia_diem_den_ngay'], $model['dia_diem_den_thang'], $model['dia_diem_den_nam'],
            $model['active']);
    }

    private function _removeLmThuyenChuyen($linhmucId, $model)
    {
        LinhmucGpThuyenChuyen::fcDeleteById($linhmucId, $model['id']);
    }

    private function _updateLinhMuc($model, $data)
    {
        $linhmucId = $model->id;

        LinhmucBangcap::fcDeleteByLinhmucId($linhmucId);
        if (isset($data['bang_caps']) && !empty($data['bang_caps'])) {
            foreach ($data['bang_caps'] as $bangcap) {
                LinhmucBangcap::insertByLinhmucId($linhmucId, $bangcap['name'], $bangcap['type'],
                    $bangcap['ghi_chu'], $bangcap['active']);
            }
        }

        LinhmucChucthanh::fcDeleteByLinhmucId($linhmucId);
        if (isset($data['chuc_thanhs']) && !empty($data['chuc_thanhs'])) {
            foreach ($data['chuc_thanhs'] as $chucThanh) {
                LinhmucChucthanh::insertByLinhmucId($linhmucId, $chucThanh['chuc_thanh_id'],
                    $chucThanh['ngay_thang_nam_chuc_thanh'], $chucThanh['noi_thu_phong'],
                    $chucThanh['nguoi_thu_phong'],
                    $chucThanh['active'], $chucThanh['ghi_chu']);
            }
        }

        // LinhmucThuyenchuyen::fcDeleteByLinhmucId($linhmucId);
        // if (isset($data['thuyen_chuyens']) && !empty($data['thuyen_chuyens'])) {
        //     foreach ($data['thuyen_chuyens'] as $thCh) {
        //         LinhmucThuyenchuyen::insertByLinhmucId($linhmucId, $thCh['from_giao_xu_id'],
        //             $thCh['from_chuc_vu_id'], $thCh['from_date'], $thCh['duc_cha_id'], $thCh['to_date'],
        //             $thCh['chuc_vu_id'], $thCh['giao_xu_id'], $thCh['co_so_gp_id'], $thCh['dong_id'],
        //             $thCh['ban_chuyen_trach_id'], $thCh['du_hoc'], $thCh['quoc_gia'], $thCh['active'],
        //             $thCh['ghi_chu'], $thCh['is_bo_nhiem']);
        //     }
        // }

        LinhmucVanthu::fcDeleteByLinhmucId($linhmucId);
        if (isset($data['van_thus']) && !empty($data['van_thus'])) {
            foreach ($data['van_thus'] as $vanThu) {
                LinhmucVanthu::insertByLinhmucId($linhmucId, $vanThu['title'], $vanThu['type'], $vanThu['active'],
                    $vanThu['ghi_chu']);
            }
        }
    }

    public function deleteInformation($model = null) {
        DB::beginTransaction();
      try {
        $id = $model->id;
        $this->_deleteById($id);
        DB::commit();
      } catch (\Exceptions $e) {
        DB::rollBack();
        throw $e;
        return false;
      }
    }

    private function _deleteById($id)
    {      
      Linhmuc::fcDeleteById($id);
      LinhmucBangcap::fcDeleteByLinhmucId($id);
      LinhmucChucthanh::fcDeleteByLinhmucId($id);
      LinhmucThuyenchuyen::fcDeleteByLinhmucId($id);
    }

		private function _removeThuyenChuyen($linhmucId, $model)
    {
        LinhmucThuyenChuyen::fcDeleteByLinhmucThuyenChuyenId($linhmucId, $model['id']);
    }

    public function apiUpdate($model, $data = [])
    {
        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();
        if ($data['action'] == 'add.bo.nhiem') {
            $this->_addBoNhiem($data['id'], $data['bo_nhiem']);
        } elseif ($data['action'] == 'add.lm.thuyen.chuyen') {
            $this->_addLmThuyenChuyen($data['id'], $data['lm_thuyen_chuyen']);
        } elseif ($data['action'] == 'remove.lm.thuyen.chuyen') {
            $this->_removeLmThuyenChuyen($data['id'], $data['lm_thuyen_chuyen']);
        } elseif ($data['action'] == 'remove.thuyen.chuyen' || $data['action'] == 'remove.bo.nhiem') {
					$this->_removeThuyenChuyen($data['id'], $data['item']);
				} else {
            $model->fill($data);
            if ($model->save()) {
                $this->_updateLinhMuc($model, $data);
            } else {
                DB::rollBack();
                return false;
            }
        }
        DB::commit();
        return $model;
    }

    public function apiGetGiaoXuList($data = [])
    {
        $model = new GiaoXu();

        $query = $model->select()
            ->where('type', 'giaoxu')
            ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiGetThanhList($data = [])
    {
        $model = new Thanh();

        $query = $model->select()
            ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiGetChucVuList($data = [])
    {
        $model = new ChucVu();

        $query = $model->select()
            ->orderBy('sort_id', 'asc');

        return $query->get();
    }

    public function apiGetDucChaList($data = [])
    {
        $model = new Linhmuc();
        $query = $model->select()
            ->where('is_duc_cha', '=', 1)
            ->orderBy('ten', 'DESC');

        return $query->get();
    }

    public function apiGetCoSoGiaoPhanList($data = [])
    {
        $model = new CoSoGiaoPhan();
        $query = $model->select()
            ->where('coso_giaophan', '=', 1)
            ->orderBy('name', 'DESC');
        return $query->get();
    }

    public function apiGetDongList($data = [])
    {
        $model = new Dong();
        $query = $model->select()
            ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiGetBanChuyenTrachList($data = [])
    {
        $model = new BanChuyenTrach();
        $query = $model->select()
            ->orderBy('name', 'DESC');

        return $query->get();
    }

		public function apiGetLinhMucList($data = [])
    {
        $model = new LinhMuc();
        $query = $model->select()
						->where('active', 1)
            ->orderBy('ten', 'DESC');

        return $query->get();
    }

    public function apiGetCongDoanNgoaiGiaoPhanList($data = [])
    {
        $model = new CoSoGiaoPhan();
        $query = $model->select()
        ->where('active', 1)
        ->where('coso_giaophan', '=', 0)
        ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiUpdateBangCap($data = []) 
    {
        $hat = LinhMucBangCap::updateOrCreate(
            [
                'id' => $data['id'], 
                'linh_muc_id' => $data['linhMucId']
            ],
            [
                'name' => $data['name'],
                'type' => $data['type'],
                'active' => $data['active'],
                'ghi_chu' => $data['ghi_chu']
            ]
        );

        return new LinhMucBangCapCollection(LinhMucBangCap::where('linh_muc_id', $data['linhMucId'])->get());
    }

    public function apiUpdateChucThanh($data = []) 
    {
        $hat = LinhMucChucThanh::updateOrCreate(
            [
                'id' => $data['id'], 
                'linh_muc_id' => $data['linhMucId']
            ],
            [
                'chuc_thanh_id' => $data['chuc_thanh_id'],
                'ngay_thang_nam_chuc_thanh' => $data['ngay_thang_nam_chuc_thanh'],
                'noi_thu_phong' => $data['noi_thu_phong'],
                'nguoi_thu_phong' => $data['nguoi_thu_phong'],
                'active' => $data['active'],
                'ghi_chu' => $data['ghi_chu']
            ]
        );

        return new LinhMucChucThanhCollection(LinhMucChucThanh::where('linh_muc_id', $data['linhMucId'])->get());
    }

    public function apiUpdateVanThu($data = []) 
    {
        $hat = LinhMucVanThu::updateOrCreate(
            [
                'id' => $data['id'], 
                'linh_muc_id' => $data['linhMucId']
            ],
            [
                'title' => $data['title'],
                'type' => $data['type'],
                'active' => $data['active'],
                'ghi_chu' => $data['ghi_chu']
            ]
        );

        return new LinhMucVanThuCollection(LinhMucVanThu::where('linh_muc_id', $data['linhMucId'])->get());
    }

    public function apiUpdateThuyenChuyen($data = []) 
    {
				$this->modelThuyenChuyen = $this->modelThuyenChuyen->findOrFail($data['id_thuyen_chuyen']);
				if($data['data']['dia_diem_tu_nam'] == null || $data['data']['dia_diem_tu_thang'] == null || $data['data']['dia_diem_tu_ngay'] == null) {
						$this->modelThuyenChuyen->from_date = null;
				}else {
					$this->modelThuyenChuyen->from_date = $data['data']['dia_diem_tu_nam'] .'-'. $data['data']['dia_diem_tu_thang'] .'-'. $data['data']['dia_diem_tu_ngay'];
				}		
				
				if($data['data']['dia_diem_den_nam'] == null || $data['data']['dia_diem_den_thang'] == null || $data['data']['dia_diem_den_ngay'] == null) {
						$this->modelThuyenChuyen->to_date = null;
				}else {
						$this->modelThuyenChuyen->to_date = $data['data']['dia_diem_den_nam'] .'-'. $data['data']['dia_diem_den_thang'] .'-'. $data['data']['dia_diem_den_ngay'];
				}
				$this->modelThuyenChuyen->chuc_vu_id = $data['data']['chuc_vu_id'];	
				$this->modelThuyenChuyen->giao_xu_id = $data['data']['giao_xu_id'];	
				$this->modelThuyenChuyen->co_so_gp_id = $data['data']['co_so_gp_id'];
				$this->modelThuyenChuyen->dong_id = $data['data']['dong_id'];
				$this->modelThuyenChuyen->ban_chuyen_trach_id = $data['data']['ban_chuyen_trach_id'];
				$this->modelThuyenChuyen->du_hoc = $data['data']['du_hoc'];
				$this->modelThuyenChuyen->ghi_chu = $data['data']['ghi_chu'];
				DB::beginTransaction();
				if (!$this->modelThuyenChuyen->save()) {
						DB::rollBack();
						return false;
				}
				DB::commit();
    }

		public function apiUpdateBoNhiem($data = []) 
    {
				$this->modelThuyenChuyen = $this->modelThuyenChuyen->findOrFail($data['id_bo_nhiem']);
				if($data['data']['cong_viec_tu_nam'] == null || $data['data']['cong_viec_tu_thang'] == null || $data['data']['cong_viec_tu_ngay'] == null) {
						$this->modelThuyenChuyen->from_date = null;
				}else {
					$this->modelThuyenChuyen->from_date = $data['data']['cong_viec_tu_nam'] .'-'. $data['data']['cong_viec_tu_thang'] .'-'. $data['data']['cong_viec_tu_ngay'];
				}		
				
				if($data['data']['cong_viec_den_nam'] == null || $data['data']['cong_viec_den_thang'] == null || $data['data']['cong_viec_den_ngay'] == null) {
						$this->modelThuyenChuyen->to_date = null;
				}else {
						$this->modelThuyenChuyen->to_date = $data['data']['cong_viec_den_nam'] .'-'. $data['data']['cong_viec_den_thang'] .'-'. $data['data']['cong_viec_den_ngay'];
				}
				$this->modelThuyenChuyen->chuc_vu_id = $data['data']['chuc_vu_id'];
				$this->modelThuyenChuyen->ghi_chu = $data['data']['cong_viec'];
				DB::beginTransaction();
				if (!$this->modelThuyenChuyen->save()) {
						DB::rollBack();
						return false;
				}
				DB::commit();
    }

		public function apiUpdateActiveBoNhiem($id_bo_nhiem) {
				$this->modelBoNhiem = $this->modelBoNhiem->findOrFail($id_bo_nhiem);
				if($this->modelBoNhiem->active == 1) {
					$this->modelBoNhiem->active = 0;
				}else {
					$this->modelBoNhiem->active = 1;
				}
				DB::beginTransaction();
				if (!$this->modelBoNhiem->save()) {
						DB::rollBack();
						return false;
				}
				DB::commit();
				return $this->modelBoNhiem;
		}

		public function apiUpdateActiveLmThuyenChuyen($id_thuyen_chuyen) {
				$this->modelLmGpThuyenChuyen = $this->modelLmGpThuyenChuyen->findOrFail($id_thuyen_chuyen);
				if($this->modelLmGpThuyenChuyen->active == 1) {
					$this->modelLmGpThuyenChuyen->active = 0;
				}else {
					$this->modelLmGpThuyenChuyen->active = 1;
				}
				DB::beginTransaction();
				if (!$this->modelLmGpThuyenChuyen->save()) {
						DB::rollBack();
						return false;
				}
				DB::commit();
				return $this->modelLmGpThuyenChuyen;
		}

		public function apiUpdateActiveThuyenChuyen($id_thuyen_chuyen) {
			
			$this->modelThuyenChuyen = $this->modelThuyenChuyen->findOrFail($id_thuyen_chuyen);

			if($this->modelThuyenChuyen->chuc_vu_active == 1) {
				$this->modelThuyenChuyen->chuc_vu_active = 0;
			}else {
				$this->modelThuyenChuyen->chuc_vu_active = 1;
			}

			DB::beginTransaction();
			if (!$this->modelThuyenChuyen->save()) {
					DB::rollBack();
					return false;
			}
			DB::commit();
			return $this->modelThuyenChuyen;
		}

		public function apiGetThuyenChuyen($infoId = null){
				$query = $this->modelThuyenChuyen->select()
				->where('linh_muc_id', $infoId)
				->where('is_bo_nhiem', '!=', 1)
				->orderBy('from_date', 'DESC')
				->get();

				return $query;
		}

    public function apiGetThuyenChuyenTemp($infoId = null)
    {
      $query = $this->modelThuyenChuyenTemp->select()
      ->where('linh_muc_id', $infoId)
      ->orderBy('from_date', 'DESC')
      ->get();

      return $query;
    }

		public function apiGetBoNhiem($infoId = null){
			$query = $this->modelThuyenChuyen->select()
			->where('linh_muc_id', $infoId)
			->where('is_bo_nhiem', 1)
			->orderBy('from_date', 'DESC')
			->get();

			return $query;
		}

		public function apiAddThuyenChuyen($data = []) 
    {		
				if($data['dia_diem_tu_nam'] == null || $data['dia_diem_tu_thang'] == null || $data['dia_diem_tu_ngay'] == null) {
						$data['from_date'] = null;
				}else {
						$data['from_date'] = $data['dia_diem_tu_nam'] .'-'. $data['dia_diem_tu_thang'] .'-'. $data['dia_diem_tu_ngay'];
				}		

				if($data['dia_diem_den_nam'] == null || $data['dia_diem_den_thang'] == null || $data['dia_diem_den_ngay'] == null) {
						$data['to_date'] = null;
				}else {
						$data['to_date'] = $data['dia_diem_den_nam'] .'-'. $data['dia_diem_den_thang'] .'-'. $data['dia_diem_den_ngay'];
				}

				$hat = LinhMucThuyenChuyen::create(
				[
						'linh_muc_id' => $data['linhMucId'],
						'giao_xu_id' => $data['giao_xu_id'],
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

        return new LinhMucThuyenChuyenCollection(LinhMucThuyenChuyen::where('linh_muc_id', $data['linhMucId'])->get());
    }

		public function apiAddBoNhiem($data = []) 
    {		
				if($data['cong_viec_tu_nam'] == null || $data['cong_viec_tu_thang'] == null || $data['cong_viec_tu_ngay'] == null) {
						$data['from_date'] = null;
				}else {
						$data['from_date'] = $data['cong_viec_tu_nam'] .'-'. $data['cong_viec_tu_thang'] .'-'. $data['cong_viec_tu_ngay'];
				}		

				if($data['cong_viec_den_nam'] == null || $data['cong_viec_den_thang'] == null || $data['cong_viec_den_ngay'] == null) {
						$data['to_date'] = null;
				}else {
						$data['to_date'] = $data['cong_viec_den_nam'] .'-'. $data['cong_viec_den_thang'] .'-'. $data['cong_viec_den_ngay'];
				}

				$hat = LinhMucThuyenChuyen::create(
				[
						'linh_muc_id' => $data['linhMucId'],
						'giao_xu_id' => 0,
						'chuc_vu_id' => $data['chuc_vu_id'],
						'from_giao_xu_id' => 0,
						'from_chuc_vu_id' => 0,
						'from_date' => $data['from_date'],
						'to_date' => $data['to_date'],
						'duc_cha_id' => '',
						'co_so_gp_id' => 0,
						'dong_id' => 0,
						'ban_chuyen_trach_id' => 0,
						'du_hoc' => 0,
						'quoc_gia' => '',
						'active' => $data['active'],
						'ghi_chu' => $data['cong_viec'],			
						'chuc_vu_active' => 1,
						'is_bo_nhiem' => 1,
				]
			);

        return new LinhMucThuyenChuyenCollection(LinhMucThuyenChuyen::where('linh_muc_id', $data['linhMucId'])->where('is_bo_nhiem', 1)->orderBy('from_date', 'DESC')->get());
    }

    public function apiCapNhatLinhMuc($data = []) {
        $newTbLinhMuc = $this->modelTemp->find($data['id']);
        $oldTbLinhMuc = $this->model->find($data['id']);
        DB::beginTransaction();
          $oldTbLinhMuc->ten_thanh_id = $newTbLinhMuc->ten_thanh_id;
          $oldTbLinhMuc->ten = $newTbLinhMuc->ten;
          $oldTbLinhMuc->ngay_thang_nam_sinh = $newTbLinhMuc->ngay_thang_nam_sinh;
          $oldTbLinhMuc->noi_sinh = $newTbLinhMuc->noi_sinh;
          $oldTbLinhMuc->giao_xu_id = $newTbLinhMuc->giao_xu_id;
          $oldTbLinhMuc->ho_ten_cha = $newTbLinhMuc->ho_ten_cha;
          $oldTbLinhMuc->ho_ten_me = $newTbLinhMuc->ho_ten_me;
          $oldTbLinhMuc->noi_rua_toi = $newTbLinhMuc->noi_rua_toi;
          $oldTbLinhMuc->ngay_rua_toi = $newTbLinhMuc->ngay_rua_toi;
          $oldTbLinhMuc->noi_them_suc = $newTbLinhMuc->noi_them_suc;
          $oldTbLinhMuc->ngay_them_suc = $newTbLinhMuc->ngay_them_suc;
          $oldTbLinhMuc->tieu_chung_vien = $newTbLinhMuc->tieu_chung_vien;
          $oldTbLinhMuc->ngay_tieu_chung_vien = $newTbLinhMuc->ngay_tieu_chung_vien;
          $oldTbLinhMuc->dai_chung_vien = $newTbLinhMuc->dai_chung_vien;
          $oldTbLinhMuc->ngay_dai_chung_vien = $newTbLinhMuc->ngay_dai_chung_vien;
          $oldTbLinhMuc->image = $newTbLinhMuc->image;
          $oldTbLinhMuc->so_cmnd = $newTbLinhMuc->so_cmnd;
          $oldTbLinhMuc->ngay_cap_cmnd = $newTbLinhMuc->ngay_cap_cmnd;
          $oldTbLinhMuc->noi_cap_cmnd = $newTbLinhMuc->noi_cap_cmnd;
          $oldTbLinhMuc->code = $newTbLinhMuc->code;
          $oldTbLinhMuc->phone = $newTbLinhMuc->phone;
          $oldTbLinhMuc->email = $newTbLinhMuc->email;
          $oldTbLinhMuc->ngay_trieu_dong = $newTbLinhMuc->ngay_trieu_dong;
          $oldTbLinhMuc->ngay_khan = $newTbLinhMuc->ngay_khan;
          $oldTbLinhMuc->ghi_chu = $newTbLinhMuc->ghi_chu;
          $oldTbLinhMuc->is_duc_cha = $newTbLinhMuc->is_duc_cha;
          $oldTbLinhMuc->cham_ngon = $newTbLinhMuc->cham_ngon;
          $oldTbLinhMuc->sinh_giao_xu = $newTbLinhMuc->sinh_giao_xu;
          if (!$oldTbLinhMuc->save()) {
            DB::rollBack();
            return false;
          }
          $newTbLinhMuc->delete();
          DB::commit();
    }

    public function apiCapNhatThuyenChuyen($data = []) 
    {
      try {
        DB::beginTransaction();
        $old_thuyenchuyens_delete = $this->modelThuyenChuyen->where('linh_muc_id', $data['id'])->delete(); // delete thuyenchuyen by linh_muc_id
        $new_thuyenchuyens_arr = $this->modelThuyenChuyenTemp->where('linh_muc_id', $data['id'])->get()->toArray();
        foreach ($new_thuyenchuyens_arr as $value) {
          $info_thuyenchuyen = new LinhmucThuyenchuyen;
          $info_thuyenchuyen->linh_muc_id = $value['linh_muc_id'];
          $info_thuyenchuyen->from_giao_xu_id = $value['from_giao_xu_id'];
          $info_thuyenchuyen->from_chuc_vu_id = $value['from_chuc_vu_id'];
          $info_thuyenchuyen->from_date = $value['from_date'];
          $info_thuyenchuyen->duc_cha_id = $value['duc_cha_id'];
          $info_thuyenchuyen->to_date = $value['to_date'];
          $info_thuyenchuyen->chuc_vu_id = $value['chuc_vu_id'];
          $info_thuyenchuyen->giao_xu_id = $value['giao_xu_id'];
          $info_thuyenchuyen->dong_id = $value['dong_id'];
          $info_thuyenchuyen->ban_chuyen_trach_id = $value['ban_chuyen_trach_id'];
          $info_thuyenchuyen->du_hoc = $value['du_hoc'];
          $info_thuyenchuyen->co_so_gp_id = $value['co_so_gp_id'];
          $info_thuyenchuyen->quoc_gia = $value['quoc_gia'];
          $info_thuyenchuyen->ghi_chu = $value['ghi_chu'];
          $info_thuyenchuyen->active = $value['active'];
          $info_thuyenchuyen->chuc_vu_active = $value['chuc_vu_active'];
          $info_thuyenchuyen->update_user = $value['update_user'];
          $info_thuyenchuyen->is_bo_nhiem = $value['is_bo_nhiem'];
          $info_thuyenchuyen->save();
        }
        if (!$info_thuyenchuyen->save()) {
          DB::rollBack();
          return false;
        }

        $new_thuyenchuyens_delete = $this->modelThuyenChuyenTemp->where('linh_muc_id', $data['id'])->delete(); // delete thuyenchuyen_temp by linh_muc_id
        DB::commit();
        
      } catch (\Exception  $e) {
        DB::rollback();
        throw $e;
      }
    } 
}
