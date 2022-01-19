<?php

namespace App\Http\Requests;

use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;
use Auth;

class AlbumsRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_ALLOW_ALBUMS . ':*';

    private $allowAdd = Tables::PREFIX_ALLOW_ALBUMS . ':add';

    private $allowEdit = Tables::PREFIX_ALLOW_ALBUMS . ':edit';

    private $allowDelete = Tables::PREFIX_ALLOW_ALBUMS . ':delete';

    private $allowList = Tables::PREFIX_ALLOW_ALBUMS . ':list';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        if ($this->isAllowAll())
            return true;

        if ($this->isMethod('options') || $user->actionCan(Tables::$albumsAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$albumsAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$albumsAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$albumsAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$albumsAccessName, $this->allowList);
        }
        return false;   
    }

    public function validationData() {
        $formData = $this->all();

        $formData['albums_name']     = isset($formData['albums_name']) ? $formData['albums_name'] : null;
        $formData['group_albums_id'] = isset($formData['group_albums_id']) ? $formData['group_albums_id'] : null;
        $formData['status']          = isset($formData['status']) ? $formData['status'] : null;
        $formData['sort_id']         = isset($formData['sort_id']) ? $formData['sort_id'] : null;
				$formData['image']           = isset($formData['image']) ? $formData['image'] : null;
        $formData['albums_images'] = isset($formData['albums_images']) ? $formData['albums_images'] : '';

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
            $formData['image_origin']           = null;
        }
        $formData['update_user']     = isset(Auth::user()->id) ? Auth::user()->id : 0;

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
