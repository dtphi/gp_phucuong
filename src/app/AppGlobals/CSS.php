<?php
namespace App\AppGlobals;


class CSS {
    public $css = []; // all my css filename and path is store in here

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

    public function mapCss() {
    	//dd(trim(request()->getPathInfo(),'/'));
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

    	echo $output;
    }

    public function mapScript() {
    	//dd(trim(request()->getPathInfo(),'/'));
    	$output = '';
    	$output .= "<script src='/administrator/plugins/jquery/jquery.min.js'></script>\n";
    	$output .= "<script src='/administrator/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>\n";
    	$output .= "<script src='/administrator/dist/js/adminlte.min.js'></script>\n";

    	echo $output;
    }
}