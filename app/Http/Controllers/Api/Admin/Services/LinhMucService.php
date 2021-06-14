<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucModel;
use App\Http\Resources\Linhmucs\LinhmucCollection;
use App\Http\Resources\Linhmucs\LinhmucResource;
use App\Models\Linhmuc;
use App\Models\GiaoXu;
use App\Models\Thanh;
use App\Models\ChucVu;
use App\Models\CoSoGiaoPhan;
use App\Models\Dong;
use App\Http\Common\Tables;
use DB;

final class LinhmucService implements BaseModel, LinhMucModel
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
        $this->model    = new Linhmuc();
    }

    public function apiGetList(array $options = [], $limit = 5)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->apiGetLinhmucs($options);

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

    public function apiGetLinhmucs($data = array(), $limit = 5)
    {
        $query = $this->model->select()
        ->orderBy('id', 'DESC');

        return $query;
    }

    public function apiInsert($data = [])
    {
        /**
         * Save user with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();

        $linhmucId = Linhmuc::insertForce($data);

        if ($linhmucId > 0) {

            if (isset($data['bang_caps']) && !empty($data['bang_caps'])) {
                foreach ($data['bang_caps'] as $bangcap) {
                    LinhmucBangcap::insertByLinhmucId($linhmucId, $bangcap['name'],$bangcap['type'],$bangcap['active'], htmlentities($data['ghi_chu']));
                }
            }

            if (isset($data['chuc_thanhs']) && !empty($data['chuc_thanhs'])) {
                foreach ($data['chuc_thanhs'] as $chucThanh) {
                    LinhmucChucthanh::insertByLinhmucId($linhmucId, $chucThanh['chuc_thanh_id'], 
                    $chucThanh['ngay_thang_nam_chuc_thanh'], $chucThanh['noi_thu_phong'], $chucThanh['nguoi_thu_phong'],
                $chucThanh['active'], htmlentities($data['ghi_chu']));
                }
            }

            if (isset($data['thuyen_chuyens']) && !empty($data['thuyen_chuyens'])) {
                foreach ($data['thuyen_chuyens'] as $thCh) {
                    LinhmucThuyenchuyen::insertByLinhmucId($linhmucId, $thCh['fromgiaoxu_id'], 
                    $thCh['fromchucvu_id'], $thCh['from_date'], $thCh['duccha_id'], $thCh['to_date'], 
                    $thCh['chucvu_id'], $thCh['giaoxu_id'], $thCh['active'], htmlentities($data['ghi_chu']));
                }
            }

            if (isset($data['van_thus']) && !empty($data['van_thus'])) {
                foreach ($data['van_thus'] as $vanThu) {
                    LinhmucVanthu::insertByLinhmucId($linhmucId, $vanThu['title'], $vanThu['type'], $vanThu['active'], htmlentities($data['ghi_chu']));
                }
            }
        } else {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return $this->model;
    }

    public function apiGetGiaoXuList($data = []) {
        $model = new GiaoXu();

        $query = $model->select()
        ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiGetThanhList($data = []) {
        $model = new Thanh();

        $query = $model->select()
        ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiGetChucVuList($data = []) {
        $model = new ChucVu();

        $query = $model->select()
        ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiGetDucChaList($data = []) {
        $model = new Linhmuc();
        $query = $model->select()
        ->where('is_duc_cha' ,'=', 1)
        ->orderBy('ten', 'DESC');

        return $query->get();
    }

    public function apiGetCoSoGiaoPhanList($data = []) {
        $model = new CoSoGiaoPhan();
        $query = $model->select()
        ->orderBy('name', 'DESC');

        return $query->get();
    }

    public function apiGetDongList($data = []) {
        $model = new Dong();
        $query = $model->select()
        ->orderBy('name', 'DESC');

        return $query->get();
    }
}
