<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;


interface GiaoHatModel
{
    public function apiGetGiaoHats($data = array(), $limit = 5);

    public function apiInsert(array $data = []);

    public function apiUpdate($model, $data = []);
}
