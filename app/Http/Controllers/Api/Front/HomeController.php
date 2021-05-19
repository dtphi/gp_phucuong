<?php

namespace App\Http\Controllers\Api\Front;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Front\Base\ApiController as Controller;
use App\Http\Controllers\Api\Front\Services\Contracts\HomeModel as HomeSv;
use Illuminate\Http\Request;

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

    /**
     * [getServiceContext:  ]
     * @return [type] [description]
     */
    public function getServiceContext()
    {
        return $this->homeSv;
    }

    public function index()
    {
        $bannerPath = config('app.asset_url') . '/upload/home_banners';

        try {
            $pageLists = [
                [
                    'sort'  => 0,
                    'img'   => $bannerPath . '/news_banner.jpeg',
                    'url'  => url('/tin-tuc'),
                    'title' => '>>>> XEM TIN TỨC'
                ],
                [
                    'sort'  => 1,
                    'img'   => $bannerPath . '/loi_chua_banner.jpeg',
                    'url'  => url('/danh-muc-tin/loi-chua-210'),
                    'title' => '>>>> LỜI CHÚA'
                ],
                [
                    'sort'  => 2,
                    'img'   => $bannerPath . '/video_banner.jpg',
                    'url'  => url('/video'),
                    'title' => '>>>> VIDEO'
                ],
                [
                    'sort'  => 3,
                    'img'   => $bannerPath . '/audio_podcast_banner.jpeg',
                    'url'  => 'http://www.sachnoiconggiao.com/',
                    'title' => '>>>> AUDIO/PODCAST'
                ],
                [
                    'sort'  => 4,
                    'img'   => $bannerPath . '/linh_muc_banner.jpeg',
                    'url'  => url('/danh-muc-tin/giam-muc-18'),
                    'title' => '>>>> DANH SÁCH LINH MỤC'
                ],
                [
                    'sort'  => 5,
                    'img'   => $bannerPath . '/gx_chanh_toa_banner.jpeg',
                    'url'  => url('/danh-muc-tin/giao-phan-207'),
                    'title' => '>>>> GIÁO XỨ TRONG GIÁO PHẬN'
                ],
                [
                    'sort'  => 6,
                    'img'   => $bannerPath . '/thong_bao_banner.jpeg',
                    'url'  => url('/danh-muc-tin/thong-bao-209'),
                    'title' => '>>>> THÔNG BÁO'
                ],
                [
                    'sort'  => 7,
                    'img'   => $bannerPath . '/phung_vu_banner.jpg',
                    'url'  => url('/danh-muc-tin/phung-vu-213'),
                    'title' => '>>>> PHỤNG VỤ'
                ]
            ];
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json([
            'pageLists' => $pageLists
        ]);
    }
}
