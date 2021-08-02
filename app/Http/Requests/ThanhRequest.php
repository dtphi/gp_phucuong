<?php

namespace App\Http\Requests;

use App\Http\Common\BaseRequest;
use Auth;
use App\Http\Common\Tables;

class ThanhRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_ALLOW_THANH . ':*';

    private $allowAdd = Tables::PREFIX_ALLOW_THANH . ':add';

    private $allowEdit = Tables::PREFIX_ALLOW_THANH . ':edit';

    private $allowDelete = Tables::PREFIX_ALLOW_THANH . ':delete';

    private $allowList = Tables::PREFIX_ALLOW_THANH . ':list';

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

        if ($this->isMethod('options') || $user->actionCan(Tables::$thanhAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$thanhAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$thanhAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$thanhAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$thanhAccessName, $this->allowList);
        }
        
        return false;
    }

    /**
     * @author : dtphi .
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        $formData = $this->all();

        $formData['name']             = isset($formData['name']) ? $formData['name'] : null;
        $formData['latin']        = isset($formData['latin']) ? htmlentities($formData['latin']) : null;
        $formData['ghi_chu']        = isset($formData['ghi_chu']) ? htmlentities($formData['ghi_chu']) : null;
        $formData['bon_mang']           = isset($formData['bon_mang']) ? $formData['bon_mang'] : null;
        $formData['bon_mang_ngay']           = isset($formData['bon_mang_ngay']) ? $formData['bon_mang_ngay'] : null;
        $formData['bon_mang_thang']           = isset($formData['bon_mang_thang']) ? $formData['bon_mang_thang'] : null;
        $formData['cuoc_doi']        = isset($formData['cuoc_doi']) ? htmlentities($formData['cuoc_doi']) : null;
        $formData['active']           = isset($formData['active']) ? $formData['active'] : null;
        $formData['sort_id']          = isset($formData['sort_id']) ? $formData['sort_id'] : null;
        $formData['tag']              = isset($formData['tag']) ? $formData['tag'] : null;
        $formData['meta_title']       = isset($formData['meta_title']) ? $formData['meta_title'] : null;
        $formData['meta_description'] = isset($formData['meta_description']) ? $formData['meta_description'] : null;
        $formData['meta_keyword']     = isset($formData['meta_keyword']) ? $formData['meta_keyword'] : null;
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
