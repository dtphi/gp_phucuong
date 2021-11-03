<?php
/**
 * Restrict ip address middleware.
 */

namespace App\Http\Middleware;

use Log;
use Closure;
use App\Models\RestrictIp;
use Illuminate\Http\Request;

class RestrictIpAddressMiddleware
{
    /**
     * @var array
     */
    private $__restrictedIp = [];

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $this->getIps();
        if (!empty($this->__restrictedIp)) {
            if (in_array($request->ip(), $this->__restrictedIp)) {
                return $next($request);
            }

            abort(404);
        } else {
            if (fn_is_prod_env()) 
                abort(404);
        }

        return $next($request);
    }

    /**
     * get sec ips
     */
    public function getIps()
    {
        $ips = config('app.sec_ips');
        $clientIP = \Request::getClientIp(true);
        $model = RestrictIp::where('ip', '=', $clientIP)->first();
        if($model) {
            $ips = $ips. ',' .$model->ip;
        }
        if (!empty($ips)) {
            $this->__restrictedIp = explode(',', $ips);
        }
        return $ips; 
    }
}
