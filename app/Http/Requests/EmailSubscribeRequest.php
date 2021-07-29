<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailSubscribeRequest extends FormRequest
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
    $formData['email'] = isset($formData['email']) ? $formData['email'] : '';
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
    if ($this->isMethod('put')) {
      return [
        'email' => 'required|email|max:255|unique:pc_subscribes',
      ];
    }
    return [
      'email' => 'required|email|max:255|unique:pc_subscribes',
    ];
  }
}
