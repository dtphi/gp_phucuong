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

    public function index()
    {
        try {
            ///$newsGroups     = $this->homeSv->apiGetNewsGroupTrees();
            ///$newsGroupTrees = $this->generateTree($newsGroups['data']);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $bannerPath = '/upload/home_banners';

        return response()->json([
            'pageLists' => [
                [
                    'img' => $bannerPath . '/news_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> XEM TIN TỨC'
                ],
                [
                    'img' => $bannerPath . '/loi_chua_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> LỜI CHÚA'
                ],
                [
                    'img' => $bannerPath . '/video_banner.jpg',
                    'href' => '/',
                    'title' => '>>>> VIDEO'
                ],
                [
                    'img' => $bannerPath . '/audio_podcast_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> AUDIO/PODCAST'
                ],
                [
                    'img' => $bannerPath . '/linh_muc_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> DANH SÁCH LINH MỤC'
                ],
                [
                    'img' => $bannerPath . '/gx_chanh_toa_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> GIÁO XỨ TRONG GIÁO PHẬN'
                ],
                [
                    'img' => $bannerPath . '/thong_bao_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> THÔNG BÁO'
                ],
                [
                    'img' => $bannerPath . '/phung_vu_banner.jpg',
                    'href' => '/',
                    'title' => '>>>> PHỤNG VỤ'
                ]      
            ],
        ]);
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
