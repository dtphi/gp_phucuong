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
            $menus = [];
            $categories =  $this->sv->getMenuCategories(0);
    
            foreach ($categories as $cate) {
                    // Level 2
                    $children_data_2 = array();
    
                    $children_2 = $this->sv->getMenuCategories($cate->category_id);
    
                    foreach ($children_2 as $child_2) {
                        $path_2 = 'path=' . $cate->category_id . '_' . $child_2->category_id;
                        // Level 3
                        $children_data_3 = array();
    
                        $children_3 = $this->sv->getMenuCategories($child_2->category_id);
        
                        foreach ($children_3 as $child_3) {
                            $path_3 = $path_2 . '_' . $child_3->category_id;
                            // Level 4
                            $children_data_4 = array();
        
                            $children_4 = $this->sv->getMenuCategories($child_3->category_id);
            
                            foreach ($children_4 as $child_4) {
                                $path_4 = $path_3 . '_' . $child_4->category_id;
                                // Level 5
                                $children_data_5 = array();
            
                                $children_5 = $this->sv->getMenuCategories($child_4->category_id);
                
                                foreach ($children_5 as $child_5) {
                                    $path_5 = $path_4 . '_' . $child_5->category_id;
                                    $filter_data = array(
                                        'filter_category_id'  => $child_5->category_id,
                                        'filter_sub_category' => true
                                    );
                
                                    $children_data_5[] = array(
                                        'name'  => $child_5->name,
                                        'href'  => $path_5
                                    );
                                }

                                // Level 4 - 1
                                $filter_data = array(
                                    'filter_category_id'  => $child_4->category_id,
                                    'filter_sub_category' => true
                                );
            
                                $children_data_4[] = array(
                                    'name'  => $child_4->name,
                                    'children' => $children_data_5,
                                    'href'  => $path_4
                                );
                            }

                            // Level 3 -1
                            $filter_data = array(
                                'filter_category_id'  => $child_3->category_id,
                                'filter_sub_category' => true
                            );
        
                            $children_data_3[] = array(
                                'name'  => $child_3->name,
                                'children' => $children_data_4,
                                'href'  => $path_3
                            );
                        }
                        
                        // Level 2 - 1
                        $filter_data = array(
                            'filter_category_id'  => $child_2->category_id,
                            'filter_sub_category' => true
                        );
    
                        $children_data_2[] = array(
                            'name'  => $child_2->name,
                            'children' => $children_data_3,
                            'href'  => $path_2
                        );
                    }
    
                    // Level 1
                    $menus[] = array(
                        'name'     => $cate->name,
                        'children' => $children_data_2,
                        'href'     => 'path=' . $cate->category_id
                    );
            }

            $menuLayout_1 = [];
            $categories_1 = $this->sv->getMenuCategoriesToLayout(1);

            foreach($categories_1 as $cate_1) {
                 // Level 2
                 $children_data_2 = array();
    
                 $children_2 = $this->sv->getMenuCategories($cate_1->category_id);

                 foreach ($children_2 as $child_2) {
                    $path_2 = 'path=' . $cate_1->category_id . '_' . $child_2->category_id;

                    // Level 3
                    $children_data_3 = array();
    
                    $children_3 = $this->sv->getMenuCategories($child_2->category_id);
    
                    foreach ($children_3 as $child_3) {
                        $path_3 = $path_2 . '_' . $child_3->category_id;

                        // Level 3 -1
                        $filter_data = array(
                            'filter_category_id'  => $child_3->category_id,
                            'filter_sub_category' => true
                        );
    
                        $children_data_3[] = array(
                            'name'  => $child_3->name,
                            'children' => [],
                            'href'  => $path_3
                        );
                    }

                    // Level 2 - 1
                    $filter_data = array(
                        'filter_category_id'  => $child_2->category_id,
                        'filter_sub_category' => true
                    );

                    $children_data_2[] = array(
                        'name'  => $child_2->name,
                        'children' => $children_data_3,
                        'href'  => $path_2
                    );
                 }

                // Level 1
                $menuLayout_1[] = array(
                    'name'     => $cate_1->name,
                    'children' => $children_data_2,
                    'href'     => 'path=' . $cate_1->category_id
                );
            }
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $appImgPath = '/upload/app';
        $data['appList']  = [
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
        ];

        $data['logo'] = '/front/img/logo.png';
        $data['banner'] = '/images/banner_image.jpg';
        $data['menus'] = $menus;
        $data['menus_1'] = $menuLayout_1;
        $data['pages'] = [
            'home' => [
                'title' => 'Trang chủ',
                'id' => 1
            ],
            'video' => [
                'title' => 'Trang video',
                'id' => 2
            ],
            'news' => [
                'title' => 'Trang tin tức',
                'id' => 3
            ]  
        ];

        return response()->json($data);
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
