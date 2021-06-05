<?php

namespace App\AppGlobals;

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
        $this->pathInfo     = trim(request()->getPathInfo(), '/');

        $this->settings = [
            'og_url' => request()->fullUrl(),
            'og_width' => 500,
            'og_height' => 300,
            'meta_title' => 'GIÁO PHẬN PHÚ CƯỜNG ',
            'meta_description' => 'Chuyên trang truyền thông Giáo Phận Phú Cường',
            'meta_keyword' => 'Giáo Phận Phú Cường, giao phan phu cuong',
            'og_image' => 'http://localhost:8000/images/default_image.jpg',
        ];

        $segments = request()->segments();
        if (isset($segments[0]) && $segments[0] == 'danh-muc-tin') {
            $model = new \App\Models\CategoryDescription();

            $endSegment = end($segments);
            $arrSegments = explode('-', $endSegment);
            $idSegment = (int)end($arrSegments);

            if ($idSegment) {
                $result = $model->select()->where('category_id', $idSegment)->first();
                if ($result) {
                    $this->settings['meta_title'] = $result->meta_title;
                    $this->settings['meta_description'] = $result->meta_description;
                    $this->settings['meta_keyword'] = $result->meta_keyword;
                }
            }
        }
        
        if (isset($segments[0]) && $segments[0] == 'tin-tuc') {
            $model = new \App\Models\Information();
            
            $endSegment = end($segments);
            $arrSegments = explode('-', $endSegment);
            $idSegment = (int)end($arrSegments);

            if ($idSegment) {
                $result = $model->select()->where('information_id', $idSegment)->first();
                if ($result) {
                    $this->settings['meta_title'] = $result->infoDes->meta_title;
                    $this->settings['meta_description'] = $result->infoDes->meta_description;
                    $this->settings['meta_keyword'] = $result->infoDes->meta_keyword;
                    $this->settings['og_image'] = url($result->image['path']);
                }
            }
        }
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
        /*$optionClass = 'hold-transition login-page';
        $cssStype    = $this->mapCss();
        $scripts     = '';

        if (Request::is('admin/test')) {
            $cssStype    = $this->mapCssTest();
            $scripts     = $this->mapScriptTest();
            $optionClass = '';
        }

        if (Request::is('admin/dashboard')) {
            $cssStype    = $this->mapCssTest();
            $scripts     = $this->mapScriptTest();
            $optionClass = '';
        }

        if (Request::is('admin/user*')) {
            $cssStype    = $this->mapCssUser();
            $scripts     = $this->mapScriptUser();
            $optionClass = 'hold-transition sidebar-mini layout-fixed';
        } elseif (Request::is('admin/news*') && !Request::is('*-groups*')) {
            $cssStype    = $this->mapCssUser();
            $scripts     = $this->mapScriptNews();
            $scripts     .= $this->mapScriptFileManager();
            $optionClass = 'hold-transition sidebar-mini layout-fixed';
        } elseif (Request::is('admin/news-groups*')) {
            $cssStype    = $this->mapCssNewsGroups();
            $scripts     = $this->mapScriptNewsGroups();
            $optionClass = 'hold-transition sidebar-mini layout-fixed';
        } elseif (Request::is('admin/filemanagers*')) {
            $cssStype    = $this->mapCss();
            $scripts     = $this->mapScriptFileManager();
            $optionClass = 'hold-transition sidebar-mini layout-fixed';

            return [
                $this->mapCss(),
                $this->mapScriptFileManager(),
                ''
            ];
        }*/

        if (Request::is('admin/filemanagers*')) {
            $cssStype    = $this->mapCss();
            $scripts     = $this->mapScriptFileManager();
            $scripts     .= "<script src='/administrator/plugins/jquery-ui/jquery-ui.min.js'></script>\n";
            $scripts     .= "<script src='/administrator/javascript/bootstrap/js/bootstrap.min.js'></script>\n";

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
