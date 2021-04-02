<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Controllers\Api\Front\Services\Contracts\HomeModel;
use App\Models\Information;
use App\Http\Resources\FrontHomes\HomeCollection;
use DB;

final class HomeService implements HomeModel
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
}
