<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 9/24/2020
 * Time: 4:31 PM
 */

namespace App\Http\LcgServices;

use App\Http\LcgServices\LcgContracts\LcgNewsGroupContract;
use App\Http\LcgServices\LcgModels\LcgNewsGroup;
use App\Http\Resources\LcgNewsGroup\LcgNewsGroupCollection;

class LcgNewsGroupService implements LcgNewsGroupContract
{
    private $newsGr = null;

    /**
     * @author : Phi .
     * LcgUserService constructor.
     */
    public function __construct()
    {
        $this->newsGr = new LcgNewsGroup();
    }

    /**
     * @author : Phi .
     * @param array $filters
     * @param int $limit
     * @return LcgUserCollection
     */
    public function apiGetLists($filters = [], $limit = 0)
    {
        // TODO: Implement apiGetLists() method.
        $query = $this->newsGr->select('id', 'father_id', 'newsgroupname')
            ->orderByCreatedAtDesc();


        $results = new LcgNewsGroupCollection($query->get());

        return $results;
    }

    /**
     * @param $data
     * @param int $parent
     * @param int $depth
     * @return array
     */
    public function generateTree($data, $parent = -1, $depth = 0)
    {
        $newsGroupTree = [];
        for ($i = 0, $ni = $data->count(); $i < $ni; $i++) {
            if ($data[$i]->father_id == $parent) {
                $newsGroupTree[$data[$i]->id]['name'] = $data[$i]->newsgroupname;
                $newsGroupTree[$data[$i]->id]['children'] = $this->generateTree($data, $data[$i]->id, $depth + 1);
            }
        }

        return $newsGroupTree;
    }
}
