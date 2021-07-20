<?php

namespace App\Http\Requests;

use App\Rules\ExistUserMail;
use App\Http\Common\BaseRequest;
use Auth;

class AdminRequest extends BaseRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isAllowAll();
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

        $formData['userAbilities'] = [];
        if ($this->get('action') == 'permission' && !empty($this->get('abilities'))) {
            $formData['userAbilities'] = $this->get('abilities');
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
        if ($this->isMethod('post')) {
            return [
                'name'     => 'required|max:255',
                'email'    => 'required|unique:admins,email|email:rfc,dns|max:255',
                'password' => 'required|min:8'
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'name'     => 'required|max:255',
                'email'    => ['required', 'max:255', new ExistUserMail($this->get('id'))],
                'password' => 'required|min:8'
            ];
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'email address',
        ];
    }
}
