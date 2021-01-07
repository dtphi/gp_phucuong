<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api\Admin
 */
class AuthController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/admin/auth/login
     */
    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required|email|max:255',
            'password' => 'required|alpha_num|min:8|max:32'
        ];
        $attributes = [
            'email'    => 'メールアドレス',
            'password' => 'パスワード'
        ];
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $admin = Admin::getAdminByEmail($request['email'], true);

        if (!isset($admin) || (isset($admin) && $admin->deleted_at != null)) {
            return Helper::errorResponse([ 'email' => [ 'ログインに失敗しました。メールアドレスが間違っています。' ] ]);
        }
        if (!Hash::check($request['password'], $admin->password)) {
            return Helper::errorResponse([ 'password' => [ 'ログインに失敗しました。パスワードが間違っています。' ] ]);
        }
        if ($token = $this->guard()->attempt($request->only('email', 'password'))) {
            Admin::updateLastLoggedIn($this->guard()->id());

            return Helper::successResponse([ 'access_token' => $token ]);
        }
        return Helper::errorResponse([ 'password' => [ 'ログインに失敗しました。メールアドレスまたはパスワードが間違っています。' ] ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Refresh new JWT token.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/admin/auth/refresh
     */
    public function refresh()
    {
        return Helper::successResponse([ 'access_token' => $this->guard()->refresh() ]);
    }

    /**
     * Get admin user info.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/admin/auth/admin
     */
    public function admin()
    {
        $admin = Admin::find($this->guard()->id())->toArray();

        return Helper::successResponse([ 'admin' => $admin ]);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/admin/auth/logout
     */
    public function logout()
    {
        $this->guard()->logout();

        return Helper::successResponse();
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    private function guard()
    {
        return Auth::guard('admins');
    }
}
