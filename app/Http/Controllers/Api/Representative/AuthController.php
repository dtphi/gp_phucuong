<?php

namespace App\Http\Controllers\Api\Representative;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\Representative\ResetPassword;
use App\Models\Representative;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api\Representative
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
     * @api POST /v1/representative/auth/login
     */
    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required|email',
            'password' => 'required|min:8|max:32'
        ];
        $attributes = [
            'email'    => 'メールアドレス',
            'password' => 'パスワード'
        ];
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $representative = Representative::getRepresentativeByMainEmail($request['email'], true);

        if (!isset($representative) || (isset($representative) && $representative->deleted_at != null)) {
            return Helper::errorResponse([ 'email' => [ 'ログインIDが正しくありません。' ] ]);
        }
        if (!Hash::check($request['password'], $representative->password)) {
            return Helper::errorResponse([ 'password' => [ 'パスワードが正しくありません。' ] ]);
        }
        $credentials = [
            'main_email' => $request->email,
            'password'   => $request->password
        ];

        if ($token = $this->guard()->attempt($credentials)) {
            Representative::updateLastLoggedIn($this->guard()->id());

            return Helper::successResponse([ 'access_token' => $token ]);
        }
        return Helper::errorResponse([ 'password' => [ 'ログインに失敗しました。メールアドレスまたはパスワードが間違っています。' ] ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Refresh new JWT token.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/representative/auth/refresh
     */
    public function refresh()
    {
        return Helper::successResponse([ 'access_token' => $this->guard()->refresh() ]);
    }

    /**
     * Get sale representative user info.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/representative/auth/representative
     */
    public function representative()
    {
        $representative = Representative::find($this->guard()->id())->toArray();

        return Helper::successResponse([ 'representative' => $representative ]);
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/representative/auth/check-deleted/{id}
     */
    public function checkDeleted($id = null)
    {
        if (!$id) {
            return Helper::errorResponse();
        }
        $representative = Representative::getRepresentativeById($id, true);

        if (!isset($representative)) {
            return Helper::errorResponse();
        }
        if ($representative->deleted_at != null) {
            return Helper::errorResponse([], Response::HTTP_GONE);
        }
        return Helper::successResponse();
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/representative/auth/logout
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
        return Auth::guard('representatives');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/representative/auth/reset-password
     */
    public function resetPassword(Request $request)
    {
        $representative = Representative::where('main_email', $request->email)->first();

        if ($representative) {
            $data = [
                'id'              => $representative->id,
                'employee_number' => $representative->employee_number,
                'full_name'       => $representative->full_name,
                'url'             => url('/'),
                'password'        => Helper::randomPassword()
            ];
            Representative::resetPassword($data);

            Mail::to($representative->main_email)->send(new ResetPassword($data));

            return Helper::successResponse();
        }
        return Helper::errorResponse([ 'email' => [ 'ログインIDが正しくありません。' ] ]);
    }
}
