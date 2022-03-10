<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucModel;
use App\Http\Resources\LinhMucs\LinhmucResource;
use App\Http\Resources\LinhMucBangCaps\LinhMucBangCapCollection;
use App\Http\Resources\LinhMucChucThanhs\LinhMucChucThanhCollection;
use App\Http\Resources\LinhMucVanThus\LinhMucVanThuCollection;
use App\Http\Resources\LinhMucThuyenChuyens\LinhMucThuyenChuyenCollection;
use App\Models\BanChuyenTrach;
use App\Models\ChucVu;
use App\Models\CoSoGiaoPhan;
use App\Models\Dong;
use App\Models\GiaoXu;
use App\Models\Linhmuc;
use App\Models\LinhmucBangcap;
use App\Models\LinhmucBoNhiem;
use App\Models\LinhmucChucthanh;
use App\Models\LinhmucGpThuyenChuyen;
use App\Models\LinhmucThuyenchuyen;
use App\Models\LinhmucVanthu;
use App\Models\Thanh;
use DB;

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
				$this->modelBoNhiem = new LinhmucBoNhiem();
				$this->modelLmGpThuyenChuyen = new LinhmucGpThuyenChuyen();
				$this->modelThuyenChuyen = new LinhmucThuyenchuyen();
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
}
