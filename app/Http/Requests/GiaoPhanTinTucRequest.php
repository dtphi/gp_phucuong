<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class GiaoPhanTinTucRequest extends BaseRequest
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
    /*pc_giao_phan_tin_tucs*/
    $formData['image'] = isset($formData['image']) ? $formData['image'] : '';

    if (!empty($formData['image']) && is_array($formData['image'])) {

      $formData['image_type']  = $formData['image']['type'];
      $formData['image_size']  = $formData['image']['size'];
      $formData['image_path']  = $formData['image']['path'];
      $formData['image_thumb'] = $formData['image']['thumb'];
      if ((int)$formData['image_size'] > 1) {
        $formData['image_path']  = '/Image/NewPicture/' . $formData['image']['path'];
        $formData['image_thumb'] = $formData['image']['dirname'] . '/' . $formData['image']['filename'] . '_150x150.' . $formData['image']['extension'];
      }

      $formData['image_timestamp'] = $formData['image']['timestamp'];
      $formData['image_extension'] = $formData['image']['extension'];
      $formData['image_filename']  = $formData['image']['filename'];
      $formData['image']           = null;
    }

    $formData['date_available']   = isset($formData['date_available']) ? $formData['date_available'] : '';
    if (!empty($formData['date_available'])) {
      $formData['date_available'] = new Carbon($formData['date_available']);
    } else {
      $formData['date_available'] = now();
    }

    $formData['sort_order']       = isset($formData['sort_order']) ? $formData['sort_order'] : 0;
    $formData['status']           = isset($formData['status']) ? $formData['status'] : 0;
    $formData['create_user']      = isset($formData['create_user']) ? $formData['create_user'] : 0;
    $formData['sort_description'] = isset($formData['sort_description']) ? $formData['sort_description'] : '';
    $formData['info_type']        = isset($formData['info_type']) ? $formData['info_type'] : 1;
    /* $formData['name_slug']        = Str::slug($formData['name']); */

    /*pc_giao_phan_tin_tuc_mo_tas*/
    $formData['name']             = isset($formData['name']) ? $formData['name'] : '';
    $formData['user_create']      = isset(Auth::user()->id) ? Auth::user()->id : 0;
    $formData['meta_title']       = isset($formData['meta_title']) ? $formData['meta_title'] : '';
    $formData['description']      = isset($formData['description']) ? $formData['description'] : '';
    $formData['tag']              = isset($formData['tag']) ? $formData['tag'] : '';
    $formData['meta_description'] = isset($formData['meta_description']) ? $formData['meta_description'] : '';
    $formData['meta_keyword']     = isset($formData['meta_keyword']) ? $formData['meta_keyword'] : '';

    /*information images*/
    $formData['info_images']  = [];
    $formData['multi_images'] = isset($formData['multi_images']) ? $formData['multi_images'] : '';
    if (!empty($formData['multi_images'])) {
      foreach ($formData['multi_images'] as $key => $image) {
        $formData['info_images'][] = [
          'image'      => $image['image'],
          'sort_order' => $image['sort_order']
        ];
      }

      $formData['multi_images'] = null;
    }

    /*information relateds*/
    /* $formData['relateds'] = isset($formData['relateds']) ? $formData['relateds'] : ''; */

    /* pc_giao_phan_tuc_tuc_danh_mucs*/
    $formData['categorys'] = isset($formData['categorys']) ? $formData['categorys'] : '';

    /*information downloads*/
    /* $formData['downloads'] = isset($formData['downloads']) ? $formData['downloads'] : ''; */

    /*information carousel*/
    /* $formData['special_carousels'] = isset($formData['special_carousels']) ? $formData['special_carousels'] : ''; */

    $this->merge($formData);

    return $this->all();
  }

  /**
   * @author : dtphi .
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    if ($this->isMethod('get') || $this->isMethod('option'))
      return [];

    return [
      'name'       => 'required|max:200',
      'meta_title' => 'required|max:255'
    ];
  }
}
