<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Controllers\Api\Front\Services\Contracts\BaseModel;
use App\Models\Category;
use App\Http\Common\Tables;
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
        $this->modelNewGroup = new Category();
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
}
