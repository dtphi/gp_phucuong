<?php

namespace App\Http\Requests;

use App\Http\Common\BaseRequest;
use Auth;
use App\Http\Common\Tables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class LinhMucChucThanhRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_ALLOW_LINH_MUC_CHUC_THANH . ':*';

    private $allowAdd = Tables::PREFIX_ALLOW_LINH_MUC_CHUC_THANH . ':add';

    private $allowEdit = Tables::PREFIX_ALLOW_LINH_MUC_CHUC_THANH . ':edit';

    private $allowDelete = Tables::PREFIX_ALLOW_LINH_MUC_CHUC_THANH . ':delete';

    private $allowList = Tables::PREFIX_ALLOW_LINH_MUC_CHUC_THANH . ':list';

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

        if ($this->isMethod('options') || $user->actionCan(Tables::$linhMucChucThanhAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$linhMucChucThanhAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$linhMucChucThanhAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$linhMucChucThanhAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$linhMucChucThanhAccessName, $this->allowList);
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

        $formData['chuc_thanh_id']                 = isset($formData['chuc_thanh_id']) ? $formData['chuc_thanh_id'] : null;
        $formData['ngay_thang_nam_chuc_thanh']        = isset($formData['ngay_thang']) ? $formData['ngay_thang'] : null;
        $formData['noi_thu_phong'] = isset($formData['noi_thu_phong']) ? $formData['noi_thu_phong'] : '';
        $formData['nguoi_thu_phong'] = isset($formData['nguoi_thu_phong']) ? $formData['nguoi_thu_phong'] : null;
        $formData['ghi_chu']    = isset($formData['ghi_chu']) ? $formData['ghi_chu'] : '';
        $formData['active']        = isset($formData['active']) ? $formData['active'] : '';
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
