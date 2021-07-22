<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Common\Tables;
use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\GiaoPhanModel;
use App\Http\Resources\GiaoPhans\GiaoPhanResource;
use App\Http\Resources\GiaoPhanHats\GiaoPhanHatCollection;
use App\Http\Resources\GiaoPhanHatXus\GiaoPhanHatXuCollection;
use App\Http\Resources\GiaoPhanHatCongDoanTuSis\GiaoPhanHatCongDoanTuSiCollection;
use App\Http\Resources\GiaoPhanDongs\GiaoPhanDongCollection;
use App\Http\Resources\GiaoPhanCoSos\GiaoPhanCoSoCollection;
use App\Http\Resources\GiaoPhanBanChuyenTrachs\GiaoPhanBanChuyenTrachCollection;
use App\Models\CongDoanTuSi;
use App\Models\GiaoDiem;
use App\Models\GiaoHat;
use App\Models\GiaoPhan;
use App\Models\GiaoPhanBanChuyenTrach;
use App\Models\GiaoPhanCoSo;
use App\Models\GiaoPhanDong;
use App\Models\GiaoPhanHat;
use App\Models\GiaoPhanHatCongDoanTuSi;
use App\Models\GiaoPhanHatXu;
use App\Models\GiaoPhanHatXuDiem;
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
        $this->model = new GiaoPhan();
    }

    public function apiGetList(array $options = [], $limit = 15)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetGiaoPhans($options);

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
                    GiaoPhanHat::insertByGiaoPhanId($giaoPhanId, $hat['giao_hat_id'], $hat['active']);
                    $giaoPhanHat = GiaoPhanHat::latest('id')->first();
                    if (isset($hat['giao_xus'])) {
                        foreach ($hat['giao_xus'] as $giaoXu) {
                            GiaoPhanHatXu::insertByGiaoHatId($giaoPhanId, $giaoPhanHat->id, $hat['giao_hat_id'], $giaoXu['giao_xu_id'],
                                $giaoXu['active']);
                        }
                    }
                    if (isset($hat['cong_doan_tu_sis'])) {
                        foreach ($hat['cong_doan_tu_sis'] as $congDts) {
                            GiaoPhanHatCongDoanTuSi::insertByGiaoHatId($giaoPhanId, $giaoPhanHat->id, $hat['giao_hat_id'],
                                $congDts['cong_doan_tu_si_id'], $congDts['active']);
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
                    GiaoPhanBanChuyenTrach::insertByGiaoPhanId($giaoPhanId, $banCt['ban_chuyen_trach_id'],
                        $banCt['active']);
                }
            }
        } else {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }

    public function apiUpdate($model, $data = [])
    {
        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        $model->fill($data);

        if ($model->save()) {
            $giaoPhanId = $model->id;

            GiaoPhanHat::fcDeleteByGiaoPhanId($giaoPhanId);
            GiaoPhanHatXu::fcDeleteByGiaoPhanId($giaoPhanId);
            GiaoPhanHatCongDoanTuSi::fcDeleteByGiaoPhanId($giaoPhanId);
            $giaoXuDiems = [];
            if (isset($data['hats']) && !empty($data['hats'])) {
                foreach ($data['hats'] as $hat) {
                    GiaoPhanHat::insertByGiaoPhanId($giaoPhanId, $hat['giao_hat_id'], $hat['active']);
                    $giaoPhanHat = GiaoPhanHat::latest('id')->first();
                    if (isset($hat['giao_xus']) && !empty($hat['giao_xus'])) {
                        foreach ($hat['giao_xus'] as $giaoXu) {
                            $giaoDiem                = [];
                            $giaoDiem['giao_hat_id'] = $hat['giao_hat_id'];
                            $giaoDiem['giao_xu_id']  = $giaoXu['giao_xu_id'];
                            $giaoXuDiems[]           = $giaoDiem;
                            GiaoPhanHatXu::insertByGiaoHatId($giaoPhanId, $giaoPhanHat->id, $hat['giao_hat_id'], $giaoXu['giao_xu_id'],
                                $giaoXu['active']);
                        }
                    }
                    if (isset($hat['cong_doan_tu_sis'])) {
                        foreach ($hat['cong_doan_tu_sis'] as $congDts) {
                            GiaoPhanHatCongDoanTuSi::insertByGiaoHatId($giaoPhanId, $giaoPhanHat->id, $hat['giao_hat_id'],
                                $congDts['cong_doan_tu_si_id'], $congDts['active']);
                        }
                    }
                }

                // Giao diem.
                $giaoDiems = [];
                foreach ($giaoXuDiems as $giaoDiem) {
                    $gDiems = DB::table(Tables::$giaophan_hat_xu_diems)
                        ->where('giao_phan_id', $giaoPhanId)
                        ->where('giao_hat_id', $giaoDiem['giao_hat_id'])
                        ->where('giao_xu_id', $giaoDiem['giao_xu_id'])
                        ->get();

                    if ($gDiems->count()) {
                        $giaoDiems[] = $gDiems;
                    }
                }

                GiaoPhanHatXuDiem::fcDeleteByGiaoPhanId($giaoPhanId);
                foreach ($giaoDiems as $gdiems) {
                    foreach ($gdiems as $gdiem) {
                        GiaoPhanHatXuDiem::insertByGiaoPhanId($giaoPhanId, $gdiem->giao_hat_id, $gdiem->giao_xu_id,
                            $gdiem->giao_diem_id, $gdiem->active);
                    }
                }
            }

            GiaoPhanDong::fcDeleteByGiaoPhanId($giaoPhanId);
            if (isset($data['dongs']) && !empty($data['dongs'])) {
                foreach ($data['dongs'] as $dong) {
                    GiaoPhanDong::insertByGiaoPhanId($giaoPhanId, $dong['dong_id'], $dong['active']);
                }
            }

            GiaoPhanCoSo::fcDeleteByGiaoPhanId($giaoPhanId);
            if (isset($data['cosos']) && !empty($data['cosos'])) {
                foreach ($data['cosos'] as $coso) {
                    GiaoPhanCoSo::insertByGiaoPhanId($giaoPhanId, $coso['co_so_giao_phan_id'], $coso['active']);
                }
            }

            GiaoPhanBanChuyenTrach::fcDeleteByGiaoPhanId($giaoPhanId);
            if (isset($data['banchuyentrachs']) && !empty($data['banchuyentrachs'])) {
                foreach ($data['banchuyentrachs'] as $banCt) {
                    GiaoPhanBanChuyenTrach::insertByGiaoPhanId($giaoPhanId, $banCt['ban_chuyen_trach_id'],
                        $banCt['active']);
                }
            }
        } else {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $model;
    }

    public function apiGetGiaoPhans($data = array(), $limit = 15)
    {
        $query = $this->model->select()
            ->orderBy('id', 'DESC');

        return $query;
    }

    public function apiGetGiaoHatList($data = [])
    {
        $model = new GiaoHat();
        $query = $model->select()
            ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiUpdateGiaoHat($data = []) 
    {
        if ($data['isEdit']) {
            if ((int)$data['id'] != (int)$data['giaoHatOldId']) {
                GiaoPhanHat::fcDeleteById($data['giaoHatOldId']);
            }
        }
        $hat = GiaoPhanHat::updateOrCreate(
            [
                'giao_phan_id' => $data['giao_phan_id'], 
                'giao_hat_id' => $data['giao_hat_id']
            ],
            [
                'active' => $data['active']
            ]
        );

        return new GiaoPhanHatCollection(GiaoPhanHat::where('giao_phan_id', $data['giao_phan_id'])->get());
    }

    public function apiUpdateGiaoXu($data = []) 
    {
        if ($data['isEdit']) {
            if ((int)$data['id'] != (int)$data['giaoXuOldId']) {
                GiaoPhanHatXu::fcDeleteById($data['giaoXuOldId']);
            }
        }
        $hat = GiaoPhanHatXu::updateOrCreate(
            [
                'giao_phan_hat_id' => $data['hatId'],
                'giao_phan_id' => $data['giao_phan_id'], 
                'giao_hat_id' => $data['giao_hat_id'],
                'giao_xu_id' => $data['giao_xu_id']
            ],
            [
                'active' => $data['active']
            ]
        );

        $giaoXus = GiaoPhanHatXu::where('giao_phan_hat_id', $data['hatId'])
        ->where('giao_phan_id', $data['giao_phan_id'])
        ->where('giao_hat_id', $data['giao_hat_id'])->get();

        return new GiaoPhanHatXuCollection($giaoXus);
    }

    public function apiGetGiaoDiemList($data = [])
    {
        $model = new GiaoDiem();
        $query = $model->select()
            ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiGetCongDoanTuSiList($data = [])
    {
        $model = new CongDoanTuSi();
        $query = $model->select()
            ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiUpdateCongDoanTuSi($data = []) 
    {
        if ($data['isEdit']) {
            if ((int)$data['id'] != (int)$data['congDoanTuSiOldId']) {
                GiaoPhanHatCongDoanTuSi::fcDeleteById($data['congDoanTuSiOldId']);
            }
        }
        $hat = GiaoPhanHatCongDoanTuSi::updateOrCreate(
            [
                'giao_phan_hat_id' => $data['hatId'],
                'giao_phan_id' => $data['giao_phan_id'], 
                'giao_hat_id' => $data['giao_hat_id'],
                'cong_doan_tu_si_id' => $data['cong_doan_tu_si_id']
            ],
            [
                'active' => $data['active']
            ]
        );

        $congdts = GiaoPhanHatCongDoanTuSi::where('giao_phan_hat_id', $data['hatId'])
        ->where('giao_phan_id', $data['giao_phan_id'])
        ->where('giao_hat_id', $data['giao_hat_id'])->get();

        return new GiaoPhanHatCongDoanTuSiCollection($congdts);
    }

    public function apiUpdateDong($data = []) 
    {
        if ($data['isEdit']) {
            if ((int)$data['id'] != (int)$data['dongOldId']) {
                GiaoPhanDong::fcDeleteById($data['dongOldId']);
            }
        }
        $hat = GiaoPhanDong::updateOrCreate(
            [
                'giao_phan_id' => $data['giao_phan_id'], 
                'dong_id' => $data['dong_id']
            ],
            [
                'active' => $data['active']
            ]
        );

        return new GiaoPhanDongCollection(GiaoPhanDong::where('giao_phan_id', $data['giao_phan_id'])->get());
    }

    public function apiUpdateCoSo($data = []) 
    {
        if ($data['isEdit']) {
            if ((int)$data['id'] != (int)$data['coSoOldId']) {
                GiaoPhanCoSo::fcDeleteById($data['coSoOldId']);
            }
        }
        $hat = GiaoPhanCoSo::updateOrCreate(
            [
                'giao_phan_id' => $data['giao_phan_id'], 
                'co_so_giao_phan_id' => $data['co_so_giao_phan_id']
            ],
            [
                'active' => $data['active']
            ]
        );

        return new GiaoPhanCoSoCollection(GiaoPhanCoSo::where('giao_phan_id', $data['giao_phan_id'])->get());
    }

    public function apiUpdateBanChuyenTrach($data = []) 
    {
        if ($data['isEdit']) {
            if ((int)$data['id'] != (int)$data['banChuyenTrachOldId']) {
                GiaoPhanBanChuyenTrach::fcDeleteById($data['banChuyenTrachOldId']);
            }
        }
        $hat = GiaoPhanBanChuyenTrach::updateOrCreate(
            [
                'giao_phan_id' => $data['giao_phan_id'], 
                'ban_chuyen_trach_id' => $data['ban_chuyen_trach_id']
            ],
            [
                'active' => $data['active']
            ]
        );

        return new GiaoPhanBanChuyenTrachCollection(GiaoPhanBanChuyenTrach::where('giao_phan_id', $data['giao_phan_id'])->get());
    }
}
