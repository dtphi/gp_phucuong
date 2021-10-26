<?php
/**
 * Init css for Backend.
 */
namespace App\AppGlobals;

use Request;

final class CSS
{
    /**
     * all my css filename and path is store in here
     * @var array
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
     * CSS constructor.
     */
    public function __construct()
    {
        $request = request();

        $this->pathInfo     = trim($request->getPathInfo(), '/');
        $this->pathPlugin   = asset('administrator/plugins');
        $this->pathAdminCss = asset('administrator/dist/css');

        list($css, $script, $bodyClass) = $this->init();
        $this->cssSetting['mapCss']    = $css;
        $this->cssSetting['mapScript'] = $script;
        $this->cssSetting['bodyClass'] = $bodyClass;

        // true or false;
        $this->cssSetting['isFireBaseAuth'] = fn_is_prod_env();
        $this->cssSetting['isInternalLogin'] = fn_is_internal_admin_login();

        if (fn_is_prod_env()) {
            $this->cssSetting['pageDir'] = mix('js/admin-' . config('app.api_name_key') . '.js');
        } else if(fn_is_stg_env()) {
            $this->cssSetting['pageDir'] = asset('js/stg/app-admin.js');
        } else {
            $this->cssSetting['pageDir'] = asset('js/app-admin.js');
        }
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
     */
    public function add($path, $filename)
    {
        $path                 = asset($path);
        $this->css[$filename] = $path;

        return $this->css;
    }

    /**
     * remove css
     * @param $filename
     */
    public function remove($filename)
    {
        if (array_key_exists($filename, $this->css)) {
            unset($this->css[$filename]);
        }
    }

    /**
     * print css
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

    /**
     * @return array
     */
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
            $this->mapCssTest(),
            $this->mapScriptTest(),
            ''
        ];
    }

    /**
     * @return string
     */
    public function mapCssTest()
    {
        $output = '';


        return $output;
    }

    /**
     * @return string
     */
    public function mapScriptTest()
    {
        $output = '';
        /*<!-- jQuery -->*/
        $output .= "<script src='/administrator/javascript/jquery/jquery-2.1.1.min.js'></script>\n";
        $output .= "<script src='/administrator/plugins/jquery-ui/jquery-ui.min.js'></script>\n";
        $output .= "<script src='/administrator/javascript/bootstrap/js/bootstrap.min.js'></script>\n";

        return $output;
    }

    /**
     * @return string
     */
    private function _initCss()
    {
        $cssStype = $this->mapCss();

        if (request()->is('admin/user*')) {
            $cssStype = $this->mapCssUser();
        }

        return $cssStype;
    }

    /**
     * @return string
     */
    private function _initScript()
    {
        $scripts = $this->mapScript();

        if (request()->is('admin/user*')) {
            $scripts = $this->mapScriptUser();
        }

        return $scripts;
    }

    /**
     * @return string
     */
    public function mapCss()
    {
        $output = '';
        /*Font Awesome*/
        $output .= "<link rel='stylesheet' href='/administrator/plugins/fontawesome-free/css/all.min.css'>\n";
        /*Theme style*/
        $output .= "<link rel='stylesheet' href='/administrator/dist/css/adminlte.min.css'>\n";
        /*Google Font: Source Sans Pro*/
        $output .= "<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700' rel='stylesheet'>\n";

        $output .= "<link rel='stylesheet' href='/administrator/dist/css/custom.css'>\n";

        return $output;
    }

    /**
     * @return string
     */
    public function mapScriptFileManager()
    {
        $output = '';
        /*<!-- jQuery and jQuery UI (REQUIRED) -->*/

        $output .= "<script src='/packages/barryvdh/elfinder/jquery-1.11.0/jquery.min.js'></script>\n";
        $output .= "<script src='/packages/barryvdh/elfinder/jqueryui-1.10.4/jquery-ui.min.js'></script>\n";
        /*<!-- elFinder CSS (REQUIRED) -->*/

        /*<!-- elFinder JS (REQUIRED) -->*/
        $output .= "<script src='/packages/barryvdh/elfinder/js/elfinder.min.js'></script>\n";
        $output .= "<script src='/packages/barryvdh/elfinder/js/i18n/elfinder.vi.js'></script>\n";

        return $output;
    }

    /**
     * @return string
     */
    public function mapCssUser()
    {
        /*<!-- Font Awesome -->*/
        $output = $this->getPluginPathCss('fontawesome-free/css/all.min.css');
        /*<!-- DataTables -->*/
        $output .= $this->getPluginPathCss('datatables-bs4/css/dataTables.bootstrap4.min.css');
        $output .= $this->getPluginPathCss('datatables-responsive/css/responsive.bootstrap4.min.css');
        /*<!-- icheck bootstrap -->*/
        $output .= $this->getPluginPathCss('icheck-bootstrap/icheck-bootstrap.min.css');
        /*<!-- Theme style -->*/
        $output .= $this->getDistPathCss('adminlte.min.css');
        /*<!-- Google Font: Source Sans Pro -->*/
        $output .= "<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700' rel='stylesheet'>\n";
        /*<!-- Custom style -->*/
        $output .= $this->getDistPathCss('custom.css');

        return $output;
    }

    /**
     * @return string
     */
    public function mapCssNewsGroups()
    {
        /*<!-- Font Awesome -->*/
        $output = $this->getPluginPathCss('fontawesome-free/css/all.min.css');
        /*<!-- Ionicons -->*/
        $output .= "<link href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>\n";
        /*<!-- Tempusdominus Bbootstrap 4 -->*/
        $output .= $this->getPluginPathCss('tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
        /*<!-- iCheck -->*/
        $output .= $this->getPluginPathCss('icheck-bootstrap/icheck-bootstrap.min.css');
        /*<!-- JQVMap -->*/
        $output .= $this->getPluginPathCss('jqvmap/jqvmap.min.css');
        /*<!-- Theme style -->*/
        $output .= $this->getDistPathCss('adminlte.min.css');
        /*<!-- overlayScrollbars -->*/
        $output .= $this->getPluginPathCss('overlayScrollbars/css/OverlayScrollbars.min.css');
        /*<!-- Daterange picker -->*/
        $output .= $this->getPluginPathCss('daterangepicker/daterangepicker.css');
        /*<!-- summernote -->*/
        $output .= $this->getPluginPathCss('summernote/summernote-bs4.css');
        /*<!-- Google Font: Source Sans Pro -->*/
        $output .= "<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700' rel='stylesheet'>\n";
        /*<!-- Custom style -->*/
        $output .= $this->getDistPathCss('custom.css');

        return $output;
    }

    /**
     * @return string
     */
    public function mapScript()
    {
        $output = '';
        /*<!-- jQuery -->*/
        $output .= "<script src='/administrator/plugins/jquery/jquery.min.js'></script>\n";
        /*<!-- Bootstrap 4 -->*/
        $output .= "<script src='/administrator/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>\n";
        /*<!-- AdminLTE App -->*/
        $output .= "<script src='/administrator/dist/js/adminlte.min.js'></script>\n";

        return $output;
    }

    /**
     * @return string
     */
    public function mapScriptUser()
    {
        /*<!-- jQuery -->*/
        $output = $this->getPluginPathScript('jquery/jquery.min.js');
        /*<!-- Bootstrap 4 -->*/
        $output .= $this->getPluginPathScript('bootstrap/js/bootstrap.bundle.min.js');
        /*<!-- AdminLTE App -->*/
        $output .= $this->getDistJsScript('adminlte.min.js');

        return $output;
    }

    /**
     * @return string
     */
    public function mapScriptNews()
    {
        /*<!-- jQuery -->*/
        $output = $this->getPluginPathScript('jquery/jquery.min.js');
        /*<!-- Bootstrap 4 -->*/
        $output .= $this->getPluginPathScript('bootstrap/js/bootstrap.bundle.min.js');
        /*<!-- AdminLTE App -->*/
        $output .= $this->getDistJsScript('adminlte.min.js');

        return $output;
    }

    /**
     * @return string
     */
    public function mapScriptNewsGroups()
    {
        /*<!-- jQuery -->*/
        $output = $this->getPluginPathScript('jquery/jquery.min.js');
        /*<!-- Bootstrap 4 -->*/
        $output .= $this->getPluginPathScript('bootstrap/js/bootstrap.bundle.min.js');
        /*<!-- AdminLTE App -->*/
        $output .= $this->getDistJsScript('adminlte.min.js');

        $output .= "<script>
                       (function ($) {

                          let allPanels = $('.nested').hide();
                          let elements = $('.treeview-animated-element');

                          $('.treeview-animated-items-header').click(function () {
                            const self = $(this);
                            target = self.siblings('.nested');
                            pointerPlus = self.children('.fa-plus');
                            pointerMinus = self.children('.fa-minus');

                            pointerPlus.removeClass('fa-plus');
                            pointerPlus.addClass('fa-minus');
                            pointerMinus.removeClass('fa-minus');
                            pointerMinus.addClass('fa-plus');
                            self.toggleClass('open')
                            if (!target.hasClass('active')) {
                              target.addClass('active').slideDown();
                            } else {
                              target.removeClass('active').slideUp();
                            }
 
                            return false;
                          });
                          elements.click(function () {
                            self = $(this);

                            if (self.hasClass('opened')) {

                              elements.removeClass('opened');
                            } else {

                              elements.removeClass('opened');
                              self.addClass('opened');
                            }
                          })
                          })(jQuery);
                    </script>";

        return $output;
    }

    /**
     * @return string
     */
    public function mapBodyClass()
    {
        $optionClass = 'hold-transition login-page';
        if (request()->is('admin/user*')) {
            $optionClass = 'hold-transition sidebar-mini layout-fixed';
        }

        return $optionClass;
    }
}
