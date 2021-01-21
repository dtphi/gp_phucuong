<?php
namespace App\AppGlobals;


class CSS {
    public $css = []; // all my css filename and path is store in here
    public $cssSetting = [];
    private $pathPlugin = '';
    private $pathAdminCss = '';
    private $pathInfo = '';
    public $testInfo = [];

    public function __construct() {
        $this->pathInfo = trim(request()->getPathInfo(),'/');
        $this->pathPlugin = asset('administrator/plugins');
        $this->pathAdminCss = asset('administrator/dist/css');

        $this->cssSetting['bodyClass'] = $this->mapBodyClass();
        $this->cssSetting['mapCss'] = $this->initCss();
        $this->cssSetting['mapScript'] = $this->initScript();

        /*Test information*/
        $testInfos = [
            'cssSetting' => $this->cssSetting,
            'pathInfo' => $this->pathInfo
        ];
        $this->testInfo = json_encode($testInfos);
    }

    public function getDistJsScript($src) {
        $path = asset('administrator/dist/js/' . $src);

        return "<script src='" . $path . "'></script>\n";
    }

    public function getPluginPathScript($src) {
        $path = asset('administrator/plugins/' . $src);

        return "<script src='" . $path . "'></script>\n";
    }

    public function getDistPathCss($src) {
        $path = asset('administrator/dist/css/' . $src);

        return "<link rel='stylesheet' href='" . $path . "'>\n";
    }

    public function getPluginPathCss($src) {
        $path = asset('administrator/plugins/' . $src);

        return "<link rel='stylesheet' href='" . $path . "'>\n";
    }

    // add css
    public function add($path, $filename) {
        $path = asset($path);
        $this->css[$filename] = $path;

        return $this->css;
    }

    // remove css
    public function remove($filename) {
        if(array_key_exists($filename, $this->css)) {
            unset($this->css[$filename]);
        }
    }

    // print css
    public function print() {
        $output = '';
        if(count($this->css)) {
            foreach($this->css as $filename => $path) {
                $output .= "<link rel='stylesheet' href='{$path}/{$filename}'>\n";
            }
        }
        echo $output;
    }

    private function initCss() {
        $cssStype = $this->mapCss();

        if (request()->is('admin/user*')) {
            $cssStype = $this->mapCssUser();
        }

        return $cssStype;
    }

    private function initScript() {
        $scripts = $this->mapScript();

        if (request()->is('admin/user*')) {
            $scripts = $this->mapScriptUser();
        }

        return $scripts;
    }

    public function mapCss() {
    	$output = '';
    	/*Font Awesome*/
    	$output .= "<link rel='stylesheet' href='/administrator/plugins/fontawesome-free/css/all.min.css'>\n";
    	/*Ionicons*/
    	$output .= "<link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>\n";
    	/*icheck bootstrap*/
    	$output .= "<link rel='stylesheet' href='/administrator/plugins/icheck-bootstrap/icheck-bootstrap.min.css'>\n";
    	/*Theme style*/
    	$output .= "<link rel='stylesheet' href='/administrator/dist/css/adminlte.min.css'>\n";
    	/*Google Font: Source Sans Pro*/
    	$output .= "<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700' rel='stylesheet'>\n";

    	$output .= "<link rel='stylesheet' href='/administrator/dist/css/custom.css'>\n";

    	return $output;
    }

    public function mapCssUser() {
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

    public function mapScript() {
    	$output = '';
    	$output .= "<script src='/administrator/plugins/jquery/jquery.min.js'></script>\n";
    	$output .= "<script src='/administrator/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>\n";
    	$output .= "<script src='/administrator/dist/js/adminlte.min.js'></script>\n";

    	return $output;
    }

    public function mapScriptUser() {
        /*<!-- jQuery -->*/
        $output = $this->getPluginPathScript('jquery/jquery.min.js');
        /*<!-- Bootstrap 4 -->*/
        $output .= $this->getPluginPathScript('bootstrap/js/bootstrap.bundle.min.js');
        /*<!-- DataTables -->*/
        $output .= $this->getPluginPathScript('datatables/jquery.dataTables.min.js');
        $output .= $this->getPluginPathScript('datatables-bs4/js/dataTables.bootstrap4.min.js');
        $output .= $this->getPluginPathScript('datatables-responsive/js/dataTables.responsive.min.js');
        $output .= $this->getPluginPathScript('datatables-responsive/js/responsive.bootstrap4.min.js');
        /*<!-- AdminLTE App -->*/
        $output .= $this->getDistJsScript('adminlte.js');

        $output .= $this->getDistJsScript('demo.js');

        $output .= "<script>
                      $(function () {
                        $('#example1').DataTable({
                          'paging': true,
                          'lengthChange': true,
                          'searching': true,
                          'ordering': true,
                          'info': true,
                          'autoWidth': false,
                          'responsive': true,
                        });
                      });
                    </script>";

        return $output;
    }

    public function mapBodyClass() {
        $optionClass = 'hold-transition login-page';
        if (request()->is('admin/user*')) {
            $optionClass = 'hold-transition sidebar-mini layout-fixed';
        }

        return $optionClass;
    }
}