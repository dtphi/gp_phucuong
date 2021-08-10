<?php

namespace App\Http\Requests;

use App\Http\Common\BaseRequest;
use Auth;
use App\Http\Common\Tables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class LinhMucVanThuRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_ALLOW_LINH_MUC_VAN_THU . ':*';

    private $allowAdd = Tables::PREFIX_ALLOW_LINH_MUC_VAN_THU . ':add';

    private $allowEdit = Tables::PREFIX_ALLOW_LINH_MUC_VAN_THU . ':edit';

    private $allowDelete = Tables::PREFIX_ALLOW_LINH_MUC_VAN_THU . ':delete';

    private $allowList = Tables::PREFIX_ALLOW_LINH_MUC_VAN_THU . ':list';

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

        if ($this->isMethod('options') || $user->actionCan(Tables::$linhMucVanThuAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$linhMucVanThuAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$linhMucVanThuAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$linhMucVanThuAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$linhMucVanThuAccessName, $this->allowList);
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

        $formData['title']                 = isset($formData['name']) ? $formData['name'] : null;
        $formData['ghi_chu']        = isset($formData['ghi_chu']) ? $formData['ghi_chu'] : '';
        $formData['active']     = isset($formData['active']) ? (int)$formData['active'] : 0;
        $formData['type']           = isset($formData['type']) ? $formData['type'] : 1;
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
        return [];
    }
}
