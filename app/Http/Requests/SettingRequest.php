<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
        $formData['code'] = isset($formData['code']) ? $formData['code'] : '';
        $formData['keys'] = isset($formData['keys']) ? $formData['keys'] : [];

        if (!empty($formData['keys']) && is_array($formData['keys'])) {
            foreach($formData['keys'] as $setting) {
                $serialized = ($setting['serialize']) ? 1: 0;
                $value = ($serialized) ? serialize($setting['value']): $setting['value'];

                $formData['settings'][] = [
                    'key' => $setting['key'],
                    'serialized' => $serialized,
                    'value' => $value 
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
        return [
            'code'       => 'required|min:5|max:128',
            'settings' => 'required'
        ];
    }
}
