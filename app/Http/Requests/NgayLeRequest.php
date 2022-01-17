<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;

class NgayLeRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_ALLOW_NGAY_LE . ':*';

    private $allowAdd = Tables::PREFIX_ALLOW_NGAY_LE . ':add';

    private $allowEdit = Tables::PREFIX_ALLOW_NGAY_LE . ':edit';

    private $allowDelete = Tables::PREFIX_ALLOW_NGAY_LE . ':delete';

    private $allowList = Tables::PREFIX_ALLOW_NGAY_LE . ':list';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        if ($this->isAllowAll())
            return true;
        if ($this->isMethod('options') || $user->actionCan(Tables::$ngayLeAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$ngayLeAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$ngayLeAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$ngayLeAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$ngayLeAccessName, $this->allowList);
        }
        return false;
    }
    public function validationData()
    {
        $formData = $this->all();
        $formData['code']             = isset($formData['code']) ? $formData['code'] : null;
        $formData['solar_day']             = isset($formData['solar_day']) ? $formData['solar_day'] : null;
        $formData['solar_month']             = isset($formData['solar_month']) ? $formData['solar_month'] : null;
        $formData['lunar_day']             = isset($formData['lunar_day']) ? $formData['lunar_day'] : null;
        $formData['lunar_month']             = isset($formData['lunar_month']) ? $formData['lunar_month'] : null;
        $formData['ten_le']           = isset($formData['ten_le']) ? $formData['ten_le'] : null;
        $formData['loai_le']           = isset($formData['loai_le']) ? $formData['loai_le'] : null;
        $formData['bac_le']           = isset($formData['bac_le']) ? $formData['bac_le'] : null;
        $formData['hanh']        = isset($formData['hanh']) ? ($formData['hanh']) : null;
        $formData['name_ai']        = isset($formData['name_ai']) ? htmlentities($formData['name_ai']) : null;
        $formData['nam_aii']          = isset($formData['nam_aii']) ? htmlentities($formData['nam_aii']) : null;
        $formData['nam_bi']              = isset($formData['nam_bi']) ? htmlentities($formData['nam_bi']) : null;
        $formData['nam_bii']       = isset($formData['nam_bii']) ? htmlentities($formData['nam_bii']) : null;
        $formData['nam_ci'] = isset($formData['nam_ci']) ? htmlentities($formData['nam_ci']) : null;
        $formData['nam_cii']     = isset($formData['nam_cii']) ? htmlentities($formData['nam_cii']) : null;
        $formData['update_user']      = isset(Auth::user()->id) ? Auth::user()->id : 0;

        $this->merge($formData);

        return $this->all();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
