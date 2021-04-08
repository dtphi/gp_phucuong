<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $data = $this->all();

        if ($this->isMethod('put')) {
            $mergeData = [
                'name' => isset($data['category_name'])?$data['category_name']:''
            ];
            $this->merge($mergeData);
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   

        if ($this->isMethod('put')) {
            return [
                'name' => 'required|min:3|max:255',
                'meta_title' => 'required|min:3|max:255'
            ];
        }

         return [
            'name' => 'required|min:3|max:255',
            'meta_title' => 'required|min:3|max:255'
        ];
    }
}
