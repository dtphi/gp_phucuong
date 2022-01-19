<?php

namespace App\Http\Controllers\Api\Front\Services\Contracts;

interface EmailSubscribeModel
{
    public function apiInsert(array $data = []);
}
