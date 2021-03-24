<?php

namespace App\Http\Controllers\Api\Front\Services\Contracts;

interface BaseModel
{
    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public function apiGetList(array $options = [], $limit = 15);

    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public function apiGetResourceCollection(array $options = [], $limit = 15);
}
