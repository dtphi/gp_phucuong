<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 9/24/2020
 * Time: 4:30 PM
 */

namespace App\Http\LcgServices\LcgContracts;


interface LcgNewsGroupContract
{
    /**
     * @author : Phi .
     * @param array $filters
     * @param $limit
     * @return mixed
     */
    public function apiGetLists($filters = [], $limit = 0);
}
