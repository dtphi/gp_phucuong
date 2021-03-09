<?php

namespace App\Http\Controllers\Api\Admin\Services\Contracts;

interface AdminModel
{
    /**
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public function apiGetList(array $options = [], $limit = 15);
}
