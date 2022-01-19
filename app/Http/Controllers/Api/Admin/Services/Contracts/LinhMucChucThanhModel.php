<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface LinhMucChucThanhModel
{
    public function apiGetLinhMucChucThanhs($data = array(), $limit = 5);
}
