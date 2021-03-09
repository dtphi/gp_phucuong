<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Api\Admin\Services\Contracts\AdminModel;
use App\Http\Resources\Admins\AdminCollection;
use App\Models\Admin;

final class AdminService implements AdminModel
{
    /**
     * @var Admin|null
     */
    private $model = null;

    /**
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model = new Admin();
    }

    /**
     * @author: dtphi .
     * @param array $options
     * @param int $limit
     * @return AdminCollection
     */
    public function apiGetList(array $options = [], $limit = 15)
    {
        // TODO: Implement apiGetList() method.
        $query = $this->model->orderByDescById();

        return new AdminCollection($query->paginate($limit));
    }
}
