<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface ChucVuModel
{
    public function apiGetChucVus($data = array(), $limit = 5);
}
