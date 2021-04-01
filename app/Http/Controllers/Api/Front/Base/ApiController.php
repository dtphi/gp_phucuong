<?php

namespace App\Http\Controllers\Api\Front\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Front\Services\Service;

class ApiController extends Controller
{
    /**
     * @var Sv|null
     */
    protected $sv = null;

    // Success
    const RESPONSE_OK = 2000;
    const RESPONSE_CREATED = 2001;
    const RESPONSE_UPDATED = 2002;
    const RESPONSE_DELETED = 2003;
    const RESPONSE_IN_PROGRESS = 2004;

    /**
     * @author : dtphi .
     * ApiController constructor.
     * @param array $middleware
     */
    public function __construct(array $middleware = [])
    {
        parent::__construct($middleware);
        $this->sv = new Service();
    }


    public function getSetting(Request $request)
    {
        $requestParams = $request->get('params');

        $pathName = isset($requestParams['pathName']) ? $requestParams['pathName']:'home';
        $pathName = trim($pathName,'/');
       
        try {
            $newsGroups     = $this->sv->apiGetNewsGroupTrees();
            $mainMenus = [];
            if ($pathName === 'home' || empty($pathName)) {
                foreach ($newsGroups['data'] as $key => $newsGroup) {
                    if (isset($newsGroup['displays']['home_page']) && $newsGroup['displays']['home_page']) {
                        $mainMenus[] = $newsGroup;
                    }
                }
            } else {
                $mainMenus = $this->generateTree($newsGroups['data']);
            }
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $appImgPath = '/upload/app';

        return response()->json([
            'logo' => '/front/img/logo.png',
            'banner' => '/images/banner_image.jpg',
            'navMainLists' => $mainMenus,
            'appLists' => [
                [
                    'sort' => 0,
                    'title' => 'App website gppc',
                    'img' => $appImgPath . '/app_website_gppc.png',
                    'hrefAppStore' => '/',
                    'hrefChPlay' => '/'
                ],
                [
                    'sort' => 1,
                    'title' => 'App sách nói công giáo',
                    'img' => $appImgPath . '/app_sach_noi_cong_giao.jpg',
                    'hrefAppStore' => '/',
                    'hrefChPlay' => '/'
                ],
                [
                    'sort' => 2,
                    'title' => 'App tìm nhà thờ gần nhất',
                    'img' => $appImgPath . '/app_tim_nha_tho.jpg',
                    'hrefAppStore' => '/',
                    'hrefChPlay' => '/'
                ],
            ]
        ]);
    }


     /**
     * @author : dtphi .
     * @param $data
     * @param int $parent
     * @param int $depth
     * @return array
     */
    protected function generateTree($data, $parent = -1, $depth = 0)
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
