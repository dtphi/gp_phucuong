<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiaoPhanRequest extends FormRequest
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

        $formData['name'] = isset($formData['name']) ? $formData['name']: null;
        $formData['khaiquat'] = isset($formData['khaiquat'])?$formData['khaiquat']: null;
        $formData['active'] = isset($formData['active'])?$formData['active']: null;
        $formData['sort_id'] = isset($formData['sort_id'])?$formData['sort_id']:null;
        $formData['tag'] = isset($formData['tag'])?$formData['tag']:null;
        $formData['meta_title'] = isset($formData['meta_title'])?$formData['meta_title']:null;
        $formData['meta_description'] = isset($formData['meta_description'])?$formData['meta_description']:null;
        $formData['meta_keyword'] = isset($formData['meta_keyword'])?$formData['meta_keyword']:null;

        $formData['banchuyentrachs'] = isset($formData['giao_phan_banchuyentrachs'])?$formData['giao_phan_banchuyentrachs']:[];
        $formData['cosos'] = isset($formData['giao_phan_cosos'])?$formData['giao_phan_cosos']:[];
        $formData['dongs'] = isset($formData['giao_phan_dongs'])?$formData['giao_phan_dongs']:[];
        $formData['hats'] = isset($formData['giao_phan_hats'])?$formData['giao_phan_hats']:[];

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
