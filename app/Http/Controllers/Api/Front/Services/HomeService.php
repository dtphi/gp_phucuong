<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Controllers\Api\Front\Services\Contracts\HomeModel;
use App\Models\Information;
use App\Models\Category;
use App\Http\Common\Tables;
use DB;

final class HomeService implements HomeModel
{
    /**
     * [$modelNewGroup description]
     * @var null
     */
    private $modelNewGroup = null;

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
        $this->modelNewGroup = new Category();
    }

    public function getMenuCategories($parentId = 0)
    {
        $query = $this->modelNewGroup->select()
            ->lfJoinDescription()
            ->filterParentId($parentId)
            ->filterActiveStatus()
            ->orderByAscSort()
            ->orderByAscParentId();

        return $query->get();
    }
}
