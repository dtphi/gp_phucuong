<?php

namespace App\Http\Requests;

use App\Rules\ExistUserMail;
use App\Http\Common\BaseRequest;
use App\Rules\ExistUserPhone;
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
        if ($this->get('action') == 'permission' && $this->get('userId') && !empty($this->get('abilities'))) {
            $formData['userAbilities'] = $this->get('abilities');
            $formData['userId'] = $this->get('userId');
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
        if ($this->get('action') == 'permission')
            return [];

        if ($this->isMethod('post')) {
            return [
                'name'     => 'required|max:255',
                'phone'    => 'required|max:15|unique:admins,phone',
                'email'    => 'required|unique:admins,email|email:rfc,dns|max:255',
                'password' => 'required|min:8'
            ];
        }

        if ($this->isMethod('put')) {
            $id = $this->get('id');
            return [
                'name'     => 'required|max:255',
                'phone'    => ['required', 'max:15', new ExistUserPhone($id)],
                'email'    => ['required', 'max:255', new ExistUserMail($id)],
                'password' => 'required|min:8'
            ];
        }

        return [];
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
