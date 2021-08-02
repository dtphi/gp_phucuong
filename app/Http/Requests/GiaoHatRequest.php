<?php

namespace App\Http\Requests;

use App\Http\Common\BaseRequest;
use Auth;
use App\Http\Common\Tables;

class GiaoHatRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_ALLOW_GIAO_HAT . ':*';

    private $allowAdd = Tables::PREFIX_ALLOW_GIAO_HAT . ':add';

    private $allowEdit = Tables::PREFIX_ALLOW_GIAO_HAT . ':edit';

    private $allowDelete = Tables::PREFIX_ALLOW_GIAO_HAT . ':delete';

    private $allowList = Tables::PREFIX_ALLOW_GIAO_HAT . ':list';

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

        if ($this->isMethod('options') || $user->actionCan(Tables::$giaoHatAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$giaoHatAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$giaoHatAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$giaoHatAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$giaoHatAccessName, $this->allowList);
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
        $formData['khu_vuc']        = isset($formData['khu_vuc']) ? htmlentities($formData['khu_vuc']) : null;
        $formData['nguoi_quan_hat']             = isset($formData['nguoi_quan_hat']) ? $formData['nguoi_quan_hat'] : null;
        $formData['phan_loai']             = isset($formData['phan_loai']) ? $formData['phan_loai'] : null;
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
