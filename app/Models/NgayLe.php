<?php

namespace App\Models;

use App\Http\Common\Tables;

class NgayLe extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'ngay_les';

    protected $primaryKey = 'id';

    protected $fillable = [
        'code',
        'solar_day',
        'solar_month',
        'lunar_day',
        'lunar_month',
        'ten_le',
        'loai_le',
        'bac_le',
        'hanh',
        'is_active',
        'nam_ai',
        'nam_aii',
        'nam_bi',
        'nam_bii',
        'nam_ci',
        'nam_cii',
        'update_user',
    ];

    public static function fcDeleteByNgayLeId($id = null)
    {
        $id = (int)$id;
        if ($id) {
            return DB::delete("delete from " . Tables::$ngay_les . " where id = '" . $id . "'");
        }
    }
}
