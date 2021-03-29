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
                    'sort' => 0,
                    'img' => $bannerPath . '/news_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> XEM TIN TỨC'
                ],
                [
                    'sort' => 1,
                    'img' => $bannerPath . '/loi_chua_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> LỜI CHÚA'
                ],
                [
                    'sort' => 2,
                    'img' => $bannerPath . '/video_banner.jpg',
                    'href' => '/video',
                    'title' => '>>>> VIDEO'
                ],
                [
                    'sort' => 3,
                    'img' => $bannerPath . '/audio_podcast_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> AUDIO/PODCAST'
                ],
                [
                    'sort' => 4,
                    'img' => $bannerPath . '/linh_muc_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> DANH SÁCH LINH MỤC'
                ],
                [
                    'sort' => 5,
                    'img' => $bannerPath . '/gx_chanh_toa_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> GIÁO XỨ TRONG GIÁO PHẬN'
                ],
                [
                    'sort' => 6,
                    'img' => $bannerPath . '/thong_bao_banner.jpeg',
                    'href' => '/',
                    'title' => '>>>> THÔNG BÁO'
                ],
                [
                    'sort' => 7,
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

        $appImgPath = '/upload/app';

        return response()->json([
            'logo' => '/front/img/logo.png',
            'banner' => '/images/banner_image.jpg',
            'navMainLists' => [
                [
                    'children' => [],
                    'fatherId'=> -1,
                    'id' => 205,
                    'newsgroupname' => "Tin giáo phận"
                ],
[
                    'children' => [],
                    'fatherId'=> -1,
                    'id' => 204,
                    'newsgroupname' => "Giáo hội hoàn vũ"
                ],
                [
                    'children' => [],
                    'fatherId'=> -1,
                    'id' => 203,
                    'newsgroupname' => "Giáo hội việt nam"
                ],
                [
                    'children' => [],
                    'fatherId'=> -1,
                    'id' => 203,
                    'newsgroupname' => "Lời chúa"
                ],
                [
                    'children' => [],
                    'fatherId'=> -1,
                    'id' => 203,
                    'newsgroupname' => "Tài liệu"
                ],
                [
                    'children' => [],
                    'fatherId'=> -1,
                    'id' => 203,
                    'newsgroupname' => "Đáp ca"
                ],
                [
                    'children' => [],
                    'fatherId'=> -1,
                    'id' => 203,
                    'newsgroupname' => "Hôn nhân"
                ],
                [
                    'children' => [],
                    'fatherId'=> -1,
                    'id' => 203,
                    'newsgroupname' => "Tiếng việt"
                ],
                [
                    'children' => [],
                    'fatherId'=> -1,
                    'id' => 203,
                    'newsgroupname' => "Tài liệu"
                ],
                [
                    'children' => [],
                    'fatherId'=> -1,
                    'id' => 203,
                    'newsgroupname' => "Văn kiện"
                ]
            ],
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
