<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface LinhMucVanThuModel
{
    public function apiGetLinhMucVanThus($data = array(), $limit = 5);
}
