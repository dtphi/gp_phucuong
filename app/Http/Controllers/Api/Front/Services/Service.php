<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Common\Tables;
use App\Http\Controllers\Api\Front\Services\Contracts\BaseModel;
use App\Models\Category;
use App\Models\GiaoXu;
use App\Models\Information;
use DB;

class Service implements BaseModel
{
    /**
     * [$modelNewGroup description]
     * @var null
     */
    private $modelNewGroup = null;

    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->modelInfo     = new Information();
        $this->modelNewGroup = new Category();
        $this->modelGiaoXu   = new GiaoXu();
    }

    /**
     * @author: dtphi .
     * @param array $options
     * @param int $limit
     * @return AdminCollection
     */
    public function apiGetList(array $options = [], $limit = 15)
    {
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
    }

    /**
     * @author : dtphi .
     * @return array
     */
    public function apiGetNewsGroupTrees()
    {
        // TODO: Implement apiGetNewsGroupTrees() method.
        $query = $this->modelNewGroup
            ->select('id', 'father_id', 'newsgroupname', 'displays', 'sort')
            ->orderBySortAsc();

        return [
            'total' => $query->count(),
            'data'  => $query->get()->toArray()
        ];
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

    public function apiGetCategoryById($categoryId = 0)
    {
        $query = $this->modelNewGroup->select()
            ->lfJoinDescription()
            ->filterById($categoryId)
            ->filterActiveStatus();

        return $query->first();
    }

    public function apiGetMenuCategoryIds($parentId = 0)
    {
        $query = DB::table('pc_categorys')->select('category_id')
            ->where('pc_categorys.parent_id', (int)$parentId)
            ->where('pc_categorys.status', '1');

        return $query->get()->toArray();
    }

    public function getMenuCategoriesToLayout($layoutId = 1)
    {
        $query = $this->modelNewGroup->select()
            ->lfJoinDescription()
            ->lfJoinToLayout()
            ->filterLayoutId($layoutId)
            ->filterActiveStatus()
            ->orderByAscSort()
            ->orderByAscParentId();

        return $query->get();
    }

    public function apiGetLatestInfos($limit = 5)
    {
        $query = $this->modelInfo->select('information_id')
            ->orderByDescDateAvailable()
            ->limit($limit);

        return $query->get();
    }

    public function apiGetPopularInfos($limit = 5)
    {
        $query = $this->modelInfo->select('information_id')
            ->orderByDescViewed()
            ->limit($limit);

        return $query->get();
    }

    public function apiGetInfoListByIds($data = array())
    {
        $infoType = 1;
        if (isset($data['infoType'])) {
            $infoType = (int)$data['infoType'];
        }

        $query = DB::table(Tables::$informations)->select(
            [
                'date_available',
                'sort_description',
                'image',
                Tables::$informations . '.information_id',
                'information_type',
                'name',
                'name_slug',
                'viewed',
                'vote'
            ]
        )
            ->leftJoin(Tables::$information_descriptions, Tables::$informations . '.information_id', '=',
                Tables::$information_descriptions . '.information_id')
            ->where('status', '=', '1')
            ->where('information_type', '=', $infoType);

        if (isset($data['information_ids'])) {
            $query->whereIn(Tables::$informations . '.information_id', $data['information_ids']);
        }

        $limit = 20;
        if (isset($data['limit'])) {
            $limit = (int)$data['limit'];
        }

        $query->orderByDesc('sort_order');
        $query->orderByDesc('date_available');

        return $query->get();
    }

    public function apiGetGiaoXuList($data = array(), $limit = 5)
    {
        $query = $this->modelGiaoXu->select();

        return $query->paginate(20);
    }
}
