<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CoSoGiaoPhanRequest extends FormRequest
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

        $formData['name']             = isset($formData['name']) ? $formData['name'] : null;
        $formData['dia_chi']             = isset($formData['dia_chi']) ? $formData['dia_chi'] : null;
        $formData['dien_thoai']             = isset($formData['dien_thoai']) ? $formData['dien_thoai'] : null;
        $formData['email']             = isset($formData['email']) ? $formData['email'] : null;
        $formData['fax']             = isset($formData['fax']) ? $formData['fax'] : null;
        $formData['website']           = isset($formData['website']) ? $formData['website'] : null;
        $formData['active']           = isset($formData['active']) ? $formData['active'] : null;
        $formData['sort_id']          = isset($formData['sort_id']) ? $formData['sort_id'] : null;
        $formData['tag']              = isset($formData['tag']) ? $formData['tag'] : null;
        $formData['meta_title']       = isset($formData['meta_title']) ? $formData['meta_title'] : null;
        $formData['meta_description'] = isset($formData['meta_description']) ? $formData['meta_description'] : null;
        $formData['meta_keyword']     = isset($formData['meta_keyword']) ? $formData['meta_keyword'] : null;
        $formData['update_user']      = isset(Auth::user()->id) ? Auth::user()->id : 0;

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
