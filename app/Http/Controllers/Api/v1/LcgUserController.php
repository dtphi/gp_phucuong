<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 9/23/2020
 * Time: 9:06 AM
 */

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\LcgServices\LcgContracts\LcgUserContract as UserSv;

class LcgUserController
{
    /**
     * @var UserSv|null
     */
    private $uSv = null;

    /**
     * @author : Phi .
     * LcgUserController constructor.
     * @param UserSv $uSv
     */
    public function __construct(UserSv $uSv)
    {
        $this->uSv = $uSv;
    }

    /**
     * @author : Phi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $json   = [
            'message' => '',
            'errors'  => '',
            'code'    => 200,
            'results'    => []
        ];
        $results = $this->uSv->apiGetLists([], 2);
        $data = [
            'user' => $results
        ];

        $json['results'] = $data;

        return \response()->json($json);
    }
}
