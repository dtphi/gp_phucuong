<?php

namespace App\Http\Controllers\Api\Store;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\Store\RequestPassword;
use App\Models\Admin;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api\Store
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
     * @api POST /v1/store/auth/login
     */
    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required',
            'password' => 'required|min:8|max:32'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $store = Store::getStoreByCode($request['email'], true);

        if (!isset($store) || (isset($store) && $store->deleted_at != null)) {
            return Helper::errorResponse([ 'email' => [ 'ログインIDが正しくありません。' ] ]);
        }
        if (!Hash::check($request['password'], $store->password)) {
            return Helper::errorResponse([ 'password' => [ 'パスワードが正しくありません。' ] ]);
        }
        $credentials = [
            'code'     => $request->email,
            'password' => $request->password
        ];

        if ($token = $this->guard()->attempt($credentials)) {
            Store::updateLastLoggedIn($this->guard()->id());

            return Helper::successResponse([ 'access_token' => $token ]);
        }
        return Helper::errorResponse([ 'password' => [ 'ログインに失敗しました。メールアドレスまたはパスワードが間違っています。' ] ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Refresh new JWT token
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/store/auth/refresh
     */
    public function refresh()
    {
        return Helper::successResponse([ 'access_token' => $this->guard()->refresh() ]);
    }

    /**
     * Get store user info.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/store/auth/user
     */
    public function user()
    {
        $store = Store::find($this->guard()->id())->toArray();

        return Helper::successResponse([ 'store' => $store ]);
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/store/auth/check-deleted/{id}
     */
    public function checkDeleted($id = null)
    {
        if (!$id) {
            return Helper::errorResponse();
        }
        $store = Store::getStoreById($id, true);

        if (!isset($store)) {
            return Helper::errorResponse();
        }
        if ($store->deleted_at != null) {
            return Helper::errorResponse([], Response::HTTP_GONE);
        }
        return Helper::successResponse();
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/store/auth/logout
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
        return Auth::guard('stores');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/store/auth/reset-password
     */
    public function resetPassword(Request $request)
    {
        $store = Store::where('code', $request->email)->first();
        $admin = Admin::getAdminByEmail();

        if ($store) {
            $data = [
                'code' => $store->code,
                'name' => $store->name,
                'url'  => url('/admin/stores', [ $store->id ])
            ];
            $store->update([ 'requested_reissuance_at' => Carbon::now() ]);

            Mail::to($admin->email)->send(new RequestPassword($data));

            return Helper::successResponse();
        }
        return Helper::errorResponse([ 'email' => [ 'ログインIDが正しくありません。' ] ]);
    }
}
