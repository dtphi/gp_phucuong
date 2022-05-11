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
        'id',
        'ten_le',
        'hanh',
    ];

    // public static function fcDeleteByNgayLeId($id = null)
    // {
    //     $id = (int)$id;
    //     if ($id) {
    //         return DB::delete("delete from " . Tables::$ngay_les . " where id = '" . $id . "'");
    //     }
    // }
}
