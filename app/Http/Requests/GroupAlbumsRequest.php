<?php

namespace App\Http\Requests;

use App\Http\Common\BaseRequest;
use Auth;
use App\Http\Common\Tables;

class GroupAlbumsRequest extends BaseRequest
{
    private $allow = Tables::PREFIX_ALLOW_GROUP_ALBUMS . ':*';

    private $allowAdd = Tables::PREFIX_ALLOW_GROUP_ALBUMS . ':add';

    private $allowEdit = Tables::PREFIX_ALLOW_GROUP_ALBUMS . ':edit';

    private $allowDelete = Tables::PREFIX_ALLOW_GROUP_ALBUMS . ':delete';

    private $allowList = Tables::PREFIX_ALLOW_GROUP_ALBUMS . ':list';

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
        if ($this->isMethod('options') || $user->actionCan(Tables::$groupAlbumsAccessName, $this->allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan(Tables::$groupAlbumsAccessName, $this->allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan(Tables::$groupAlbumsAccessName, $this->allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan(Tables::$groupAlbumsAccessName, $this->allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan(Tables::$groupAlbumsAccessName, $this->allowList);
        }
        
        return false;
    }

    public function validationData()
    {
        $formData = $this->all();

        $formData['group_name']  = isset($formData['group_name']) ? $formData['group_name'] : null;
        $formData['status']      = isset($formData['status']) ? $formData['status'] : null;
        $formData['sort_id']     = isset($formData['sort_id']) ? $formData['sort_id'] : null;
        $formData['update_user'] = isset(Auth::user()->id) ? Auth::user()->id : 0;

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
