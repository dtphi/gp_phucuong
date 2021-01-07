<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use App\Models\Admin;
use App\Models\Representative;
use App\Models\Store;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Class AssignGuard
 *
 * @package App\Http\Middleware
 */
class AssignGuard
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null    $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard != null) {
            auth()->shouldUse($guard);
        }

        // Only check password changed or account deleted if the api isn't logout api
        $url = parse_url($request->url());

        if (strpos($url['path'], 'logout') === false) {
            $user = Auth::user();

            if (!($user instanceof Admin)) {
                $passwordLastChanged = isset($request->header()['passwordlastchanged'][0]) &&
                                       $request->header()['passwordlastchanged'][0] !== 'null' ? $request->header()['passwordlastchanged'][0] : null;

                $saleMainEmail = isset($request->header()['representativemainemail'][0]) &&
                                 $request->header()['representativemainemail'][0] !== 'null' ? $request->header()['representativemainemail'][0] : null;

                $storeCode = isset($request->header()['storecode'][0]) &&
                             $request->header()['storecode'][0] !== 'null' ? $request->header()['storecode'][0] : null;

                if ($user->password_last_changed_at !== $passwordLastChanged) {
                    return Helper::errorResponse([
                                                     'message' => 'パスワードが変更されました',
                                                     'logout'  => true,
                                                 ], Response::HTTP_FORBIDDEN);
                } else if ($user instanceof Representative && $user->main_email !== $saleMainEmail) {
                    return Helper::errorResponse([
                                                     'message' => 'メインメールアドレスが変更されました。',
                                                     'logout'  => true,
                                                 ], Response::HTTP_FORBIDDEN);
                } else if ($user instanceof Store && $user->code !== $storeCode) {
                    return Helper::errorResponse([
                                                     'message' => '販売店コードが変更されました。',
                                                     'logout'  => true,
                                                 ], Response::HTTP_FORBIDDEN);
                } else if ($user->deleted_at !== null) {
                    if ($user instanceof Representative) {
                        return Helper::errorResponse([
                                                         'message' => 'この営業担当者は既に削除されています。',
                                                         'logout'  => true,
                                                     ], Response::HTTP_FORBIDDEN);
                    }

                    if ($user instanceof Store) {
                        return Helper::errorResponse([
                                                         'message' => 'この販売店は既に削除されています。',
                                                         'logout'  => true,
                                                     ], Response::HTTP_FORBIDDEN);
                    }
                }
            }
        }
        return $next($request);
    }
}
