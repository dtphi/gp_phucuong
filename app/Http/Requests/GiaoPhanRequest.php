<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;

class GiaoPhanRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_ALLOW_GIAO_PHAN . ':*';

    private $allowAdd = Tables::PREFIX_ALLOW_GIAO_PHAN . ':add';

    private $allowEdit = Tables::PREFIX_ALLOW_GIAO_PHAN . ':edit';

    private $allowDelete = Tables::PREFIX_ALLOW_GIAO_PHAN . ':delete';

    private $allowList = Tables::PREFIX_ALLOW_GIAO_PHAN . ':list';

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

        if ($this->isMethod('options') || $user->actionCan(Tables::$giaoPhanAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$giaoPhanAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$giaoPhanAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$giaoPhanAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$giaoPhanAccessName, $this->allowList);
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
        $formData['khai_quat']        = isset($formData['khai_quat']) ? htmlentities($formData['khai_quat']) : null;
        $formData['active']           = isset($formData['active']) ? $formData['active'] : null;
        $formData['sort_id']          = isset($formData['sort_id']) ? $formData['sort_id'] : null;
        $formData['tag']              = isset($formData['tag']) ? $formData['tag'] : null;
        $formData['meta_title']       = isset($formData['meta_title']) ? $formData['meta_title'] : null;
        $formData['meta_description'] = isset($formData['meta_description']) ? $formData['meta_description'] : null;
        $formData['meta_keyword']     = isset($formData['meta_keyword']) ? $formData['meta_keyword'] : null;
        $formData['update_user']      = isset(Auth::user()->id) ? Auth::user()->id : 0;

        $formData['banchuyentrachs'] = isset($formData['giao_phan_banchuyentrachs']) ? $formData['giao_phan_banchuyentrachs'] : [];
        $formData['cosos']           = isset($formData['giao_phan_cosos']) ? $formData['giao_phan_cosos'] : [];
        $formData['dongs']           = isset($formData['giao_phan_dongs']) ? $formData['giao_phan_dongs'] : [];
        $formData['hats']            = isset($formData['giao_phan_hats']) ? $formData['giao_phan_hats'] : [];

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
