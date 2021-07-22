<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;


interface GiaoPhanModel
{
    public function apiInsert($data = []);

    public function apiUpdate($model, $data = []);

    public function apiGetGiaoPhans($data = array(), $limit = 15);

    public function apiGetGiaoHatList($data = []);

    public function apiUpdateGiaoHat($data = []);

    public function apiUpdateGiaoXu($data = []);

    public function apiGetGiaoDiemList($data = []);

    public function apiGetCongDoanTuSiList($data = []);

    public function apiUpdateCongDoanTuSi($data = []);

    public function apiUpdateDong($data = []);

    public function apiUpdateCoSo($data = []);

    public function apiUpdateBanChuyenTrach($data = []);
}
