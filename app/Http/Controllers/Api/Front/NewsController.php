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

        $limit = 20;
        if ($request->query('limit')) {
            $limit = $request->query('limit');
        }
        $params['limit'] = $limit;

        $params['slug'] = isset($params['slug']) ? $params['slug'] : '';
        if (!empty($params['slug'])) {
            $slugs                 = explode('-', $params['slug']);
            $params['category_id'] = (int)end($slugs);
        }

        $params['all_category_children'] = [];
        if (isset($params['category_id']) && in_array($params['category_id'], self::$menuFullInfos)) {
            $subCategory = $this->newsSv->apiGetMenuCategoryIds($params['category_id']);
            if (!empty($subCategory)) {
                $params['all_category_children'] = array_reduce($subCategory, function ($carry, $item) {
                    $carry[] = $item->category_id;
    
                    return $carry;
                });
            }
            
            $params['all_category_children'][] = $params['category_id'];
        }

        $results    = $this->newsSv->apiGetInfoList($params);
        $pagination = $this->_getTextPagination($results);

        $infos = [];
        foreach ($results as $info) {
            $staticImg     = self::$thumImgNo;
            $staticThumImg = self::$thumImgNo;

            if ($info->image && file_exists(public_path(rawurldecode($info->image)))) {
                $staticImg     = rawurldecode($info->image);
            }

            $widthThumbInfoList = 184; 
            $heightThumbInfoList = 120;
            $width = 550;
            $height = 450;
            if (in_array($request->query('moduleName'), ['module_tin_giao_hoi','module_tin_giao_hoi_viet_nam'])){
                    $width = 350;
                    $height = 230;
            }
            if ($request->query('moduleName') == 'module_loi_chua') {
                    $width = 287;
                    $height = 191;
            }
            if ($request->query('moduleName') == 'module_tin_giao_phan') {
                    $width = 413;
                    $height = 275;

                    $width1 = 287;
                    $height1 = 195;
                    $staticThumMediumImg1 = (!empty($info->image))?$this->getThumbnail($info->image, $width1, $height1):$this->getThumbnail($staticImg, $width1, $height1);
            }
            if ($request->query('moduleName') == 'module_van_kien') {
                    $width = 223;
                    $height = 152;
            }

            $staticThumImg = (!empty($info->image))?$this->getThumbnail($info->image, $widthThumbInfoList, $heightThumbInfoList):$this->getThumbnail($staticImg, $widthThumbInfoList, $heightThumbInfoList);
            $staticThumMediumImg = (!empty($info->image))?$this->getThumbnail($info->image, $width, $height):$this->getThumbnail($staticImg, $width, $height);
 
            $sortDes = html_entity_decode($info->sort_description);
            $infos[] = [
                'category_id'      => $info->category_id,
                'date_available'   => date_format(date_create($info->date_available),"d-m-Y"),
                'description'      => html_entity_decode($info->sort_description),
                'sort_description' => Str::substr($sortDes, 0, 100),
                'image'            => $staticImg,
                'imgUrl'           => url($staticImg),
                'imgThumUrl'       => url($staticThumImg),
                'imgThumMediumImg' => url($staticThumMediumImg),
                'imgThumMediumImg1'=> isset($staticThumMediumImg1)?url($staticThumMediumImg1):'',
                'information_id'   => $info->information_id,
                'information_type' => $info->information_type,
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

            $json['results'] = $this->newsSv->apiGetInfo($params['information_id']);
            $json['result_category_relateds'] = $json['results']['related_category'];
        }

        return Helper::successResponse([
            'results' => $json['results'],
            'result_category_relateds' => $json['result_category_relateds']
        ]);
    }

    public function showLastedList(Request $request)
    {
        $json = [];
        $widthThumbInfoList = 184; 
        $heightThumbInfoList = 120;

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
                    $staticImg     = self::$thumImgNo;
                    $staticThumImg = self::$thumImgNo;

                    if ($info->image && file_exists(public_path(rawurldecode($info->image)))) {
                        $staticImg     = $info->image;
                    }
                    
                    $staticThumImg = (!empty($info->image))?$this->getThumbnail($info->image, $widthThumbInfoList, $heightThumbInfoList):$this->getThumbnail($staticImg, $widthThumbInfoList, $heightThumbInfoList);
                    $imgCarouselThumUrl = (!empty($info->image))?$this->getThumbnail($info->image, 750, 550):$this->getThumbnail($staticImg, 750, 550);

                    $sortDes = html_entity_decode($info->sort_description);

                    $json[] = [
                        'date_available'   => date_format(date_create($info->date_available),"d-m-Y"),
                        'description'      => html_entity_decode($info->sort_description),
                        'sort_description' => Str::substr($sortDes, 0, 100),
                        'image'            => $staticImg,
                        'imgUrl'           => url($staticImg),
                        'imgThumUrl'       => url($staticThumImg),
                        'imgCarThumUrl'    => url($imgCarouselThumUrl),
                        'information_id'   => $info->information_id,
                        'name'             => $info->name,
                        'name_slug'        => $info->name_slug,
                        'sort_name'        => Str::substr($info->name, 0, 28),
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

    public function showPopularList(Request $request)
    {
        $json = [];
        $widthThumbInfoList = 184; 
        $heightThumbInfoList = 120;

        if (!empty($request->query('slug'))) {
            return $this->list($request);
        }

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
                    $staticImg     = self::$thumImgNo;
                    $staticThumImg = self::$thumImgNo;

                    if ($info->image && file_exists(public_path(rawurldecode($info->image)))) {
                        $staticImg     = $info->image;
                    }
                    $staticThumImg = (!empty($info->image))?$this->getThumbnail($info->image, $widthThumbInfoList, $heightThumbInfoList):$this->getThumbnail($staticImg, $widthThumbInfoList, $heightThumbInfoList);
                    $sortDes = html_entity_decode($info->sort_description);

                    $json[] = [
                        'date_available'   => date_format(date_create($info->date_available),"d-m-Y"),
                        'description'      => html_entity_decode($info->sort_description),
                        'sort_description' => Str::substr($sortDes, 0, 100),
                        'image'            => $staticImg,
                        'imgUrl'           => url($staticImg),
                        'imgThumUrl'       => url($staticThumImg),
                        'information_id'   => $info->information_id,
                        'name'             => $info->name,
                        'name_slug'        => $info->name_slug,
                        'sort_name'        => Str::substr($info->name, 0, 25),
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

    public function showRelatedList($informationId = null, Request $request)
    {
        $json = [];
        if (!empty($request->query('slug'))) {
            return $this->list($request);
        }

        $list = $this->newsSv->apiGetInfoRelated($informationId);

        if ($list) {
            foreach ($list as $info) {
                $json[$info->related_id] = $this->newsSv->apiGetInfo($info->related_id);
            }
        }

        return $json;
    }

    private function _getInforCarousel(&$context, &$info, $staticImg) {
        $imgCarouselThumUrl = $this->getThumbnail($staticImg, 730, 410);
        $sortDes = html_entity_decode($info->sort_description);

        $context[] = [
            'date_available'   => date_format(date_create($info->date_available),"d-m-Y"),
            'sort_description' => Str::substr($sortDes, 0, 100),
            'imgUrl'           => url($staticImg),
            'imgCarThumUrl'    => url($imgCarouselThumUrl),
            'name'             => $info->name,
            'name_slug'        => $info->name_slug,
            'sort_name'        => Str::substr($info->name, 0, 28)
        ];

        return $context;
    }

    public function showSpecialModuleList(Request $request)
    {
        $json = [];
        $params                    = $request->all();
        $params['information_ids'] = [];
        if (!empty($request->query('specialInfoIds'))) {
            $params['information_ids'] = array_reduce($request->query('specialInfoIds'), function ($carry, $item) {
                $info = json_decode($item);
                $carry[] = $info->id;
    
                return $carry;
            });
        }

        if (!empty($params['information_ids'])) {
            $infoCarousels = $this->newsSv->apiGetInfoCarouselListByIds($params);
            foreach ($infoCarousels as $info) {
                $images = unserialize($info->image);
                $staticImg     = self::$thumImgNo;
                if (empty($info->image_origin) && empty($images)) {
                    continue;
                }

                if (isset($images[0]['image']) && file_exists(public_path(rawurldecode('/Image/NewPicture/' . $images[0]['image'])))) {
                    $staticImg     = '/Image/NewPicture/' . $images[0]['image'];
                } else {
                    $staticImg = $info->image_origin;
                }

                $this->_getInforCarousel($json['results'], $info, $staticImg);
                
                if (($key = array_search($info->information_id, $params['information_ids'])) !== false) {
                    unset($params['information_ids'][$key]);
                }
            }

            if ($params['information_ids']) {
                $results = $this->newsSv->apiGetInfoListByIds($params);

                foreach ($results as $info) {
                    $staticImg     = self::$thumImgNo;
    
                    if ($info->image && file_exists(public_path(rawurldecode($info->image)))) {
                        $staticImg     = $info->image;
                    }

                    $this->_getInforCarousel($json['results'], $info, $staticImg);
                }
            }
        }

        return Helper::successResponse([
            'results' => $json['results']
        ]);
    }
}
