<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface LinhMucThuyenChuyenModel
{
    public function apiGetLinhMucThuyenChuyens($data = array(), $limit = 5);
}
