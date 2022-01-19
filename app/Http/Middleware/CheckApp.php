<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\HandlerMsgCommon;
use Validator;
use Str;

class CheckApp
{
    /**
     * @var string
     */
    public $appName = 'gp-phu-cuong';

    /**
     * @author : Phi .
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws HandlerMsgCommon
     */
    public function handle($request, Closure $next)
    {
        $appNameKey = config('app.api_name_key') ? config('app.api_name_key'): Str::random(16);
        $firebasePhoneAuthNameKey = config('app.api_firebase_phone_name_key') ? config('app.api_firebase_phone_name_key'): Str::random(32);
        $services = [];
        $servicesValid = [];
        if (fn_is_prod_env()) {
            $services = [
                'firebasephone' => $request->get('firebasephone'),
                'firebase_phone_auth' => $firebasePhoneAuthNameKey
            ];
            $servicesValid = ['firebasephone' => 'required|string|same:firebase_phone_auth'];
        }
        $validator = Validator::make(array_merge([
            'app'      => $request->get('app'),
            'app_name' => $appNameKey
        ], $services), array_merge( [
            'app' => 'required|string|same:app_name'
        ], $servicesValid));

        if ($validator->fails()) {
            throw new HandlerMsgCommon();
        }

        return $next($request);
    }
}
