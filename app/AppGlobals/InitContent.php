<?php

namespace App\AppGlobals;

use App\Http\Common\Tables;
use Request;

class InitContent
{
    public $css = []; // all my css filename and path is store in here
    public $cssSetting = [];
    private $pathPlugin = '';
    private $pathAdminCss = '';
    private $pathInfo = '';
    public $testInfo = [];

    public function __construct()
    {
        $this->pathInfo = trim(request()->getPathInfo(), '/');

        $networkTarget = ['facebook', 'twitter', 'linkedin', 'reddit'];

        $homeLayout = [
            'page'           => 'home',
            'layout_content' => [
                'content_top'           => true,
                'content_top_column'    => [
                    'right_column'   => true,
                    'middle_column'  => true,
                    'left_column'    => false,
                    'colClass'       => '8 notication',
                    'left_modules'   => [],
                    'middle_modules' => [
                        [
                            'moduleName' => Tables::$middle_module_info_carousel,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$middle_module_special_banner,
                            'sortOrder'  => 0
                        ],
                    ],
                    'right_modules'  => [],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 0,
                    'middle_column'  => 8,
                    'right_column'   => 4
                ],
                'content_bottom'        => true,
                'content_bottom_column' => [
                    'right_column'   => true,
                    'middle_column'  => true,
                    'left_column'    => false,
                    'left_modules'   => [],
                    'middle_modules' => [
                        [
                            'moduleName' => Tables::$module_middle_tin_giao_hoi,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_middle_tin_giao_phan,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_middle_van_kien,
                            'sortOrder'  => 0
                        ]
                    ],
                    'right_modules'  => [
                        [
                            'moduleName' => Tables::$module_right_lich_cong_giao,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_right_sach_noi_iframe,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_right_info_fanpage,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_right_youtube_hanh_cac_thanh,
                            'sortOrder'  => 0
                        ]
                    ],
                    'left_column'    => 0,
                    'middle_column'  => 8,
                    'right_column'   => 4
                ],
                'content_main'          => true,
                'content_main_column'   => [
                    'right_column'   => true,
                    'middle_column'  => true,
                    'left_column'    => false,
                    'left_modules'   => [],
                    'middle_modules' => [
                        [
                            'moduleName' => Tables::$module_middle_loi_chua,
                            'sortOrder'  => 0
                        ]
                    ],
                    'right_modules'  => [
                        [
                            'moduleName' => Tables::$module_right_category_icon_side_bar,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_right_thong_bao,
                            'sortOrder'  => 0
                        ]
                    ],
                    'both_column'    => true,
                    'both_modules'   => [
                        [
                            'moduleName' => Tables::$module_both_noi_bat,
                            'sortOrder'  => 0
                        ]
                    ],
                    'column_number'  => 2,
                    'left_column'    => 0,
                    'middle_column'  => 8,
                    'right_column'   => 4
                ]
            ]
        ];

        $categoryLayout = [
            'page'           => 'category',
            'layout_content' => [
                'content_top'           => true,
                'content_top_column'    => [
                    'right_column'   => true,
                    'middle_column'  => true,
                    'left_column'    => true,
                    'colClass'       => '5',
                    'left_modules'   => [
                        [
                            'moduleName'   => Tables::$module_left_category_sub_left_side_bar,
                            'sortOrder'    => 0,
                            'isShowMobile' => false
                        ],
                        [
                            'moduleName'     => Tables::$module_left_info_left_side_bar,
                            'sortOrder'      => 0,
                            'componentClass' => '',
                            'isShowMobile'   => false
                        ],
                        [
                            'moduleName'     => Tables::$module_left_category_left_side_bar,
                            'sortOrder'      => 0,
                            'componentClass' => '',
                            'isShowMobile'   => false
                        ],
                        [
                            'moduleName'     => Tables::$module_left_newsletter_register,
                            'sortOrder'      => 0,
                            'componentClass' => 'form test',
                            'isShowMobile'   => false
                        ],
                        [
                            'moduleName'     => Tables::$module_left_summary_contact,
                            'sortOrder'      => 0,
                            'componentClass' => 'logo test',
                            'isShowMobile'   => false
                        ]
                    ],
                    'middle_modules' => [],
                    'right_modules'  => [
                        [
                            'moduleName' => Tables::$module_right_thong_bao,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_right_lich_cong_giao,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_right_sach_noi_iframe,
                            'sortOrder'  => 0
                        ],
                        /*[
                            'moduleName'=> Tables::$module_right_info_fanpage,
                            'sortOrder'=> 0
                        ],*/
                        [
                            'moduleName' => Tables::$module_right_youtube_hanh_cac_thanh,
                            'sortOrder'  => 0
                        ]
                    ],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 2,
                    'middle_column'  => 7,
                    'right_column'   => 3,
                ],
                'content_bottom'        => true,
                'content_bottom_column' => [
                    'right_column'   => true,
                    'middle_column'  => true,
                    'left_column'    => false,
                    'colClass'       => '',
                    'left_modules'   => [],
                    'middle_modules' => [],
                    'right_modules'  => [
                    ],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 0,
                    'middle_column'  => 8,
                    'right_column'   => 4
                ],
                'content_main'          => false,
                'content_main_column'   => [
                    'right_column'   => false,
                    'middle_column'  => false,
                    'left_column'    => false,
                    'colClass'       => '',
                    'left_modules'   => [],
                    'middle_modules' => [],
                    'right_modules'  => [],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 2,
                    'middle_column'  => 6,
                    'right_column'   => 4
                ],
            ],
            'network'        => $networkTarget
        ];

        $videoLayout = [
            'page'           => 'video',
            'layout_content' => [
                'content_top'           => true,
                'content_top_column'    => [
                    'right_column'   => false,
                    'middle_column'  => true,
                    'left_column'    => true,
                    'colClass'       => '',
                    'left_modules'   => [
                        [
                            'moduleName'     => Tables::$module_left_info_left_side_bar,
                            'sortOrder'      => 0,
                            'componentClass' => '',
                            'isShowMobile'   => false
                        ],
                        [
                            'moduleName'     => Tables::$module_left_category_left_side_bar,
                            'sortOrder'      => 0,
                            'componentClass' => '',
                            'isShowMobile'   => false
                        ],
                        [
                            'moduleName'     => Tables::$module_left_newsletter_register,
                            'sortOrder'      => 0,
                            'componentClass' => 'form test',
                            'isShowMobile'   => false
                        ],
                        [
                            'moduleName'     => Tables::$module_left_summary_contact,
                            'sortOrder'      => 0,
                            'componentClass' => 'logo test',
                            'isShowMobile'   => false
                        ]
                    ],
                    'middle_modules' => [],
                    'right_modules'  => [],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 3,
                    'middle_column'  => 9,
                    'right_column'   => 0
                ],
                'content_bottom'        => false,
                'content_bottom_column' => [
                    'right_column'   => false,
                    'middle_column'  => false,
                    'left_column'    => false,
                    'colClass'       => '',
                    'left_modules'   => [],
                    'middle_modules' => [],
                    'right_modules'  => [],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 3,
                    'middle_column'  => 9,
                    'right_column'   => 0
                ],
                'content_main'          => false,
                'content_main_column'   => [
                    'right_column'   => false,
                    'middle_column'  => false,
                    'left_column'    => false,
                    'colClass'       => '',
                    'left_modules'   => [],
                    'middle_modules' => [],
                    'right_modules'  => [],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 3,
                    'middle_column'  => 9,
                    'right_column'   => 0
                ]
            ]
        ];

        $popularLayout = [
            'page'           => 'popular',
            'layout_content' => [
                'content_top'           => true,
                'content_top_column'    => [
                    'right_column'   => false,
                    'middle_column'  => true,
                    'left_column'    => true,
                    'colClass'       => '',
                    'left_modules'   => [
                        [
                            'moduleName'     => Tables::$module_left_info_left_side_bar,
                            'sortOrder'      => 0,
                            'componentClass' => '',
                            'isShowMobile'   => false
                        ],
                        [
                            'moduleName'     => Tables::$module_left_category_left_side_bar,
                            'sortOrder'      => 0,
                            'componentClass' => '',
                            'isShowMobile'   => false
                        ],
                        [
                            'moduleName'     => Tables::$module_left_newsletter_register,
                            'sortOrder'      => 0,
                            'componentClass' => 'form test',
                            'isShowMobile'   => false
                        ],
                        [
                            'moduleName'     => Tables::$module_left_summary_contact,
                            'sortOrder'      => 0,
                            'componentClass' => 'logo test',
                            'isShowMobile'   => false
                        ]
                    ],
                    'middle_modules' => [],
                    'right_modules'  => [],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 3,
                    'middle_column'  => 9,
                    'right_column'   => 0
                ],
                'content_bottom'        => false,
                'content_bottom_column' => [
                    'right_column'   => false,
                    'middle_column'  => false,
                    'left_column'    => false,
                    'colClass'       => '',
                    'left_modules'   => [],
                    'middle_modules' => [],
                    'right_modules'  => [],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 3,
                    'middle_column'  => 9,
                    'right_column'   => 0
                ],
                'content_main'          => false,
                'content_main_column'   => [
                    'right_column'   => false,
                    'middle_column'  => false,
                    'left_column'    => false,
                    'colClass'       => '',
                    'left_modules'   => [],
                    'middle_modules' => [],
                    'right_modules'  => [],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 3,
                    'middle_column'  => 9,
                    'right_column'   => 0
                ]
            ]
        ];

        $detail = [
            'page'           => 'detail',
            'layout_content' => [
                'content_top'           => true,
                'content_top_column'    => [
                    'right_column'   => true,
                    'middle_column'  => true,
                    'left_column'    => false,
                    'colClass'       => '8 notication',
                    'left_modules'   => [],
                    'middle_modules' => [],
                    'right_modules'  => [
                        [
                            'moduleName' => Tables::$module_right_thong_bao,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_right_lich_cong_giao,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_right_sach_noi_iframe,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_right_info_fanpage,
                            'sortOrder'  => 0
                        ],
                        [
                            'moduleName' => Tables::$module_right_youtube_hanh_cac_thanh,
                            'sortOrder'  => 0
                        ]
                    ],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 0,
                    'middle_column'  => 8,
                    'right_column'   => 4
                ],
                'content_bottom'        => false,
                'content_bottom_column' => [
                    'right_column'   => false,
                    'middle_column'  => false,
                    'left_column'    => false,
                    'colClass'       => '',
                    'left_modules'   => [],
                    'middle_modules' => [],
                    'right_modules'  => [],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 0,
                    'middle_column'  => 8,
                    'right_column'   => 4
                ],
                'content_main'          => false,
                'content_main_column'   => [
                    'right_column'   => true,
                    'middle_column'  => true,
                    'left_column'    => false,
                    'colClass'       => '8',
                    'left_modules'   => [],
                    'middle_modules' => [],
                    'right_modules'  => [],
                    'both_column'    => false,
                    'both_modules'   => [],
                    'column_number'  => 2,
                    'left_column'    => 0,
                    'middle_column'  => 8,
                    'right_column'   => 4
                ]
            ],
            'network'        => $networkTarget
        ];

        $layout = $homeLayout;

        $this->settings = [
            'og_url'           => request()->fullUrl(),
            'og_width'         => 500,
            'og_height'        => 300,
            'meta_title'       => 'GIÁO PHẬN PHÚ CƯỜNG ',
            'meta_description' => 'Chuyên trang truyền thông Giáo Phận Phú Cường',
            'meta_keyword'     => 'Giáo Phận Phú Cường, giao phan phu cuong',
            'og_image'         => url('images/default_image.jpg'),
        ];

        $segments = request()->segments();
        if (isset($segments[0]) && Request::is('danh-muc-tin*')) {
            $layout                       = $categoryLayout;
            $this->settings['meta_title'] = 'Danh mục Giáo Phận Phú Cường';
            $model                        = new \App\Models\CategoryDescription();

            $endSegment  = end($segments);
            $arrSegments = explode('-', $endSegment);
            $idSegment   = (int)end($arrSegments);

            if ($idSegment) {
                $result = $model->select()->where('category_id', $idSegment)->first();
                if ($result) {
                    $this->settings['meta_title']       = $result->meta_title;
                    $this->settings['meta_description'] = $result->meta_description;
                    $this->settings['meta_keyword']     = $result->meta_keyword;
                }
            }
        }

        if (isset($segments[0]) && Request::is('tin-tuc*')) {
            if (isset($segments[1]) && Request::is('tin-tuc/xem-nhieu*')) {
                $this->settings['meta_title'] = 'Tin tức xem nhiều';
                $layout                       = $popularLayout;
            }

            if (isset($segments[1]) && Request::is('tin-tuc/chi-tiet*')) {
                $layout = $detail;
                $model  = new \App\Models\Information();

                $endSegment  = end($segments);
                $arrSegments = explode('-', $endSegment);
                $idSegment   = (int)end($arrSegments);

                if ($idSegment) {
                    $result = $model->select()->where('information_id', $idSegment)->first();
                    if ($result) {
                        $this->settings['meta_title']       = $result->infoDes->meta_title;
                        $this->settings['meta_description'] = $result->infoDes->meta_description;
                        $this->settings['meta_keyword']     = $result->infoDes->meta_keyword;
                        $this->settings['og_image']         = url($result->image['path']);
                    }
                }
            }
        }

        if (isset($segments[0]) && Request::is('video*')) {
            $layout                       = $videoLayout;
            $this->settings['meta_title'] = 'Video';

            if (isset($segments[1]) && Request::is('video/chi-tiet*')) {
                $layout = $detail;
                $model  = new \App\Models\Information();

                $endSegment  = end($segments);
                $arrSegments = explode('-', $endSegment);
                $idSegment   = (int)end($arrSegments);

                if ($idSegment) {
                    $result = $model->select()->where('information_id', $idSegment)->first();
                    if ($result) {
                        $this->settings['meta_title']       = $result->infoDes->meta_title;
                        $this->settings['meta_description'] = $result->infoDes->meta_description;
                        $this->settings['meta_keyword']     = $result->infoDes->meta_keyword;
                        $this->settings['og_image']         = url($result->image['path']);
                    }
                }
            }
        }

        $this->settings['page'] = $layout;
    }

