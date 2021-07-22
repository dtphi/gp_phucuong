<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface LinhMucModel
{
    public function apiGetLinhmucs($data = array(), $limit = 15);

    public function apiInsert($data = []);

    public function apiUpdate($model, $data = []);

    public function apiGetGiaoXuList($data = []);

    public function apiGetThanhList($data = []);

    public function apiGetChucVuList($data = []);

    public function apiGetDucChaList($data = []);

    public function apiGetCoSoGiaoPhanList($data = []);

    public function apiGetDongList($data = []);

    public function apiGetBanChuyenTrachList($data = []);

    public function apiUpdateChucThanh($data = []);

    public function apiUpdateVanThu($data = []);

    public function apiUpdateThuyenChuyen($data = []);
}
