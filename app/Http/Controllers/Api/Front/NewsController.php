<?php

namespace App\Http\Controllers\Api\Front;

use App\Exceptions\HandlerMsgCommon;
use App\Helpers\Helper;
use App\Http\Controllers\Api\Front\Base\ApiController as Controller;
use App\Http\Controllers\Api\Front\Services\Contracts\NewsModel as NewsSv;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * @var string
     */
    protected $resourceName = 'news';

    public static $thumImgNo = '/images/cong-doan-co-the-doc-phuc-am-trong-thanh-le-khong_150x150.jpg';

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
    public function getServiceContext()
    {
        return $this->newsSv;
    }

    public function index()
    {
        $bannerPath = '/upload/home_banners';

        try {
            $pageLists = [
                [
                    'sort'  => 0,
                    'img'   => $bannerPath . '/news_banner.jpeg',
                    'href'  => '/tin-tuc',
                    'title' => '>>>> XEM TIN TỨC'
                ],
                [
                    'sort'  => 1,
                    'img'   => $bannerPath . '/loi_chua_banner.jpeg',
                    'href'  => '/',
                    'title' => '>>>> LỜI CHÚA'
                ],
                [
                    'sort'  => 2,
                    'img'   => $bannerPath . '/video_banner.jpg',
                    'href'  => '/video',
                    'title' => '>>>> VIDEO'
                ],
                [
                    'sort'  => 3,
                    'img'   => $bannerPath . '/audio_podcast_banner.jpeg',
                    'href'  => '/',
                    'title' => '>>>> AUDIO/PODCAST'
                ],
                [
                    'sort'  => 4,
                    'img'   => $bannerPath . '/linh_muc_banner.jpeg',
                    'href'  => '/',
                    'title' => '>>>> DANH SÁCH LINH MỤC'
                ],
                [
                    'sort'  => 5,
                    'img'   => $bannerPath . '/gx_chanh_toa_banner.jpeg',
                    'href'  => '/',
                    'title' => '>>>> GIÁO XỨ TRONG GIÁO PHẬN'
                ],
                [
                    'sort'  => 6,
                    'img'   => $bannerPath . '/thong_bao_banner.jpeg',
                    'href'  => '/',
                    'title' => '>>>> THÔNG BÁO'
                ],
                [
                    'sort'  => 7,
                    'img'   => $bannerPath . '/phung_vu_banner.jpg',
                    'href'  => '/',
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
        $page   = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        $params['page'] = $page;

        $params['limit'] = 20;

        $params['slug'] = isset($params['slug']) ? $params['slug'] : '';
        if (!empty($params['slug'])) {
            $slugs                 = explode('-', $params['slug']);
            $params['category_id'] = end($slugs);
        }

        $results    = $this->newsSv->apiGetInfoList($params);
        $pagination = $this->_getTextPagination($results);

        $infos = [];
        foreach ($results as $info) {
            $staticImg     = self::$thumImgNo;
            $staticThumImg = self::$thumImgNo;

            if (file_exists(public_path(rawurldecode($info->image)))) {
                $staticImg     = $info->image;
                $staticThumImg = $info->image;
            }
            if (isset($info->image_thumb) && $info->image_thumb
                && file_exists(public_path('/.tmb' . rawurldecode($info->image_thumb)))) {
                $staticThumImg = '/.tmb' . $info->image_thumb;
            }
            $infos[] = [
                'category_id'      => $info->category_id,
                'date_available'   => date_format(date_create($info->date_available),"d-m-Y"),
                'description'      => htmlspecialchars_decode($info->sort_description),
                'sort_description' => Str::substr(html_entity_decode($info->sort_description), 0, 100),
                'image'            => $staticImg,
                'imgUrl'           => url($staticImg),
                'imgThumUrl'       => url($staticThumImg),
                'information_id'   => $info->information_id,
                'name'             => $info->name,
                'name_slug'        => $info->name_slug,
                'sort_name'        => Str::substr($info->name, 0, 50),
                'viewed'           => $info->viewed,
                'vote'             => $info->vote
            ];
        }

        return Helper::successResponse([
            'results'    => $infos,
            'pagination' => $pagination,
            'page'       => $page
        ]);
    }

    /**
     * @author : dtphi .
     * @param LengthAwarePaginator $paginator
     * @return array
     */
    protected function _getTextPagination(LengthAwarePaginator $paginator)
    {
        $data = [];

        if ($paginator instanceof LengthAwarePaginator && $paginator->count()) {
            $data = $paginator->toArray();

            unset($data['data']);
        }

        return $data;
    }

    public function detail(Request $request)
    {
        $params         = $request->all();
        $params['slug'] = isset($params['slug']) ? $params['slug'] : '';
        if (!empty($params['slug'])) {
            $slugs                    = explode('-', $params['slug']);
            $params['information_id'] = end($slugs);
        }

        $json = [];
        if (isset($params['information_id'])) {
            $this->newsSv->apiUpdateViewed($params['information_id']);

            $json = $this->newsSv->apiGetInfo($params['information_id']);
        }

        return Helper::successResponse([
            'results' => $json
        ]);
    }

    public function showLastedList(Request $request)
    {
        $json = [];

        $list = $this->newsSv->apiGetLatestInfos(20)->toArray();

        if (!empty($list)) {
            $infoIds = array_reduce($list, function ($carry, $item) {
                $carry[] = $item['information_id'];

                return $carry;
            });

            if (!empty($infoIds)) {
                $params                    = $request->all();
                $params['information_ids'] = $infoIds;

                $results = $this->newsSv->apiGetInfoListByIds($params);

                $json = [];
                foreach ($results as $info) {
                    $staticImg = '/images/cong-doan-co-the-doc-phuc-am-trong-thanh-le-khong_150x150.jpg';
                    if (file_exists(public_path(rawurldecode($info->image)))) {
                        $staticImg = $info->image;
                    }
                    $json[] = [
                        'date_available'   => date_format(date_create($info->date_available),"d-m-Y"),
                        'description'      => htmlspecialchars_decode($info->sort_description),
                        'sort_description' => Str::substr(html_entity_decode($info->sort_description), 0, 100),
                        'image'            => $staticImg,
                        'imgUrl'           => url($staticImg),
                        'information_id'   => $info->information_id,
                        'name'             => $info->name,
                        'name_slug'        => $info->name_slug,
                        'sort_name'        => Str::substr($info->name, 0, 50),
                        'viewed'           => $info->viewed,
                        'vote'             => $info->vote
                    ];
                }
            }
        }

        return Helper::successResponse([
            'results' => $json
        ]);
    }

    function sum($carry, $item)
    {
        $carry += $item;

        return $carry;
    }


    public function showPopularList(Request $request)
    {
        $json = [];

        $list = $this->newsSv->apiGetPopularInfos(20)->toArray();

        if (!empty($list)) {
            $infoIds = array_reduce($list, function ($carry, $item) {
                $carry[] = $item['information_id'];

                return $carry;
            });

            if (!empty($infoIds)) {
                $params                    = $request->all();
                $params['information_ids'] = $infoIds;

                $results = $this->newsSv->apiGetInfoListByIds($params);

                $json = [];
                foreach ($results as $info) {
                    $staticImg = '/images/cong-doan-co-the-doc-phuc-am-trong-thanh-le-khong_150x150.jpg';
                    if (file_exists(public_path(rawurldecode($info->image)))) {
                        $staticImg = $info->image;
                    }
                    $json[] = [
                        'date_available'   => date_format(date_create($info->date_available),"d-m-Y"),
                        'description'      => htmlspecialchars_decode($info->sort_description),
                        'sort_description' => Str::substr(html_entity_decode($info->sort_description), 0, 100),
                        'image'            => $staticImg,
                        'imgUrl'           => url($staticImg),
                        'information_id'   => $info->information_id,
                        'name'             => $info->name,
                        'name_slug'        => $info->name_slug,
                        'sort_name'        => Str::substr($info->name, 0, 50),
                        'viewed'           => $info->viewed,
                        'vote'             => $info->vote
                    ];
                }
            }
        }

        return Helper::successResponse([
            'results' => $json
        ]);
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
