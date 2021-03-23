<?php

namespace App\Http\Controllers\Api\Admin\Services;

use DB;

trait ScopeService
{
    /**
     * @author : dtphi .
     * @param $query
     * @return mixed
     */
    public function scopeOrderByDescById($query)
    {
        return $query->orderByDesc('id');
    }
}
