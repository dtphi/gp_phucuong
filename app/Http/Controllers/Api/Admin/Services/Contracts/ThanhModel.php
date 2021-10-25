<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface ThanhModel
{
    public function apiGetThanhs($data = array(), $limit = 5);
}
