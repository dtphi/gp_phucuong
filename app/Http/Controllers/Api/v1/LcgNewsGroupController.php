<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 9/23/2020
 * Time: 9:06 AM
 */

namespace App\Http\Controllers\Api;


use App\Http\LcgServices\LcgContracts\LcgNewsGroupContract as NewsGrSv;
use Illuminate\Http\Request;

class LcgNewsGroupController
{
    /**
     * @var UserSv|null
     */
    private $nwGrSv = null;

    /**
     * LcgNewsGroupController constructor.
     * @param NewsGrSv $nwGrSv
     */
    public function __construct(NewsGrSv $nwGrSv)
    {
        $this->nwGrSv = $nwGrSv;
    }

    /**
     * @author : Phi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $json          = [
            'message' => '',
            'errors'  => '',
            'code'    => 200,
            'results' => []
        ];
        $results       = $this->nwGrSv->apiGetLists($json, 0);
        $newsGroupTree = $this->nwGrSv->generateTree($results);

        $data = [
            'newsGroup'     => $results,
            'newsGroupTree' => $newsGroupTree
        ];

        $json['results'] = $data;

        return \response()->json($json);
    }
}
