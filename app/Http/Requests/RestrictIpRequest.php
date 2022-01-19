<?php

namespace App\Http\Requests;

use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;
use Illuminate\Support\Facades\Auth;

class RestrictIpRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_ALLOW_RESTRICT_IP . ':*';

    private $allowAdd = Tables::PREFIX_ALLOW_RESTRICT_IP . ':add';

    private $allowEdit = Tables::PREFIX_ALLOW_RESTRICT_IP . ':edit';

    private $allowDelete = Tables::PREFIX_ALLOW_RESTRICT_IP . ':delete';

    private $allowList = Tables::PREFIX_ALLOW_RESTRICT_IP . ':list';
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

        if ($this->isMethod('options') || $user->actionCan(Tables::$restrictIpAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$restrictIpAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$restrictIpAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$restrictIpAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$restrictIpAccessName, $this->allowList);
        }
        
        return false; 
    }

    public function validationData()
    {
        $formData = $this->all();

        $formData['ip'] = isset($formData['ip']) ? $formData['ip'] : null;
        $formData['active'] = isset($formData['active']) ? $formData['active'] : null;
        $formData['update_user'] = isset(Auth::user()->id) ? Auth::user()->id : 0;

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
