<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;

class RestrictIpAddressMiddleware
{
    private $__restrictedIp = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->getIps();

        if (!empty($this->__restrictedIp)) {
            if (in_array($request->ip(), $this->__restrictedIp)) {
                return $next($request);
            }

            abort(404);
        }
        
        return $next($request);
    }

    /**
     * get sec ips
     */
    public function getIps() {
        $ips = config('app.sec_ips');
        if (!empty($ips)) {
            $this->__restrictedIp = explode(',', $ips);
        }
    }
}
