<?php

namespace App\Http\Controllers\Api\Front;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Front\Base\ApiController as Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Http\Controllers\Api\Front\Services\Contracts\NewsModel as NewsSv;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * @var string
     */
    protected $resourceName = 'news';

    /**
     * @var NewsSv|null
     */
    private $newsSv = null;

    /**
     * @author : dtphi .
     * NewsController constructor.
     * @param NewsSv $newsSv
     * @param array $middleware
     */
    public function __construct(NewsSv $newsSv, array $middleware = [])
    {
        $this->newsSv = $newsSv;
        parent::__construct($middleware);
    }

    /**
     * [getServiceContext:  ]
     * @return [type] [description]
     */
    public function getServiceContext() {
        return $this->newsSv;
    }

    public function index()
    {
        $bannerPath = '/upload/home_banners';
        
        try {
            $pageLists = [
                [
                    'sort' => 0,
                    'img' => $bannerPath . '/news_banner.jpeg',
                    'href' => '/tin-tuc',
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
            ];
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json([
            'pageLists' => $pageLists
        ]);
    }

    public function list(Request $request) 
    {
        $params = $request->all();
        $params['slug'] = isset($params['slug'])? $params['slug']: '';
        if (!empty($params['slug'])) {
            $slugs = explode('-', $params['slug']);
            $params['category_id'] = end($slugs);
        }

        $results = $this->newsSv->apiGetInfoList($params);

        $infos = [];
        foreach($results as $info) {
            $staticImg = '\.tmp\cong-doan-co-the-doc-phuc-am-trong-thanh-le-khong_150x150.jpg';
            if (file_exists(public_path('upload/news' . $info->image))) {
                $staticImg = $info->image;
            }
            $infos[] = [
                'category_id'=> $info->category_id,
                'created_at'=> $info->created_at,
                'description' => htmlspecialchars_decode($info->sort_description),
                'sort_description'=> Str::substr(htmlspecialchars_decode($info->sort_description), 0, 100),
                'image'=> $staticImg,
                'imgUrl' => url("/upload/news{$staticImg}"),
                'information_id' => $info->information_id,
                'name'=> $info->name,
                'sort_name' =>  Str::substr($info->name, 0, 50),
                'viewed'=> $info->viewed,
                'vote'=> $info->vote
            ];
        }

        return Helper::successResponse([
            'results'    => $infos
        ]);
    }

    public function detail($informationId = null, Request $request) 
    {
        $json = [];
        $this->newsSv->apiUpdateViewed($informationId);

        if ($informationId) {
            $json = $this->newsSv->apiGetInfo($informationId);
        }

        return Helper::successResponse([
            'results'    => $json
        ]);
    }

    public function showLastedList() 
    {
        $json = [];

        $list = $this->newsSv->apiGetLatestInfos(5);
        if ($list) {
            foreach ($list as $info) {
				$json[$info->information_id] = $this->newsSv->apiGetInfo($info->information_id);
			}
        }

        return $json;
    }

    public function showPopularList()
    {
        $json = [];

        $list = $this->newsSv->apiGetPopularInfos(5);

        if($list) {
            foreach ($list as $info) {
                $json[$info->information_id] = $this->newsSv->apiGetInfo($info->information_id);
            }
        }

        return $json;
    }

    public function showRelatedList($informationId = null)
    {
        $json = [];

        $list = $this->newsSv->apiGetInfoRelated($informationId);

        if ($list) {
            foreach ($list as $info) {
                $json[$info->related_id] = $this->newsSv->apiGetInfo($info->related_id);
            }
        }

        return $json;
    }
}
