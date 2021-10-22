<?php
/**
 * The Base request class.
 */
namespace App\Http\Common;

use App\Exceptions\AccessDeniedCommon;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * @var string
     */
    private $listPermission = 'all';

    /**
     * @return mixed
     *
     * Determine if the user is authorized to make this request.
     */
    public function isAllowAll()
    {
        return Auth::user()->actionCan(Tables::PREFIX_ACCESS_NAME . $this->listPermission, '*');
    }

    /**
     * @throws AccessDeniedCommon
     */
    protected function failedAuthorization()
    {
        throw new AccessDeniedCommon();
    }
}
