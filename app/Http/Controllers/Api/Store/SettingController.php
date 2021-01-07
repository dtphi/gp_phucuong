<?php

namespace App\Http\Controllers\Api\Store;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Representative;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class SettingController
 *
 * @package App\Http\Controllers\Api\Store
 */
class SettingController extends Controller
{
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
     * @api POST /v1/store/setting/change-password
     */
    public function changePassword(Request $request)
    {
        $store = Store::find($this->guard()->id());

        $rules = [
            'old_password'              => 'required|min:8|max:32',
            'new_password'              => 'required|min:8|max:32|different:old_password',
            'new_password_confirmation' => 'required|same:new_password',
        ];

        $attributes = [
            'old_password'              => '古いパスワード',
            'new_password'              => '新しいパスワード',
            'new_password_confirmation' => '新しいパスワード(確認)',
        ];

        $messages = [
            'new_password_confirmation.same' => '新しいパスワードと確認用パスワードが一致しません。',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!Hash::check($request->old_password, $store->password)) {
            return Helper::errorResponse([ 'old_password' => [ '古いパスワードが間違っています。' ] ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $store->update([
            'password'                 => Hash::make($request->new_password),
            'password_last_changed_at' => Carbon::now(),
        ]);

        return Helper::successResponse();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/store/setting/change-email
     */
    public function changeEmail(Request $request)
    {
        $store = Store::find($this->guard()->id());

        $rules = [
            'main_email' => 'nullable|email|max:255|different:sub_email1|different:sub_email2|different:sub_email3|different:sub_email4',
            'sub_email1' => 'nullable|email|max:255|different:main_email|different:sub_email2|different:sub_email3|different:sub_email4',
            'sub_email2' => 'nullable|email|max:255|different:main_email|different:sub_email1|different:sub_email3|different:sub_email4',
            'sub_email3' => 'nullable|email|max:255|different:main_email|different:sub_email1|different:sub_email2|different:sub_email4',
            'sub_email4' => 'nullable|email|max:255|different:main_email|different:sub_email1|different:sub_email2|different:sub_email3'
        ];

        $attributes = [
            'main_email' => 'メインメールアドレス',
            'sub_email1' => 'サブメールアドレス1',
            'sub_email2' => 'サブメールアドレス2',
            'sub_email3' => 'サブメールアドレス3',
            'sub_email4' => 'サブメールアドレス4'
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->main_email) {
            if (Store::checkMainEmailExists($request->main_email, $store->id) || Representative::checkMainEmailExists($request->main_email)) {
                return Helper::errorResponse([ 'main_email' => [ 'このメインメールアドレスはすでにシステムに登録されています。' ] ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }    
        }
        
        $store->update($request->only('main_email', 'sub_email1', 'sub_email2', 'sub_email3', 'sub_email4'));

        return Helper::successResponse();
    }
}