    public function getDistJsScript($src)
    {
        $path = asset('administrator/dist/js/' . $src);

        return "<script src='" . $path . "'></script>\n";
    }

    public function getPluginPathScript($src)
    {
        $path = asset('administrator/plugins/' . $src);

        return "<script src='" . $path . "'></script>\n";
    }

    public function getDistPathCss($src)
    {
        $path = asset('administrator/dist/css/' . $src);

        return "<link rel='stylesheet' href='" . $path . "'>\n";
    }

    public function getPluginPathCss($src)
    {
        $path = asset('administrator/plugins/' . $src);

        return "<link rel='stylesheet' href='" . $path . "'>\n";
    }

    // add css
    public function add($path, $filename)
    {
        $path                 = asset($path);
        $this->css[$filename] = $path;

        return $this->css;
    }

    // remove css
    public function remove($filename)
    {
        if (array_key_exists($filename, $this->css)) {
            unset($this->css[$filename]);
        }
    }

    // print css
    public function print()
    {
        $output = '';
        if (count($this->css)) {
            foreach ($this->css as $filename => $path) {
                $output .= "<link rel='stylesheet' href='{$path}/{$filename}'>\n";
            }
        }
        echo $output;
    }

    public function init()
    {
        if (Request::is('admin/filemanagers*')) {
            $cssStype = $this->mapCss();
            $scripts  = $this->mapScriptFileManager();
            $scripts  .= "<script src='/administrator/plugins/jquery-ui/jquery-ui.min.js'></script>\n";
            $scripts  .= "<script src='/administrator/javascript/bootstrap/js/bootstrap.min.js'></script>\n";

            return [
                '',
                $scripts,
                ''
            ];
        }

        return [
        ];
    }
}
