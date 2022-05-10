<?php

/**
 * Init css for Frontend.
 */

namespace App\AppGlobals;

use App\Http\Common\Tables;
use DB;
use Log;
use Request;

final class InitContent
{
    /**
     * @var array
     * all my css filename and path is store in here
     */
    public $css = [];

    /**
     * @var array
     */
    public $cssSetting = [];

    /**
     * @var array
     */
    public $testInfo = [];

    /**
     * InitContent constructor.
     */
    public function __construct()
    {
        $request = request();
        $flag    = '';
        
        if ($request->is('/') || $request->is('trang-chu*')) {
            $flag = 'trang-chu';
        }
        if ($request->is('danh-muc-tin*')) {
            $flag = 'danh-muc-tin';
        }
        if ($request->is('tin-tuc*')) {
            $flag = 'tin-tuc';
        }
        if ($request->is('tin-tuc/tags*')) {
            $flag = 'danh-muc-tin';
        }
        if ($request->is('video*')) {
            $flag = 'video';
        }
        if ($request->is('linh-muc*')) {
            $flag = 'linh-muc';
        }
        if ($request->is('giao-xu*')) {
            $flag = 'giao-xu';
        }
        if ($request->is('hanh-cac-thanh*')) {
            $flag = 'hanh-cac-thanh';
        }
        if ($request->is('danh-sach-linh-muc*')) {
          $flag = 'danh-sach-linh-muc';
        }

        if (!empty($flag)) {
            $this->pathInfo = trim($request->getPathInfo(), '/');

            $layout = [];

            $this->settings = [
                'og_url'           => $request->fullUrl(),
                'og_width'         => 500,
                'og_height'        => 300,
                'meta_title'       => 'GIÁO PHẬN PHÚ CƯỜNG ',
                'meta_description' => 'Chuyên trang truyền thông Giáo Phận Phú Cường',
                'meta_keyword'     => 'Giáo Phận Phú Cường, giao phan phu cuong',
                'og_image'         => url('images/default_image.jpg'),
            ];

            $segments = $request->segments();
            if (isset($segments[0]) && ($flag == 'danh-muc-tin')) {
                $model  = new \App\Models\CategoryDescription();
                $layout = $this->__getLayoutContent('danh-muc-tin/*');

                $this->settings['meta_title'] = 'Danh mục Giáo Phận Phú Cường';

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

            if (isset($segments[0]) && ($flag == 'tin-tuc')) {
                if (isset($segments[1]) && $request->is('tin-tuc/xem-nhieu*')) {
                    $layout = $this->__getLayoutContent('tin-tuc/xem-nhieu');

                    $this->settings['meta_title'] = 'Tin tức xem nhiều';
                }

                if (isset($segments[1]) && $request->is('tin-tuc/chi-tiet*')) {
                    $model  = new \App\Models\Information();
                    $layout = $this->__getLayoutContent('tin-tuc/chi-tiet/*');

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

            if (isset($segments[0]) && ($flag == 'video')) {
                $this->settings['meta_title'] = 'Video';

                if (isset($segments[1]) && $request->is('video/chi-tiet*')) {
                    $model  = new \App\Models\Information();
                    $layout = $this->__getLayoutContent('video/chi-tiet/*');

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

            if (isset($segments[0]) && ($flag == 'linh-muc')) {
                $this->settings['meta_title'] = 'Linh Mục';

                if (isset($segments[1]) && $request->is('linh-muc/chi-tiet*')) {
                    $layout = $this->__getLayoutContent('linh-muc');

                    $endSegment  = end($segments);
                    $arrSegments = explode('-', $endSegment);
                    $idSegment   = (int)end($arrSegments);

                    if ($idSegment) {
                        //
                    }
                } else {
                    $layout = $this->__getLayoutContent('linh-muc');
                }
            }

            if (isset($segments[0]) && ($flag == 'giao-xu')) {
                $this->settings['meta_title'] = 'Giáo xứ';

                if (isset($segments[1]) && $request->is('giao-xu/chi-tiet*')) {
                    $layout = $this->__getLayoutContent('giao-xu/chi-tiet/*');

                    $endSegment  = end($segments);
                    $arrSegments = explode('-', $endSegment);
                    $idSegment   = (int)end($arrSegments);

                    if ($idSegment) {
                        //
                    }
                } else {
                    $layout = $this->__getLayoutContent('giao-xu');
                }
            }

            if (isset($segments[0]) && ($flag == 'danh-sach-linh-muc')) {
              $this->settings['meta_title'] = 'Danh sách linh mục';

              if (isset($segments[1]) && $request->is('danh-sach-linh-muc/chi-tiet*')) {
                $layout = $this->__getLayoutContent('danh-sach-linh-muc/chi-tiet/*');

                $endSegment  = end($segments);
                $arrSegments = explode('-', $endSegment);
                $idSegment   = (int)end($arrSegments);

                if ($idSegment) {
                  //
                }
              } else {
                $layout = $this->__getLayoutContent('danh-sach-linh-muc');
              }
            }

            if (isset($segments[0]) && ($flag == 'hanh-cac-thanh')) {
                $this->settings['meta_title'] = 'Hành Các Thánh';

                if (isset($segments[1]) && $request->is('hanh-cac-thanh/*')) {
                    $layout = $this->__getLayoutContent('hanh-cac-thanh/chi-tiet/*');

                    $endSegment  = end($segments);
                    $arrSegments = explode('-', $endSegment);
                    $idSegment   = (int)end($arrSegments);

                    if ($idSegment) {
                        //
                    }
                } else {
                    $layout = $this->__getLayoutContent('hanh-cac-thanh');
                }
            }

            if (empty($layout)) {
                $layout = $this->__getLayoutContent();
            }

            $this->settings['page'] = $layout;
        } else {
            $this->settings['page'] = [];
        }

        $this->settings['isMix'] = config('app.is_mix');

        if ($request->is('linhmucadmin*')) {
            $this->settings['isLinhMucAdmin'] = true;
            $this->settings['viewTemplate'] = 'adminlinhmuc-' . config('app.env');
        }
        
        if (fn_is_prod_env()) {
            $this->settings['pageDir'] = config('app.is_mix') ? mix('js/front-' . config('app.api_name_key') . '.js'): asset('js/front-' . config('app.api_name_key') . '.js');
        } else if(fn_is_stg_env()) {
            $this->settings['pageDir'] = config('app.is_mix') ? mix('js/stg/app-front.js'): asset('js/stg/app-front.js');
        } else {
            $this->settings['pageDir'] = config('app.is_mix') ? mix('js/stg/app-front.js'): asset('js/app-front.js');
        }
    }

    /**
     * @return array
     */
    public static function getHeaderScript()
    {
        if (isset($_SERVER['HTTP_SEC_FETCH_DEST']) && ($_SERVER['HTTP_SEC_FETCH_DEST'] == 'script')) {
            return ['Content-Type' => 'text/javascript; charset=UTF-8'];
        }

        return [];
    }

    /**
     * @param string $route
     * @return array
     */
    private function __getLayoutContent($route = '')
    {
        $layout = [];

        $route    = DB::table(Tables::$layout_routes)->where('route', $route)->first();
        $settings = DB::table(Tables::$layout_settings)->where('layout_id', $route->layout_id)->get();
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

    /**
     * @param $src
     * @return string
     */
    public function getDistJsScript($src)
    {
        $path = asset('administrator/dist/js/' . $src);

        return "<script src='" . $path . "'></script>\n";
    }

    /**
     * @param $src
     * @return string
     */
    public function getPluginPathScript($src)
    {
        $path = asset('administrator/plugins/' . $src);

        return "<script src='" . $path . "'></script>\n";
    }

    /**
     * @param $src
     * @return string
     */
    public function getDistPathCss($src)
    {
        $path = asset('administrator/dist/css/' . $src);

        return "<link rel='stylesheet' href='" . $path . "'>\n";
    }

    /**
     * @param $src
     * @return string
     */
    public function getPluginPathCss($src)
    {
        $path = asset('administrator/plugins/' . $src);

        return "<link rel='stylesheet' href='" . $path . "'>\n";
    }

    /**
     * @param $path
     * @param $filename
     * @return array
     * add css
     */
    public function add($path, $filename)
    {
        $path                 = asset($path);
        $this->css[$filename] = $path;

        return $this->css;
    }

    /**
     * @param $filename
     * remove css
     */
    public function remove($filename)
    {
        if (array_key_exists($filename, $this->css)) {
            unset($this->css[$filename]);
        }
    }

    /**
     * print css.
     */
    public function printCss()
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
