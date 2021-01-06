<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 9/24/2020
 * Time: 4:31 PM
 */

namespace App\Http\LcgServices;

use App\Http\LcgServices\LcgContracts\LcgNewsContract;
use App\Http\LcgServices\LcgModels\LcgMember;
use App\Http\LcgServices\LcgModels\LcgUser;
use App\Http\Resources\User\LcgUserCollection;

class LcgNewsService implements LcgNewsContract
{
    /**
     * @author : Phi .
     * LcgUserService constructor.
     */
    public function __construct()
    {
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
        $query = $this->user->orderByCreatedAtDesc();

        $results = new LcgUserCollection(LcgMember::paginate());

        return $results;
    }
}
