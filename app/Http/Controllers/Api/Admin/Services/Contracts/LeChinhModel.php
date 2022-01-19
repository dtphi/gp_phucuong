<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface LeChinhModel
{
    public function apiGetLeChinhs($data = array(), $limit = 5);
}
