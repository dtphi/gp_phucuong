<?php

namespace App\Http\Controllers\Api\Front;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Front\Base\ApiController as Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Front\Services\Contracts\HomeModel as HomeSv;

class HomeController extends Controller
{
    /**
     * @var string
     */
    protected $resourceName = 'home';

    /**
     * @var HomeSv|null
     */
    private $homeSv = null;

    /**
     * @author : dtphi .
     * HomeController constructor.
     * @param HomeSv $homeSv
     * @param array $middleware
     */
    public function __construct(HomeSv $homeSv, array $middleware = [])
    {
        $this->homeSv = $homeSv;
        parent::__construct($middleware);
    }

    public function getSetting()
    {
        try {
            $newsGroups     = $this->homeSv->apiGetNewsGroupTrees();
            $newsGroupTrees = $this->generateTree($newsGroups['data']);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json([
            'logo' => '/front/img/logo.png',
            'banner' => '/images/banner_image.jpg',
            'navMainLists' => $newsGroupTrees
        ]);
    }

     /**
     * @author : dtphi .
     * @param $data
     * @param int $parent
     * @param int $depth
     * @return array
     */
    public function generateTree($data, $parent = -1, $depth = 0)
    {
        $newsGroupTree = [];

        for ($i = 0, $ni = count($data); $i < $ni; $i++) {
            if ($data[$i]['father_id'] == $parent) {
                $newsGroupTree[$data[$i]['id']]['id']            = $data[$i]['id'];
                $newsGroupTree[$data[$i]['id']]['fatherId']      = $data[$i]['father_id'];
                $newsGroupTree[$data[$i]['id']]['newsgroupname'] = $data[$i]['newsgroupname'];
                $newsGroupTree[$data[$i]['id']]['children']      = $this->generateTree($data, $data[$i]['id'],
                    $depth + 1);
            }
        }

        return $newsGroupTree;
    }
}
