<?php
/**
 * The base controller .
 * Run check app middleware.
 */
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Middleware\CheckApp;

class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * @var string
     */
    public $appName = 'gp-phu-cuong';

    /**
     * @author: dtphi .
     * ApiController constructor.
     * @param array $middleware
     */
    public function __construct($middleware = [])
    {
        $middleware[] = CheckApp::class;

        return $this->middleware($middleware);
    }
}
