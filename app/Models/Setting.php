<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class Setting extends BaseModel
{
    protected $table =  DB_PREFIX . 'settings';

    /**
     * @var string
     */
    protected $primaryKey = 'setting_id';

        /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'key_data',
        'value',
        'serialized'
    ];

    public static function forceInsert(
        $code = '',
        $key = '',
        $value = null,
        $serialized = 1
    ) {
        $serialized = (int)$serialized;

        if (!empty($code) && !empty($key)) {
            return $this->fill([
                'code' => $code, 
                'key' => $key, 
                'value' => $value, 
                'serialized' => $serialized
            ])->save();
           // $insertQuery = 'insert into ' . Tables::$settings . ' (setting_id, code, key, value, serialized) values (?, ?, ?, ?, ?)';
            //return dd(DB::insert(0, $insertQuery, [$code, $key, $value, $serialized]));
        }
    }

    public static function forceDeleteByCode($code = '')
    {
        if ($code) {
            return DB::delete("delete from " . Tables::$settings . " where code = '" . $code . "'");
        }
    }
}
