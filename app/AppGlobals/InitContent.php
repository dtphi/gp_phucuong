<?php

namespace App\AppGlobals;

use App\Http\Common\Tables;
use Request;
use DB;

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
        
        $layout = [];

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
            $layout = $this->__getLayoutContent('danh-muc-tin/*');
            
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

                $layout                       = $this->__getLayoutContent('tin-tuc/xem-nhieu');
            }

            if (isset($segments[1]) && Request::is('tin-tuc/chi-tiet*')) {
                $layout = $this->__getLayoutContent('tin-tuc/chi-tiet/*');
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
            $this->settings['meta_title'] = 'Video';

            if (isset($segments[1]) && Request::is('video/chi-tiet*')) {
                $layout = $this->__getLayoutContent('video/chi-tiet/*');
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
            } else {
                $layout = $this->__getLayoutContent('video');
            }
        }

        if (empty($layout)) {
            $layout = $this->__getLayoutContent();
        }

        $this->settings['page'] = $layout;
    }

    private function __getLayoutContent($route = '') 
    {
        $layout = [];

        $route = DB::table('pc_layout_routes')->where('route', $route)->first();
        $settings = DB::table('pc_layout_settings')->where('layout_id', $route->layout_id)->get();
        foreach ($settings as $setting) {
            $value = $setting->value;
            if ($setting->serialized == 1) {
                $value = unserialize($setting->value);
            } elseif ($setting->serialized == 2) {
                $value = json_decode($setting->value);
            }
            $layout[$setting->code] = $value;
        }

        return $layout;
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
}
