<?php
/**
 * The Base request class.
 */
namespace App\Http\Common;

use App\Exceptions\AccessDeniedCommon;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Log;

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
        return fn_is_prod_env() ? Auth::user()->actionCan(Tables::PREFIX_ACCESS_NAME . $this->listPermission, '*'): true;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function isIgnoreProdAuthorize()
    {
        fn_is_prod_env() ? ((boolean)config('app.ignore_prod_authorize') ? false: true): true;
    }

    /**
     * @throws AccessDeniedCommon
     */
    protected function failedAuthorization()
    {
        http_response_code(500);
        exit;
    }
}
