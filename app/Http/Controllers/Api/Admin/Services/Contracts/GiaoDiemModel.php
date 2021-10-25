<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface GiaoDiemModel
{
    public function apiGetGiaoDiems($data = array(), $limit = 5);
}
