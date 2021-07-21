<?php

namespace App\Http\Common;

use App\Exceptions\AccessDeniedCommon;
use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Http\Common\Tables;

class BaseRequest extends FormRequest
{
    private $listPermission = 'all';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function isAllowAll()
    {   
        return Auth::user()->actionCan(Tables::PREFIX_ACCESS_NAME.$this->listPermission, '*');
    }

    protected function failedAuthorization()
    {
        throw new AccessDeniedCommon();
    }
}
