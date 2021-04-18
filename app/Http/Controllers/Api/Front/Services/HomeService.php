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

    public function getMenuCategories($parentId = 0) {
        $query = DB::table('pc_categorys')->select()->leftJoin('pc_category_descriptions', 'pc_categorys.category_id', '=', 'pc_category_descriptions.category_id')
        ->where('pc_categorys.parent_id', (int)$parentId)
        ->where('pc_categorys.status', '1')
        ->orderBy(['pc_categorys.sort_order', 'LCASE(pc_category_descriptions.name)']);

        return $query->get();
    }

    public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) " .  
        " WHERE c.parent_id = '" . (int)$parent_id . "' AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->rows;
	}
}
