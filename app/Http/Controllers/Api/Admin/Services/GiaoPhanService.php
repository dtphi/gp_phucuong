<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoPhanModel;
use App\Http\Resources\GiaoPhans\GiaoPhanCollection;
use App\Http\Resources\GiaoPhans\GiaoPhanResource;
use App\Models\GiaoPhan;
use App\Models\GiaoPhanHat;
use App\Models\GiaoPhanHatXu;
use App\Models\GiaoPhanHatCongDoanTuSi;
use App\Models\GiaoPhanDong;
use App\Models\GiaoPhanCoSo;
use App\Models\GiaoPhanBanChuyenTrach;
use App\Models\GiaoHat;
use App\Models\GiaoDiem;
use App\Models\CongDoanTuSi;
use App\Http\Common\Tables;
use DB;

final class GiaoPhanService implements BaseModel, GiaoPhanModel
{
    /**
     * @var GiaoPhan|null
     */
    private $model = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model    = new GiaoPhan();
    }

    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetGiaoPhans($options);

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
     * @return GiaoPhanResource
     */
    public function apiGetResourceDetail($id = null)
    {
        // TODO: Implement apiGetResourceDetail() method.
        return new GiaoPhanResource($this->apiGetDetail($id));
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return GiaoPhan|bool|null
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

    public function apiInsert($data = [])
    {
        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        $this->model->fill($data);

        if ($this->model->save()) {
            $giaoPhanId = $this->model->id;

            if (isset($data['hats']) && !empty($data['hats'])) {
                foreach ($data['hats'] as $hat) {
                    GiaoPhanHat::insertByGiaoPhanId($giaoPhanId, $hat['giao_hat_id'],$hat['active']);
                    if (isset($hat['giao_xus'])) {
                        foreach ($hat['giao_xus'] as $giaoXu) {
                            GiaoPhanHatXu::insertByGiaoHatId($giaoPhanId, $hat['giao_hat_id'], $giaoXu['giao_xu_id'], $giaoXu['active']);
                        }
                    }
                    if (isset($hat['cong_doan_tu_sis'])) {
                        foreach ($hat['cong_doan_tu_sis'] as $congDts) {
                            GiaoPhanHatCongDoanTuSi::insertByGiaoHatId($giaoPhanId, $hat['giao_hat_id'], $congDts['cong_doan_tu_si_id'], $congDts['active']);
                        }
                    }
                }
            }

            if (isset($data['dongs']) && !empty($data['dongs'])) {
                foreach ($data['dongs'] as $dong) {
                    GiaoPhanDong::insertByGiaoPhanId($giaoPhanId, $dong['dong_id'], $dong['active']);
                }
            }

            if (isset($data['cosos']) && !empty($data['cosos'])) {
                foreach ($data['cosos'] as $coso) {
                    GiaoPhanCoSo::insertByGiaoPhanId($giaoPhanId, $coso['co_so_giao_phan_id'], $coso['active']);
                }
            }

            if (isset($data['banchuyentrachs']) && !empty($data['banchuyentrachs'])) {
                foreach ($data['banchuyentrachs'] as $banCt) {
                    GiaoPhanBanChuyenTrach::insertByGiaoPhanId($giaoPhanId, $banCt['ban_chuyen_trach_id'], $banCt['active']);
                }
            }
        } else {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }

    public function apiGetGiaoPhans($data = array(), $limit = 5)
    {
        $query = $this->model->select()
        ->orderBy('id', 'DESC');

        return $query;
    }

    public function apiGetGiaoHatList($data = []) {
        $model = new GiaoHat();
        $query = $model->select()
        ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiGetGiaoDiemList($data = []) {
        $model = new GiaoDiem();
        $query = $model->select()
        ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiGetCongDoanTuSiList($data = []) {
        $model = new CongDoanTuSi();
        $query = $model->select()
        ->orderBy('name', 'DESC');

        return $query->get();
    }
}
