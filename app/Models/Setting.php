<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class Setting extends BaseModel
{
    protected $table = DB_PREFIX . 'settings';

    /**
     * @var string
     */
    protected $primaryKey = 'setting_id';

    /**
     * @var bool
     */
    public $timestamps = false;

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

            $insertQuery = 'insert into ' . Tables::$settings . ' (code, key_data, value, serialized) values (?, ?, ?, ?)';

            return DB::insert($insertQuery, [$code, $key, $value, $serialized]);
        }
    }

    public static function forceDeleteByCode($code = '')
    {
        if ($code) {
            return DB::delete("delete from " . Tables::$settings . " where code = '" . $code . "'");
        }
    }

    public function scopeFilterCode($query, $code = '')
    {
        $query->where($this->table . '.code', $code);

        return $query;
    }

    public function scopeFilterKey($query, $key = '')
    {
        $query->where($this->table . '.key_data', $key);

        return $query;
    }
}
