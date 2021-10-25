<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface DongModel
{
    public function apiGetDongs($data = array(), $limit = 5);

    public function apiUpdate($model, $data = []);
}
