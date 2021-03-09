<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\HandlerMsgCommon;
use Validator;

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
        $appNameKey = config('app.api_name_key') ? config('app.api_name_key'): $this->appName;
        $validator = Validator::make([
            'app'      => $request->get('app'),
            'app_name' => $appNameKey
        ], [
            'app' => 'required|string|same:app_name'
        ]);

        if ($validator->fails()) {
            throw new HandlerMsgCommon();
        }

        return $next($request);
    }
}
