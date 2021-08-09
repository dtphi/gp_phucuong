<?php

namespace App\Http\Requests;

use App\Http\Common\BaseRequest;
use Auth;
use App\Http\Common\Tables;

class LinhMucBangCapRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_ALLOW_LINH_MUC_BANG_CAP . ':*';

    private $allowAdd = Tables::PREFIX_ALLOW_LINH_MUC_BANG_CAP . ':add';

    private $allowEdit = Tables::PREFIX_ALLOW_LINH_MUC_BANG_CAP . ':edit';

    private $allowDelete = Tables::PREFIX_ALLOW_LINH_MUC_BANG_CAP . ':delete';

    private $allowList = Tables::PREFIX_ALLOW_LINH_MUC_BANG_CAP . ':list';

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

        if ($this->isMethod('options') || $user->actionCan(Tables::$linhMucBangCapAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$linhMucBangCapAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$linhMucBangCapAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$linhMucBangCapAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$linhMucBangCapAccessName, $this->allowList);
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

        $formData['name']           = isset($formData['name']) ? $formData['name'] : '';
        $formData['ghi_chu']          = isset($formData['ghi_chu']) ? $formData['ghi_chu'] : '';
        $formData['active']          = isset($formData['active']) ? $formData['active'] : '';
        $formData['type']   = isset($formData['type']) ? $formData['type'] : '';

        $formData['update_user']    = isset(Auth::user()->id) ? Auth::user()->id : 0;

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
        if(empty($this->get('action'))) {
            return [
                'name' => 'max:255'
            ];
        }

        return [];
    }
}
