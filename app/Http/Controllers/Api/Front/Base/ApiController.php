<?php

namespace App\Http\Controllers\Api\Front\Base;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Api\Front\Services\Service;
use App\Http\Controllers\Api\Front\Services\SettingService;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Common\Tables;
use Image;
use Storage;

class ApiController extends Controller
{
    public static $thumImgNo = '/images/default_image.jpg';

    public static $thumSize = 200;

    public static $menuFullInfos = [63, 205, 207, 208, 209, 210, 211, 213, 214, 216, 220, 241, 248, 273];

    public static $tmbThumbDir = '.tmb';

    public static $disk = 'public';

    /**
     * @var Sv|null
     */
    protected $sv = null;

    /**
     * @var null
     */
    private $settingSv = null;

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
        $this->sv        = new Service();
        $this->settingSv = new SettingService();
    }

    public function getThumbnail($imgOrigin, $thumbSize = 0, $thumbHeight = 0, $force = false)
    {
        $imgThumUrl = '';
        if ($thumbSize <= 0) {
            $thumbSize = self::$thumSize;
        }

        $staticThumImg = rawurldecode(trim($imgOrigin, '/'));
        if (!file_exists(public_path('/' . $staticThumImg))) {
            $staticThumImg = trim(self::$thumImgNo, '/');
        }

        if ($force) {
            return $this->forceThumbnail($staticThumImg, $thumbSize, $thumbHeight);
        }

        if ((int)$thumbHeight > 0) {
            $thumbDir = self::$tmbThumbDir . '/thumb_' . $thumbSize . 'x' . $thumbHeight . '/' . $staticThumImg;
            if (file_exists(public_path('/' . 'storage/' . $thumbDir))) {
                return Storage::url($thumbDir);
            }

            return $this->forceThumbnail($staticThumImg, $thumbSize, $thumbHeight);
        } else {
            $thumbDir = self::$tmbThumbDir . '/' . $staticThumImg;
            if (file_exists(public_path('/' . 'storage/' . $thumbDir))) {
                return Storage::url($thumbDir);
            }

            return $this->forceThumbnail($staticThumImg, $thumbSize);
        }
    }

    public function forceThumbnail($staticThumImg, $thumbSize = 200, $thumbHeight = 0)
    {
        $fileResize = new File(public_path($staticThumImg));
        $extension  = $fileResize->extension();
        $thumbDir   = self::$tmbThumbDir . '/' . $staticThumImg;
        if ((int)$thumbHeight > 0) {
            $thumbDir = self::$tmbThumbDir . '/thumb_' . $thumbSize . 'x' . $thumbHeight . '/' . $staticThumImg;
            $resize   = Image::make($fileResize)->resize($thumbSize, $thumbHeight)->encode($extension);
        } else {
            $resize = Image::make($fileResize)->resize($thumbSize, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($extension);
        }

        Storage::disk(self::$disk)->put($thumbDir, $resize->__toString());

        return Storage::url($thumbDir);
    }

    /**
     * Get config app.
     */
    public function getSetting(Request $request)
    {
        $requestParams = $request->get('params');

        $pathName = isset($requestParams['pathName']) ? $requestParams['pathName'] : 'home';
        $pathName = trim($pathName, '/');

        try {
            $menus      = [];
            $categories = $this->sv->getMenuCategories(0);

            foreach ($categories as $cate) {
                // Level 2
                $children_data_2 = array();

                if (!empty($cate->name)) {
                    $children_2 = $this->sv->getMenuCategories($cate->category_id);

                    foreach ($children_2 as $child_2) {
                        $path_2 = 'path=' . $cate->category_id . '_' . $child_2->category_id;
                        $link_2 = $cate->name_slug . '/' . $child_2->name_slug;
                        // Level 3
                        $children_data_3 = array();

                        if (!empty($child_2->name)) {
                            $children_3 = $this->sv->getMenuCategories($child_2->category_id);

                            foreach ($children_3 as $child_3) {
                                $path_3 = $path_2 . '_' . $child_3->category_id;
                                $link_3 = $link_2 . '/' . $child_3->name_slug;
                                // Level 4
                                $children_data_4 = array();

                                $children_4 = $this->sv->getMenuCategories($child_3->category_id);

                                foreach ($children_4 as $child_4) {
                                    $path_4 = $path_3 . '_' . $child_4->category_id;
                                    $link_4 = $link_3 . '/' . $child_4->name_slug;
                                    // Level 5
                                    $children_data_5 = array();

                                    $children_5 = $this->sv->getMenuCategories($child_4->category_id);

                                    foreach ($children_5 as $child_5) {
                                        $path_5 = $path_4 . '_' . $child_5->category_id;
                                        $link_5 = $link_4 . '/' . $child_5->name_slug;

                                        // Level 5-1
                                        $filter_data = array(
                                            'filter_category_id'  => $child_5->category_id,
                                            'filter_sub_category' => true
                                        );

                                        $children_data_5[] = array(
                                            'name' => $child_5->name,
                                            'href' => $path_5,
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
                                        'href'     => $path_4,
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
                                    'href'     => $path_3,
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
                            'href'     => $path_2,
                            'link'     => $link_2
                        );
                    }
                }

                // Level 1
                $menus[] = array(
                    'name'     => $cate->name,
                    'children' => $children_data_2,
                    'href'     => 'path=' . $cate->category_id,
                    'link'     => $cate->name_slug
                );
            }

            $menuLayout_1 = [];

            $appImgPath      = '/upload/app';
            $data['appList'] = [
                [
                    'sort'         => 0,
                    'title'        => 'App website gppc',
                    'img'          => $appImgPath . '/app_website_gppc.png',
                    'hrefAppStore' => '/',
                    'hrefChPlay'   => '/'
                ],
                [
                    'sort'         => 1,
                    'title'        => 'App sách nói công giáo',
                    'img'          => $appImgPath . '/app_sach_noi_cong_giao.jpg',
                    'hrefAppStore' => '/',
                    'hrefChPlay'   => '/'
                ],
                [
                    'sort'         => 2,
                    'title'        => 'App tìm nhà thờ gần nhất',
                    'img'          => $appImgPath . '/app_tim_nha_tho.jpg',
                    'hrefAppStore' => 'https://apps.apple.com/us/app/tìm-nhà-thờ-gần-nhất/id1485257114?ls=1',
                    'hrefChPlay'   => 'https://play.google.com/store/apps/details?id=com.phucuong.churchfinder&hl=en_AU&gl=US'
                ],
            ];

            $banners['image'] = 'Image/NewPicture/home_banners/banner_image.png';
            $settings = $this->settingSv->apiGetSettingByCodes(Tables::$moduleSystemCode);
            if ($settings) {
                $banners = $settings->reduce(function ($carry, $item) {
                    if ($item->key_data == 'module_system_banners')
                        $carry = $item->value;
    
                    return ($item->serialized) ? unserialize($carry) : $carry;
                });
            }

            $data['logo']    = '/front/img/logo.png';
            $data['banner']  = isset($banners['image']) ? url($banners['image']) : url('Image/NewPicture/home_banners/banner_image.png');
            $data['menus']   = $menus;
            $data['menus_1'] = $menuLayout_1;

            $data['modules'] = $this->_getModules($request);

            $data['pages'] = [
                'home'  => [
                    'title' => 'Trang chủ',
                    'id'    => 1,
                ],
                'video' => [
                    'title' => 'Trang video',
                    'id'    => 2
                ],
                'news'  => [
                    'title' => 'Trang tin tức',
                    'id'    => 3
                ]
            ];

            $data['infoLasteds']  = $this->getLastedInfoList($request);
            $data['infoPopulars'] = $this->getPopularList($request);

        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json($data);
    }

    protected function _getModules(&$request)
    {
        $layout  = json_decode($request->get('layout'));
        $page    = isset($layout->page) ? $layout->page : 'home';
        $modules = [
            'module_noi_bat',
            'module_thong_bao',
            'module_category_left_side_bar',
            'module_special_info',
            'module_tin_giao_hoi_viet_nam',
            'module_tin_giao_hoi',
            'module_tin_giao_phan',
            'module_loi_chua',
            'module_van_kien',
            'module_category_icon_side_bar'
        ];

        $results = [];

        foreach ($modules as $module) {
            $moduleData       = $this->settingSv->apiGetList(['code' => $module]);
            $results[$module] = [];

            foreach ($moduleData as $setting) {
                $value = ($setting->serialized) ? unserialize($setting->value) : $setting->value;

                if (!empty($value)) {
                    if (is_array($value[0])) {
                        $results[$module][$setting->key_data] = $value;
                    } else {
                        $categories = $this->settingSv->apiGetCategoryByIds($value);
                        foreach ($categories as $cate) {
                            $results[$module][$setting->key_data][] = [
                                'name' => $cate->name,
                                'href' => 'path=' . $cate->category_id,
                                'link' => $cate->name_slug
                            ];
                        }
                    }
                } else {
                    $results[$module][$setting->key_data] = [];
                }
            }
        }

        return $results;
    }

    public function getLastedInfoList(Request $request)
    {
        $json = [];

        $list = $this->sv->apiGetLatestInfos(20)->toArray();

        if (!empty($list)) {
            $infoIds = array_reduce($list, function ($carry, $item) {
                $carry[] = $item['information_id'];

                return $carry;
            });

            if (!empty($infoIds)) {
                $params                    = $request->all();
                $params['information_ids'] = $infoIds;

                $results = $this->sv->apiGetInfoListByIds($params);

                $json = [];
                foreach ($results as $info) {
                    $sortDes = html_entity_decode($info->sort_description);

                    $json[] = [
                        'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
                        'description'      => html_entity_decode($info->sort_description),
                        'sort_description' => Str::substr($sortDes, 0, 100),
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

        return $json;
    }

    public function getPopularList(Request $request)
    {
        $json = [];

        if (!empty($request->query('slug'))) {
            return $this->list($request);
        }

        $list = $this->sv->apiGetPopularInfos(20)->toArray();

        if (!empty($list)) {
            $infoIds = array_reduce($list, function ($carry, $item) {
                $carry[] = $item['information_id'];

                return $carry;
            });

            if (!empty($infoIds)) {
                $params                    = $request->all();
                $params['information_ids'] = $infoIds;

                $results = $this->sv->apiGetInfoListByIds($params);

                $json = [];
                foreach ($results as $info) {
                    $sortDes = html_entity_decode($info->sort_description);

                    $json[] = [
                        'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
                        'description'      => html_entity_decode($info->sort_description),
                        'sort_description' => Str::substr($sortDes, 0, 100),
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

        return $json;
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

                $newsGroupTree[$data[$i]['id']]['children'] = $this->generateTree($data, $data[$i]['id'],
                    $depth + 1);
            }
        }

        return $newsGroupTree;
    }
}
