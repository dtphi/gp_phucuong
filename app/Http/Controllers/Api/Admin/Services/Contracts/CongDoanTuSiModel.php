<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface CongDoanTuSiModel
{
    public function apiGetCongDoanTuSis($data = array(), $limit = 5);
}
