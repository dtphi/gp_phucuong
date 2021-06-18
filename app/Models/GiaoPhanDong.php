<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoPhanDong extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_dongs';

    public static function insertByGiaoPhanId(
        $giaoPhanId = null,
        $dongId = null,
        $active = 1
    ) {
        $gpId = (int)$giaoPhanId;
        $dongId = (int)$dongId;
        $active = (int)$active;

        if ($gpId && $dongId) {
            DB::insert('insert into ' . Tables::$giaophan_dongs . ' (giao_phan_id, dong_id, active) values (?, ?, ?)',
                [$gpId, $dongId, $active]);
        }
    }
}
