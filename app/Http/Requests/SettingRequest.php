<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;

class SettingRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_SETTING . ':*';

    private $allowAdd = Tables::PREFIX_SETTING . ':add';

    private $allowEdit = Tables::PREFIX_SETTING . ':edit';

    private $allowDelete = Tables::PREFIX_SETTING . ':delete';

    private $allowList = Tables::PREFIX_SETTING . ':list';

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

        if ($this->isMethod('option') || $user->actionCan(Tables::$settingAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$settingAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$settingAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$settingAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$settingAccessName, $this->allowList);
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

        $formData['settings'] = [];
        $formData['code']     = isset($formData['code']) ? $formData['code'] : '';
        $formData['keys']     = isset($formData['keys']) ? $formData['keys'] : [];

        if (!empty($formData['keys']) && is_array($formData['keys'])) {
            foreach ($formData['keys'] as $setting) {
                $serialized = ($setting['serialize']) ? 1 : 0;
                $value      = ($serialized) ? serialize($setting['value']) : $setting['value'];

                $formData['settings'][] = [
                    'key'        => $setting['key'],
                    'serialized' => $serialized,
                    'value'      => $value
                ];
            }
        }

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
        if ($this->isMethod('get')) {
            return [];
        }

        return [
            'code'     => 'required|min:5|max:128',
            'settings' => 'required'
        ];
    }
}
