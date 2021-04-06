<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistUserMail;

class AdminRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return [
                'name' => 'required|max:255',
                'email' => 'required|unique:admins,email|email:rfc,dns|max:255',
                'password' => 'required|min:8'
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'name' => 'required|max:255',
                'email' => ['required', 'max:255', new ExistUserMail($this->get('id'))],
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
