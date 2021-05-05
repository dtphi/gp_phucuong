<?php

namespace App\Models;

class Setting extends BaseModel
{
    public static function forceInsert(
        $code = '',
        $key = '',
        $value = null,
        $serialized = 1
    ) {
        $serialized = (int)$serialized;

        if ($code && $key) {
            DB::insert('insert into ' . Tables::$settings . ' (code, key, value, serialized) values (?, ?, ?, ?)',
                [$code, $key, $value, $serialized]);
        }
    }

    public static function forceDeleteByCode($code = '')
    {
        if ($code) {
            return DB::delete("delete from " . Tables::$settings . " where code = '" . $code . "'");
        }
    }
}
