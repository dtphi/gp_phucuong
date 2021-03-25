<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Controllers\Api\Front\Services\Contracts\BaseModel;
use App\Http\Controllers\Api\Front\Services\Contracts\HomeModel;
use App\Models\Information;
use App\Http\Resources\FrontHomes\HomeCollection;
use DB;

final class HomeService implements BaseModel, HomeModel
{
    /**
     * @var Admin|null
     */
    private $model = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model = new Information();
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

        return $query->paginate($limit);
    }

    /**
     * author : dtphi .
     * @param array $options
     * @param int $limit
     * @return InformationCollection
     */
    public function apiGetResourceCollection(array $options = [], $limit = 15)
    {
        // TODO: Implement apiGetResourceCollection() method.
        return new InformationCollection($this->apiGetList($options, $limit));
    }
}
