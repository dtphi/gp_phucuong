<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface GiaoXuModel
{
    public function apiGetGiaoXus($data = array(), $limit = 5);

    public function apiUpdate($model, $data = []);
}
