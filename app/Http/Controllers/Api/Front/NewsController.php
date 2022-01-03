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
            $pageLists = [];
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json([
            'pageLists' => $pageLists
        ]);
    }

    public function list(Request $request)
    {
        $responseParams = [];
        $params         = $request->all();
        $page           = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        $params['page'] = $page;

        $limit = 10;
        if ($request->query('limit')) {
            $limit = $request->query('limit');
        }
        $params['limit']      = $limit;
        $params['renderType'] = 0;
        if ($request->query('renderType')) {
            $params['renderType'] = $request->query('renderType');
        }

        $widthThumbInfoList  = 184;
        $heightThumbInfoList = 120;
        $width               = 550;
        $height              = 450;

        $params['slug'] = isset($params['slug']) ? $params['slug'] : '';
        if (!empty($params['slug'])) {
            $slugs                 = explode('-', $params['slug']);
            $params['category_id'] = (int)end($slugs);
            if (isset($slugs[1]) && $slugs[1] == 'related') {
                $params['is_category_related'] = true;
                $width                         = 350;
                $height                        = 230;
            }
        }
        $params['isRootCateId'] = '';

        if (isset($params['slug'])) {
            $params['isRootCateId'] = $params['slug'];
        }
        if (isset($params['slug_1'])) {
            $params['isRootCateId'] = $params['slug_1'];
        }
        if (isset($params['slug_2'])) {
            $params['isRootCateId'] = $params['slug_2'];
        }
        if (isset($params['slug_3'])) {
            $params['isRootCateId'] = $params['slug_3'];
        }
        if (isset($params['slug_4'])) {
            $params['isRootCateId'] = $params['slug_4'];
        }
        if (isset($params['slug_5'])) {
            $params['isRootCateId'] = $params['slug_5'];
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

        $rootCategory = [];
        if ($params['renderType'] == 1) {
            $cateIdToSub = !empty($params['isRootCateId']) ? $params['isRootCateId'] : 0;
            if (!empty($cateIdToSub)) {
                $cateIdToSubSlugs = explode('-', $cateIdToSub);
                $cateIdToSub      = (int)end($cateIdToSubSlugs);
                $rootCategory     = $this->sv->apiGetCategoryById($cateIdToSub);
                $rootCategory     = array(
                    'name'     => $rootCategory->name,
                    'children' => [],
                    'link'     => $rootCategory->name_slug
                );
                $subCategories    = $this->sv->getMenuCategories($cateIdToSub);

                $link1           = $rootCategory['link'];
                $subCategoryMenu = [];
                foreach ($subCategories as $cate) {
                    // Level 2
                    $children_data_2 = array();

                    if (!empty($cate->name)) {
                        $children_2 = $this->sv->getMenuCategories($cate->category_id);

                        foreach ($children_2 as $child_2) {
                            $link_2 = $link1 . '/' . $cate->name_slug . '/' . $child_2->name_slug;
                            // Level 3
                            $children_data_3 = array();

                            if (!empty($child_2->name)) {
                                $children_3 = $this->sv->getMenuCategories($child_2->category_id);

                                foreach ($children_3 as $child_3) {
                                    $link_3 = $link_2 . '/' . $child_3->name_slug;
                                    // Level 4
                                    $children_data_4 = array();

                                    $children_4 = $this->sv->getMenuCategories($child_3->category_id);

                                    foreach ($children_4 as $child_4) {
                                        $link_4 = $link_3 . '/' . $child_4->name_slug;
                                        // Level 5
                                        $children_data_5 = array();

                                        $children_5 = $this->sv->getMenuCategories($child_4->category_id);

                                        foreach ($children_5 as $child_5) {
                                            $link_5 = $link_4 . '/' . $child_5->name_slug;

                                            // Level 5-1
                                            $filter_data = array(
                                                'filter_category_id'  => $child_5->category_id,
                                                'filter_sub_category' => true
                                            );

                                            $children_data_5[] = array(
                                                'name' => $child_5->name,
                                                'link' => $link_5
                                            );
                                        }

                                        // Level 4 - 1
                                        $filter_data = array(
                                            'filter_category_id'  => $child_4->category_id,
                                            'filter_sub_category' => true
                                        );

                                        $children_data_4[] = array(
                                            'name'     => $child_4->name,
                                            'children' => $children_data_5,
                                            'link'     => $link_4
                                        );
                                    }

                                    // Level 3 -1
                                    $filter_data = array(
                                        'filter_category_id'  => $child_3->category_id,
                                        'filter_sub_category' => true
                                    );

                                    $children_data_3[] = array(
                                        'name'     => $child_3->name,
                                        'children' => $children_data_4,
                                        'link'     => $link_3
                                    );
                                }
                            }

                            // Level 2 - 1
                            $filter_data = array(
                                'filter_category_id'  => $child_2->category_id,
                                'filter_sub_category' => true
                            );

                            $children_data_2[] = array(
                                'name'     => $child_2->name,
                                'children' => $children_data_3,
                                'link'     => $link_2
                            );
                        }
                    }

                    // Level 1
                    $subCategoryMenu[] = array(
                        'name'     => $cate->name,
                        'children' => $children_data_2,
                        'link'     => $link1 . '/' . $cate->name_slug
                    );
                }

                $rootCategory['children'] = $subCategoryMenu;
            }
        }

        $staticImg     = self::$thumImgNo;
        $staticThumImg = self::$thumImgNo;
        $infos         = [];
        foreach ($results as $key => $info) {
            if ($info->image && file_exists(public_path(rawurldecode($info->image)))) {
                $staticImg = rawurldecode($info->image);
            }

            if (in_array($request->query('moduleName'), ['module_tin_giao_hoi', 'module_tin_giao_hoi_viet_nam'])) {
                $width  = 350;
                $height = 230;
            }
            if ($request->query('moduleName') == 'module_loi_chua') {
                $width  = 287;
                $height = 191;
            }
            if ($request->query('moduleName') == 'module_tin_giao_phan') {
                $width  = 413;
                $height = 275;

                $width1               = 287;
                $height1              = 195;
                $staticThumMediumImg1 = (!empty($info->image)) ? $this->getThumbnail($info->image, $width1,
                    $height1) : $this->getThumbnail($staticImg, $width1, $height1);
            }
            if ($request->query('moduleName') == 'module_van_kien') {
                $width  = 223;
                $height = 152;
            }

            if ($params['renderType'] == 1) {
                $widthThumbInfoList  = 605;
                $heightThumbInfoList = 411;

                $staticThumImg = (!empty($info->image)) ? $this->getThumbnail($info->image, $widthThumbInfoList,
                    $heightThumbInfoList) : $this->getThumbnail($staticImg, $widthThumbInfoList, $heightThumbInfoList);
                $sortDes       = html_entity_decode($info->sort_description);
                $isImgRender   = ($key == 0);
                $infos[]       = [
                    'category_id'      => $info->category_id,
                    'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
                    'description'      => html_entity_decode($info->sort_description),
                    'sort_description' => Str::substr($sortDes, 0, 100),
                    'isImgRender'      => $isImgRender,
                    'imgUrl'           => url($staticImg),
                    'imgThumUrl'       => url($staticThumImg),
                    'information_id'   => $info->information_id,
                    'information_type' => $info->information_type,
                    'name'             => $info->name,
                    'name_slug'        => $info->name_slug,
                    'sort_name'        => Str::substr($info->name, 0, 50),
                    'viewed'           => $info->viewed,
                    'vote'             => $info->vote
                ];
            } else {
                $staticThumImg       = (!empty($info->image)) ? $this->getThumbnail($info->image, $widthThumbInfoList,
                    $heightThumbInfoList) : $this->getThumbnail($staticImg, $widthThumbInfoList, $heightThumbInfoList);
                $staticThumMediumImg = (!empty($info->image)) ? $this->getThumbnail($info->image, $width,
                    $height) : $this->getThumbnail($staticImg, $width, $height);

                $sortDes = html_entity_decode($info->sort_description);
                $infos[] = [
                    'category_id'       => $info->category_id,
                    'date_available'    => date_format(date_create($info->date_available), "d-m-Y"),
                    'description'       => html_entity_decode($info->sort_description),
                    'sort_description'  => Str::substr($sortDes, 0, 100),
                    'image'             => $staticImg,
                    'imgUrl'            => url($staticImg),
                    'imgThumUrl'        => url($staticThumImg),
                    'imgThumMediumImg'  => url($staticThumMediumImg),
                    'imgThumMediumImg1' => isset($staticThumMediumImg1) ? url($staticThumMediumImg1) : '',
                    'information_id'    => $info->information_id,
                    'information_type'  => $info->information_type,
                    'name'              => $info->name,
                    'name_slug'         => $info->name_slug,
                    'sort_name'         => Str::substr($info->name, 0, 50),
                    'viewed'            => $info->viewed,
                    'vote'              => $info->vote
                ];
            }
        }

        $responseParams['renderType'] = $params['renderType'];

        return Helper::successResponse([
            'results'         => $infos,
            'subCategoryMenu' => $rootCategory,
            'pagination'      => $pagination,
            'page'            => $page,
            'params'          => $responseParams
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

            $json['results']                  = $this->newsSv->apiGetInfo($params['information_id']);
            $albums = !empty($json['results']['albums']) ? $json['results']['albums']: [];
         
            if (!empty($albums)) {
                foreach ($albums[0]['images'] as $key => $img) {
                    if ($img['status']) {
                        $tmp = $img;
                        $tmp['width'] = (int)$img['width'];
                        $tmp['image'] = url('/Image/NewPicture/' . $img['image']);
                        $tmp['image_thumb'] = url($this->getThumbnail('/Image/NewPicture/' . $img['image'], 280, 280));
                        $json['results']['albums'][0]['images'][$key] = $tmp;
                    } else {
                        unset($json['results']['albums'][0]['images'][$key]);
                    }
                }
            }
        
            $json['result_category_relateds'] = $json['results']['related_category'];
        }

        return Helper::successResponse([
            'results'                  => $json['results'],
            'result_category_relateds' => $json['result_category_relateds']
        ]);
    }

    public function showLastedList(Request $request)
    {
        $json                = [];
        $widthThumbInfoList  = 184;
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
                        $staticImg = $info->image;
                    }

                    $staticThumImg      = (!empty($info->image)) ? $this->getThumbnail($info->image,
                        $widthThumbInfoList, $heightThumbInfoList) : $this->getThumbnail($staticImg,
                        $widthThumbInfoList, $heightThumbInfoList);
                    $imgCarouselThumUrl = (!empty($info->image)) ? $this->getThumbnail($info->image, 750,
                        550) : $this->getThumbnail($staticImg, 750, 550);

                    $sortDes = html_entity_decode($info->sort_description);

                    $json[] = [
                        'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
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
                        'vote'             => $info->vote,
                        'tag'              => $info->tag
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
        $json                = [];
        $widthThumbInfoList  = 184;
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

                $staticImg     = self::$thumImgNo;
                $staticThumImg = self::$thumImgNo;
                $json          = [];
                foreach ($results as $key => $info) {
                    $isImgRender = false;
                    if ($params['renderType'] == 1) {
                        $isImgRender = ($key == 0);
                    }
                    if ($info->image && file_exists(public_path(rawurldecode($info->image)))) {
                        $staticImg = $info->image;
                    }
                    $staticThumImg = (!empty($info->image)) ? $this->getThumbnail($info->image, $widthThumbInfoList,
                        $heightThumbInfoList) : $this->getThumbnail($staticImg, $widthThumbInfoList,
                        $heightThumbInfoList);
                    $sortDes       = html_entity_decode($info->sort_description);

                    $json[] = [
                        'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
                        'description'      => html_entity_decode($info->sort_description),
                        'sort_description' => Str::substr($sortDes, 0, 100),
                        'isImgRender'      => $isImgRender,
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

    private function _getInforCarousel(&$context, &$info, $staticImg)
    {
        $imgCarouselThumUrl = $this->getThumbnail($staticImg, 730, 410);
        $sortDes            = html_entity_decode($info->sort_description);

        $context[] = [
            'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
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
        $json['results']           = [];
        $params                    = $request->all();
        $params['information_ids'] = [];
        if (!empty($request->query('specialInfoIds'))) {
            $params['information_ids'] = array_reduce($request->query('specialInfoIds'), function ($carry, $item) {
                $info    = json_decode($item);
                $carry[] = $info->id;

                return $carry;
            });
        }

        if (!empty($params['information_ids'])) {
            $infoCarousels = $this->newsSv->apiGetInfoCarouselListByIds($params);
            foreach ($infoCarousels as $info) {
                $images    = unserialize($info->image);
                $staticImg = self::$thumImgNo;
                if (empty($info->image_origin) && empty($images)) {
                    continue;
                }

                if (isset($images[0]['image']) && file_exists(public_path(rawurldecode('/Image/NewPicture/' . $images[0]['image'])))) {
                    $staticImg = '/Image/NewPicture/' . $images[0]['image'];
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
                    $staticImg = self::$thumImgNo;

                    if ($info->image && file_exists(public_path(rawurldecode($info->image)))) {
                        $staticImg = $info->image;
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
