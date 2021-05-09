<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Common\Tables;
use App\Http\Controllers\Api\Front\Services\Contracts\SettingModel;
use App\Models\Setting;
use DB;

final class SettingService implements SettingModel
{
    /**
     * @var Setting|null
     */
    private $model = null;

    /**
     * @author : dtphi .
     * SettingService constructor.
     */
    public function __construct()
    {
        $this->model = new Setting();
    }

    public function apiGetList(array $options = [], $limit = 15) {
        $query = $this->model->where('code', $options['code']);

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function apiGetCategoryByIds($ids = [])
    {
        $query = DB::table('pc_categorys')->select()
            ->leftJoin('pc_category_descriptions', 'pc_categorys.category_id', '=', 'pc_category_descriptions.category_id')
            ->whereIn('pc_categorys.category_id', $ids)
            ->where('pc_categorys.status', '1')
            ->orderBy('pc_categorys.sort_order')
            ->orderBy('pc_category_descriptions.category_id');

        return $query->get();
    }

    public function apiGetDetail($id = null){
        $this->model = $this->model->where('key', $id)->get();

        return $this->model;
    }
}
