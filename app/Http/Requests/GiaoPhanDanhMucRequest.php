<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;
use Illuminate\Support\Str;

class GiaoPhanDanhMucRequest extends BaseRequest
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
  public function validationData()
  {
    $formData = $this->all();

    $formData['name'] = isset($formData['name']) ? $formData['name'] : '';
    if (empty($formData['name'])) {
      $formData['name'] = isset($formData['category_name']) ? $formData['category_name'] : '';
    }
    $formData['name_slug']        = Str::slug($formData['name']);
    $formData['user_create']      = isset(Auth::user()->id) ? Auth::user()->id : 0;
    $formData['tag']              = isset($formData['tag']) ? $formData['tag'] : '';
    $formData['top']              = isset($formData['top']) ? $formData['top'] : '';
    $formData['parent_id']        = isset($formData['parent_id']) ? $formData['parent_id'] : null;
    $formData['description']      = isset($formData['description']) ? htmlentities($formData['description']) : '';
    $formData['meta_title']       = isset($formData['meta_title']) ? $formData['meta_title'] : '';
    $formData['meta_description'] = isset($formData['meta_description']) ? $formData['meta_description'] : '';
    $formData['meta_keyword']     = isset($formData['meta_keyword']) ? $formData['meta_keyword'] : '';
    $formData['sort_order']       = isset($formData['sort_order']) ? $formData['sort_order'] : 0;
    $formData['status']           = isset($formData['status']) ? $formData['status'] : 0;
    $formData['layout_id']        = isset($formData['layout_id']) ? $formData['layout_id'] : null;
    $formData['path']             = isset($formData['path']) ? $formData['path'] : null;

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
    if ($this->isMethod('get') || $this->isMethod('option'))
      return [];

    if ($this->isMethod('put')) {
      return [
        'name'       => 'required|min:3|max:255',
        'meta_title' => 'required|min:3|max:255'
      ];
    }

    return [
      'name'       => 'required|min:3|max:255',
      'meta_title' => 'required|min:3|max:255'
    ];
  }
}
