<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface CoSoModel
{
    public function apiGetCoSos($data = array(), $limit = 5);
}
