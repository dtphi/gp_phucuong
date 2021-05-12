<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Controllers\Api\Front\Services\Contracts\HomeModel;
use App\Models\Information;
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

    public function getMenuCategories($parentId = 0)
    {
        $query = DB::table('pc_categorys')->select()->leftJoin('pc_category_descriptions', 'pc_categorys.category_id',
            '=', 'pc_category_descriptions.category_id')
            ->where('pc_categorys.parent_id', (int)$parentId)
            ->where('pc_categorys.status', '1')
            ->orderBy('pc_categorys.sort_order')->orderBy('pc_category_descriptions.category_id');

        return $query->get();
    }
}
