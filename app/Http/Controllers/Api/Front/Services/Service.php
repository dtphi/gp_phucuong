<?php

namespace App\Http\Controllers\Api\Front\Services;

use App\Http\Controllers\Api\Front\Services\Contracts\BaseModel;
use App\Models\NewsGroup;
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
        $this->modelNewGroup = new NewsGroup();
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
        $query = $this->modelNewGroup->select('id', 'father_id', 'newsgroupname', 'displays', 'sort')->orderBySortAsc();

        return [
            'total' => $query->count(),
            'data'  => $query->get()->toArray()
        ];
    }
}
