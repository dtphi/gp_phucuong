<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface AdminModel
{
    public function apiPermissionUpdate(array $allows = [], $tokenablId = null);
}
