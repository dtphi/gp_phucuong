<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use App\Http\Common\Tables;
use DB;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $table = DB_PREFIX . 'personal_access_tokens';

    public function can($ability)
    {
        return in_array('*', $this->abilities) ||
               array_key_exists($ability, array_flip($this->abilities));
    }

    public static function fcDeleteByTokenableId($tokenableId = null)
    {
        $tokenableId = (int)$tokenableId;

        if ($tokenableId) {
            return DB::delete("delete from " . Tables::$personal_access_tokens . " where tokenable_id = '" . $tokenableId . "'");
        }
    }
}
