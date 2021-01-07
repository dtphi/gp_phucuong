<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\Representative\Create;
use App\Mail\Representative\ResetPassword;
use App\Models\Message;
use App\Models\Representative;
use App\Models\Store;
use App\Rules\KatakanaAndSpace;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Class RepresentativeController
 *
 * @package App\Http\Controllers\Api\Admin
 */
class RepresentativeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/admin/sales-representatives
     */
    public function index(Request $request)
    {
        $data = [
            'sort'      => 'employee_number',
            'direction' => 'desc',
            'page'      => $request['page'] ?: 1
        ];

        if (isset($request['q']) && !empty($request['q'])) {
            $data['search'] = $request['q'];
        }
        if (isset($request['sort']) && !empty($request['sort'])) {
            $data['sort'] = $request['sort'];
        }
        if (isset($request['direction']) && !empty($request['direction'])) {
            $data['direction'] = $request['direction'];
        }
        $representatives = Representative::getRepresentatives($data);

        return Helper::successResponse([ 'representatives' => $representatives ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/admin/sales-representatives/create
     */
    public function create(Request $request)
    {
        $errors = [];
        $rules = [
            'employeeNumber' => 'required|digits:4|numeric',
            'lastName'       => 'required|max:20',
            'firstName'      => 'required|max:20',
            'lastNameKana'   => [ 'required', 'max:20', new KatakanaAndSpace() ],
            'firstNameKana'  => [ 'required', 'max:20', new KatakanaAndSpace() ],
            'phoneNumber'    => [ 'required', 'string:size:14', new PhoneNumber() ],
            'mainEmail'      => 'required|email|max:255|different:subEmail1|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail1'      => 'nullable|email|max:255|different:mainEmail|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail2'      => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail3|different:subEmail4',
            'subEmail3'      => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail4',
            'subEmail4'      => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail3'
        ];
        $attributes = [
            'employeeNumber' => '担当者コード',
            'lastName'       => '姓',
            'firstName'      => '名',
            'lastNameKana'   => 'カナ姓',
            'firstNameKana'  => 'カナ名',
            'phoneNumber'    => '電話番号',
            'mainEmail'      => 'メインメールアドレス',
            'subEmail1'      => 'サブメールアドレス1',
            'subEmail2'      => 'サブメールアドレス2',
            'subEmail3'      => 'サブメールアドレス3',
            'subEmail4'      => 'サブメールアドレス4'
        ];
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
        }
        if ($request['employeeNumber']) {
            $employeeNumberExists = Representative::checkEmployeeNumberExists($request['employeeNumber']);

            if ($employeeNumberExists) {
                if (!isset($errors['employeeNumber'])) {
                    $errors['employeeNumber'] = [];
                }
                $errors['employeeNumber'][] = 'この担当者コードはすでにシステムに登録されています。';
            }
        }
        if ($request['mainEmail']) {
            $mainEmailExists = Representative::checkMainEmailExists($request['mainEmail']);
            $mainEmailExistsInStore = Store::checkMainEmailExists($request['mainEmail']);

            if ($mainEmailExists || $mainEmailExistsInStore) {
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
            'employee_number' => $request['employeeNumber'],
            'last_name'       => $request['lastName'],
            'first_name'      => $request['firstName'],
            'last_name_kana'  => $request['lastNameKana'],
            'first_name_kana' => $request['firstNameKana'],
            'phone_number'    => $request['phoneNumber'],
            'main_email'      => $request['mainEmail'],
            'sub_email1'      => $request['subEmail1'] ?: null,
            'sub_email2'      => $request['subEmail2'] ?: null,
            'sub_email3'      => $request['subEmail3'] ?: null,
            'sub_email4'      => $request['subEmail4'] ?: null,
            'password'        => Helper::randomPassword()
        ];
        Representative::createRepresentative($data);

        $mail = [
            'employee_number' => $data['employee_number'],
            'full_name'       => $data['last_name'] . '　' . $data['first_name'],
            'main_email'      => $data['main_email'],
            'password'        => $data['password'],
            'url'             => url('/')
        ];
        Mail::to($data['main_email'])->send(new Create($mail));

        return Helper::successResponse();
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/admin/sales-representatives/check-deleted/{id}
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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/admin/sales-representatives/check-validated
     */
    public function checkValidated(Request $request)
    {
        $errors = [];
        $rules = [
            'employeeNumber' => 'nullable|digits:4|numeric',
            'mainEmail'      => 'nullable|email|max:255|different:subEmail1|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail1'      => 'nullable|email|max:255|different:mainEmail|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail2'      => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail3|different:subEmail4',
            'subEmail3'      => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail4',
            'subEmail4'      => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail3'
        ];
        $attributes = [
            'employeeNumber' => '担当者コード',
            'mainEmail'      => 'メインメールアドレス',
            'subEmail1'      => 'サブメールアドレス1',
            'subEmail2'      => 'サブメールアドレス2',
            'subEmail3'      => 'サブメールアドレス3',
            'subEmail4'      => 'サブメールアドレス4'
        ];
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
        }
        if ($request['employeeNumber']) {
            $employeeNumberExists = Representative::checkEmployeeNumberExists($request['employeeNumber'], $request['id']);

            if ($employeeNumberExists) {
                if (!isset($errors['employeeNumber'])) {
                    $errors['employeeNumber'] = [];
                }
                $errors['employeeNumber'][] = 'この担当者コードはすでにシステムに登録されています。';
            }
        }
        if ($request['mainEmail']) {
            $mainEmailExists = Representative::checkMainEmailExists($request['mainEmail'], $request['id']);
            $mainEmailExistsInStore = Store::checkMainEmailExists($request['mainEmail']);

            if ($mainEmailExists || $mainEmailExistsInStore) {
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
     * @api GET /v1/admin/sales-representatives/show/{id}
     */
    public function show($id = null)
    {
        if (!$id) {
            return Helper::errorResponse();
        }
        $representative = Representative::getRepresentativeById($id);

        if (!isset($representative)) {
            return Helper::errorResponse();
        }
        $representative->last_logged_in = $representative->last_logged_in_at ? date('Y年m月j日 G時i分', strtotime($representative->last_logged_in_at)) : '';

        return Helper::successResponse([
                                           'representative' => $representative,
                                           'dealers'        => Store::getDealers($id)
                                       ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api PUT /v1/admin/sales-representatives/update
     */
    public function update(Request $request)
    {
        $errors = [];
        $rules = [
            'employeeNumber' => 'required|digits:4|numeric',
            'lastName'       => 'required|max:20',
            'firstName'      => 'required|max:20',
            'lastNameKana'   => [ 'required', 'max:20', new KatakanaAndSpace() ],
            'firstNameKana'  => [ 'required', 'max:20', new KatakanaAndSpace() ],
            'phoneNumber'    => [ 'required', 'string:size:14', new PhoneNumber() ],
            'mainEmail'      => 'required|email|max:255|different:subEmail1|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail1'      => 'nullable|email|max:255|different:mainEmail|different:subEmail2|different:subEmail3|different:subEmail4',
            'subEmail2'      => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail3|different:subEmail4',
            'subEmail3'      => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail4',
            'subEmail4'      => 'nullable|email|max:255|different:mainEmail|different:subEmail1|different:subEmail2|different:subEmail3'
        ];
        $attributes = [
            'employeeNumber' => '担当者コード',
            'lastName'       => '姓',
            'firstName'      => '名',
            'lastNameKana'   => 'カナ姓',
            'firstNameKana'  => 'カナ名',
            'phoneNumber'    => '電話番号',
            'mainEmail'      => 'メインメールアドレス',
            'subEmail1'      => 'サブメールアドレス1',
            'subEmail2'      => 'サブメールアドレス2',
            'subEmail3'      => 'サブメールアドレス3',
            'subEmail4'      => 'サブメールアドレス4'
        ];
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
        }
        if ($request['employeeNumber']) {
            $employeeNumberExists = Representative::checkEmployeeNumberExists($request['employeeNumber'], $request['id']);

            if ($employeeNumberExists) {
                if (!isset($errors['employeeNumber'])) {
                    $errors['employeeNumber'] = [];
                }
                $errors['employeeNumber'][] = 'この担当者コードはすでにシステムに登録されています。';
            }
        }
        if ($request['mainEmail']) {
            $mainEmailExists = Representative::checkMainEmailExists($request['mainEmail'], $request['id']);
            $mainEmailExistsInStore = Store::checkMainEmailExists($request['mainEmail']);

            if ($mainEmailExists || $mainEmailExistsInStore) {
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
            'id'              => $request['id'],
            'employee_number' => $request['employeeNumber'],
            'last_name'       => $request['lastName'],
            'first_name'      => $request['firstName'],
            'last_name_kana'  => $request['lastNameKana'],
            'first_name_kana' => $request['firstNameKana'],
            'phone_number'    => $request['phoneNumber'],
            'main_email'      => $request['mainEmail'],
            'sub_email1'      => $request['subEmail1'] ?: null,
            'sub_email2'      => $request['subEmail2'] ?: null,
            'sub_email3'      => $request['subEmail3'] ?: null,
            'sub_email4'      => $request['subEmail4'] ?: null
        ];
        Representative::updateRepresentative($data);

        return Helper::successResponse();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api PUT /v1/admin/sales-representatives/reset-password
     */
    public function resetPassword(Request $request)
    {
        $representative = Representative::getRepresentativeById($request['id']);

        if (!isset($representative)) {
            return Helper::errorResponse();
        }
        $data = [
            'id'              => $request['id'],
            'employee_number' => $representative->employee_number,
            'full_name'       => $representative->full_name,
            'url'             => url('/'),
            'password'        => Helper::randomPassword()
        ];
        Representative::resetPassword($data);

        Mail::to($representative->main_email)->send(new ResetPassword($data));

        return Helper::successResponse();
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api DELETE /v1/admin/sales-representatives/delete/{id}
     */
    public function delete($id = null)
    {
        if (!$id) {
            return Helper::errorResponse();
        }
        $representative = Representative::getRepresentativeById($id);

        if (!isset($representative)) {
            return Helper::errorResponse();
        }
        $data = [
            'id'              => $id,
            'employee_number' => 'del-' . $id . '-' . $representative->employee_number,
            'main_email'      => 'del-' . $id . '-' . $representative->main_email
        ];
        Representative::deleteRepresentative($data);
        Message::rejectJoinByRepresentativeId($id);

        return Helper::successResponse();
    }
}
