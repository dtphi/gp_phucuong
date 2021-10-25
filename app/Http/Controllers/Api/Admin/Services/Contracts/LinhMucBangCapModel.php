<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface LinhMucBangCapModel
{
    public function apiGetLinhMucBangCaps($data = array(), $limit = 5);
}
