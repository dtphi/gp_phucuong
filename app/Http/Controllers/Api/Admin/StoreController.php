<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\Store\Create;
use App\Mail\Store\ResetPassword;
use App\Models\Message;
use App\Models\Representative;
use App\Models\Store;
use App\Rules\KatakanaAndSpace;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Class StoreController
 *
 * @package App\Http\Controllers\Api\Admin
 */
class StoreController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/admin/stores
     */
    public function index(Request $request)
    {
        $data = [
            'sort'      => 'stores.code',
            'direction' => 'desc',
            'page'      => $request['page'] ?: 1
        ];

        if (isset($request['q']) && !empty($request['q'])) {
            $data['search'] = $request['q'];
        }
        if (isset($request['sort']) && !empty($request['sort'])) {
            $data['sort'] = 'stores.' . $request['sort'];
        }
        if (isset($request['direction']) && !empty($request['direction'])) {
            $data['direction'] = $request['direction'];
        }
        $stores = Store::getStores($data);

        return Helper::successResponse([ 'stores' => $stores ]);
    }

    /**
     * @param null $number
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/admin/stores/get-employee/{number}
     */
    public function getEmployee($number = null)
    {
        if (!$number) {
            return Helper::errorResponse();
        }
        $validator = Validator::make([ 'employeeNumber' => $number ], [ 'employeeNumber' => 'required|digits:4|numeric' ], [], [ 'employeeNumber' => '担当者コード' ]);

        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $representative = Representative::getRepresentativeByEmployeeNumber($number);

        if (!isset($representative)) {
            return Helper::errorResponse([ 'employeeNumber' => [ 'この担当者コードは登録されていません。' ] ]);
        }
        return Helper::successResponse([ 'employee' => $representative ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/admin/stores/create
     */
    public function create(Request $request)
    {
        $errors = [];
        $rules = [
            'code'             => 'required|max:8|alpha_num',
            'name'             => 'required|max:40',
            'repLastName'      => 'nullable|max:20',
            'repFirstName'     => 'nullable|max:20',
            'repLastNameKana'  => [ 'nullable', 'max:20', new KatakanaAndSpace() ],
            'repFirstNameKana' => [ 'nullable', 'max:20', new KatakanaAndSpace() ],
            'phoneNumber'      => [ 'required', 'string:size:14', new PhoneNumber() ],
            'faxNumber'        => [ 'nullable', 'string:size:14', new PhoneNumber() ],
            'address'          => 'required|max:100',
            'mainEmail'        => 'nullable|email|max:255|different:subEmail1|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail1'        => 'nullable|email|max:255|different:mainEmail|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail2'        => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail3|different:subEmail4',
            'subEmail3'        => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail4',
            'subEmail4'        => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail3',
            'memo'             => 'nullable|max:1000'
        ];
        $attributes = [
            'code'             => '販売店コード',
            'name'             => '販売店名',
            'repLastName'      => '代表者性',
            'repFirstName'     => '代表者名',
            'repLastNameKana'  => '代表者フリガナ性',
            'repFirstNameKana' => '代表者フリガナ名',
            'phoneNumber'      => '電話番号',
            'faxNumber'        => 'FAX番号',
            'address'          => '住所',
            'mainEmail'        => 'メインメールアドレス',
            'subEmail1'        => 'サブメールアドレス1',
            'subEmail2'        => 'サブメールアドレス2',
            'subEmail3'        => 'サブメールアドレス3',
            'subEmail4'        => 'サブメールアドレス4',
            'memo'             => 'メモ'
        ];
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
        }
        if ($request['code']) {
            $codeExists = Store::checkCodeExists($request['code']);

            if ($codeExists) {
                if (!isset($errors['code'])) {
                    $errors['code'] = [];
                }
                $errors['code'][] = 'この販売店コードはすでにシステムに登録されています。';
            }
        }
        if ($request['mainEmail']) {
            $mainEmailExists = Store::checkMainEmailExists($request['mainEmail']);
            $mainEmailExistsInSale = Representative::checkMainEmailExists($request['mainEmail']);

            if ($mainEmailExists || $mainEmailExistsInSale) {
                if (!isset($errors['mainEmail'])) {
                    $errors['mainEmail'] = [];
                }
                $errors['mainEmail'][] = 'このメインメールアドレスはすでにシステムに登録されています。';
            }
        }
        if (!empty($errors)) {
            return Helper::errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $data = [
            'sale_rep_id'         => $request['saleRepId'],
            'code'                => $request['code'],
            'name'                => $request['name'],
            'rep_last_name'       => $request['repLastName'] ?: null,
            'rep_first_name'      => $request['repFirstName'] ?: null,
            'rep_last_name_kana'  => $request['repLastNameKana'] ?: null,
            'rep_first_name_kana' => $request['repFirstNameKana'] ?: null,
            'phone_number'        => $request['phoneNumber'],
            'fax_number'          => $request['faxNumber'] ?: null,
            'address'             => $request['address'] ?: null,
            'main_email'          => $request['mainEmail'] ?: null,
            'sub_email1'          => $request['subEmail1'] ?: null,
            'sub_email2'          => $request['subEmail2'] ?: null,
            'sub_email3'          => $request['subEmail3'] ?: null,
            'sub_email4'          => $request['subEmail4'] ?: null,
            'memo'                => $request['memo'] ?: null,
            'password'            => Helper::randomPassword()
        ];
        $id = Store::createStore($data);

        $mail = [
            'code'     => $data['code'],
            'name'     => $data['name'],
            'password' => $data['password'],
            'url'      => url('/admin/stores', [ $id ])
        ];

        Mail::to($this->guard()->user()->email)->send(new Create($mail));

        $representative = Representative::getRepresentativeById($request['saleRepId']);
        $data = [
            'store_id'    => $id,
            'sender_type' => 3,
            'sender_id'   => 0,
            'contents'    => $representative->full_name . 'さんが担当になりました',
            'meta'        => [
                'seen'      => false,
                'reactions' => []
            ]
        ];
        Message::createMessage($data);

        return Helper::successResponse();
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/admin/stores/check-deleted/{id}
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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/admin/stores/check-validated
     */
    public function checkValidated(Request $request)
    {
        $errors = [];
        $rules = [
            'code'      => 'nullable|max:8|alpha_num',
            'mainEmail' => 'nullable|email|max:255|different:subEmail1|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail1' => 'nullable|email|max:255|different:mainEmail|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail2' => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail3|different:subEmail4',
            'subEmail3' => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail4',
            'subEmail4' => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail3'
        ];
        $attributes = [
            'code'      => '販売店コード',
            'mainEmail' => 'メインメールアドレス',
            'subEmail1' => 'サブメールアドレス1',
            'subEmail2' => 'サブメールアドレス2',
            'subEmail3' => 'サブメールアドレス3',
            'subEmail4' => 'サブメールアドレス4'
        ];
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
        }
        if ($request['code']) {
            $codeExists = Store::checkCodeExists($request['code'], $request['id']);

            if ($codeExists) {
                if (!isset($errors['code'])) {
                    $errors['code'] = [];
                }
                $errors['code'][] = 'この販売店コードはすでにシステムに登録されています。';
            }
        }
        if ($request['mainEmail']) {
            $mainEmailExists = Store::checkMainEmailExists($request['mainEmail'], $request['id']);
            $mainEmailExistsInRepresentative = Representative::checkMainEmailExists($request['mainEmail']);

            if ($mainEmailExists || $mainEmailExistsInRepresentative) {
                if (!isset($errors['mainEmail'])) {
                    $errors['mainEmail'] = [];
                }
                $errors['mainEmail'][] = 'このメインメールアドレスはすでにシステムに登録されています。';
            }
        }
        if (!empty($errors)) {
            return Helper::errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return Helper::successResponse();
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/admin/stores/{id}
     */
    public function show($id = null)
    {
        if (!$id) {
            return Helper::errorResponse();
        }
        $store = Store::getStoreById($id);

        if (!isset($store)) {
            return Helper::errorResponse();
        }
        $store->last_logged_in = $store->last_logged_in_at ? date('Y年m月j日 G時i分', strtotime($store->last_logged_in_at)) : '';

        return Helper::successResponse([
                                           'store'    => $store,
                                           'employee' => Representative::getRepresentativeById($store->sale_rep_id)
                                       ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api PUT /v1/admin/stores/update
     */
    public function update(Request $request)
    {
        $errors = [];
        $rules = [
            'code'             => 'required|max:8|alpha_num',
            'name'             => 'required|max:40',
            'repLastName'      => 'nullable|max:20',
            'repFirstName'     => 'nullable|max:20',
            'repLastNameKana'  => [ 'nullable', 'max:20', new KatakanaAndSpace() ],
            'repFirstNameKana' => [ 'nullable', 'max:20', new KatakanaAndSpace() ],
            'phoneNumber'      => [ 'required', 'string:size:14', new PhoneNumber() ],
            'faxNumber'        => [ 'nullable', 'string:size:14', new PhoneNumber() ],
            'address'          => 'required|max:100',
            'mainEmail'        => 'nullable|email|max:255|different:subEmail1|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail1'        => 'nullable|email|max:255|different:mainEmail|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail2'        => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail3|different:subEmail4',
            'subEmail3'        => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail4',
            'subEmail4'        => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail3',
            'memo'             => 'nullable|max:1000'
        ];
        $attributes = [
            'code'             => '販売店コード',
            'name'             => '販売店名',
            'repLastName'      => '代表者性',
            'repFirstName'     => '代表者名',
            'repLastNameKana'  => '代表者フリガナ性',
            'repFirstNameKana' => '代表者フリガナ名',
            'phoneNumber'      => '電話番号',
            'faxNumber'        => 'FAX番号',
            'address'          => '住所',
            'mainEmail'        => 'メインメールアドレス',
            'subEmail1'        => 'サブメールアドレス1',
            'subEmail2'        => 'サブメールアドレス2',
            'subEmail3'        => 'サブメールアドレス3',
            'subEmail4'        => 'サブメールアドレス4',
            'memo'             => 'メモ'
        ];
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
        }
        if ($request['code']) {
            $codeExists = Store::checkCodeExists($request['code'], $request['id']);

            if ($codeExists) {
                if (!isset($errors['code'])) {
                    $errors['code'] = [];
                }
                $errors['code'][] = 'この販売店コードはすでにシステムに登録されています。';
            }
        }
        if ($request['mainEmail']) {
            $mainEmailExists = Store::checkMainEmailExists($request['mainEmail'], $request['id']);
            $mainEmailExistsInRepresentative = Representative::checkMainEmailExists($request['mainEmail']);

            if ($mainEmailExists || $mainEmailExistsInRepresentative) {
                if (!isset($errors['mainEmail'])) {
                    $errors['mainEmail'] = [];
                }
                $errors['mainEmail'][] = 'このメインメールアドレスはすでにシステムに登録されています。';
            }
        }
        if (!empty($errors)) {
            return Helper::errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $store = Store::getStoreById($request['id']);

        if ($store->sale_rep_id != $request['saleRepId']) {
            $data = [
                'store_id'    => $request['id'],
                'sender_type' => 3,
                'sender_id'   => 0,
                'contents'    => $request['saleRepName'] . 'さんが担当になりました',
                'meta'        => [
                    'seen'      => false,
                    'reactions' => []
                ]
            ];
            Message::createMessage($data);
            Message::rejectJoinByRepresentativeId($store->sale_rep_id);
        }
        $data = [
            'id'                  => $request['id'],
            'sale_rep_id'         => $request['saleRepId'],
            'code'                => $request['code'],
            'name'                => $request['name'],
            'rep_last_name'       => $request['repLastName'] ?: null,
            'rep_first_name'      => $request['repFirstName'] ?: null,
            'rep_last_name_kana'  => $request['repLastNameKana'] ?: null,
            'rep_first_name_kana' => $request['repFirstNameKana'] ?: null,
            'phone_number'        => $request['phoneNumber'],
            'fax_number'          => $request['faxNumber'] ?: null,
            'address'             => $request['address'] ?: null,
            'main_email'          => $request['mainEmail'] ?: null,
            'sub_email1'          => $request['subEmail1'] ?: null,
            'sub_email2'          => $request['subEmail2'] ?: null,
            'sub_email3'          => $request['subEmail3'] ?: null,
            'sub_email4'          => $request['subEmail4'] ?: null,
            'memo'                => $request['memo'] ?: null,
            'password'            => Helper::randomPassword()
        ];
        Store::updateStore($data);

        return Helper::successResponse();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api PUT /v1/admin/stores/update-last-logged-in
     */
    public function updateLastLoggedIn(Request $request)
    {
        $store = Store::getStoreById($request['id']);

        if (!isset($store)) {
            return Helper::errorResponse();
        }
        Store::updateLastLoggedIn($request['id']);

        return Helper::successResponse();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api PUT /v1/admin/stores/cancel-reset-password
     */
    public function cancelResetPassword(Request $request)
    {
        $store = Store::getStoreById($request['id']);

        if (!isset($store)) {
            return Helper::errorResponse();
        }
        Store::cancelResetPassword($request['id']);

        return Helper::successResponse();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api PUT /v1/admin/stores/reset-password
     */
    public function resetPassword(Request $request)
    {
        $store = Store::getStoreById($request['id']);

        if (!isset($store)) {
            return Helper::errorResponse();
        }
        $data = [
            'id'       => $request['id'],
            'code'     => $store->code,
            'name'     => $store->name,
            'url'      => url('/admin/stores', [ $request['id'] ]),
            'password' => Helper::randomPassword()
        ];
        Store::resetPassword($data);

        Mail::to($this->guard()->user()->email)->send(new ResetPassword($data));

        return Helper::successResponse();
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api DELETE /v1/admin/stores/delete/{id}
     */
    public function delete($id = null)
    {
        if (!$id) {
            return Helper::errorResponse();
        }
        $store = Store::getStoreById($id);

        if (!isset($store)) {
            return Helper::errorResponse();
        }
        $data = [
            'id'         => $id,
            'code'       => 'del-' . $id . '-' . $store->code,
            'main_email' => $store->main_email ? 'del-' . $id . '-' . $store->main_email : null
        ];
        Store::deleteStore($data);
        Message::rejectJoinByStoreId($id);

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
