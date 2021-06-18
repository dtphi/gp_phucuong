<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoPhanCoSo extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_cosos';

    public static function insertByGiaoPhanId(
        $giaoPhanId = null,
        $cosoId = null,
        $active = 1
    ) {
        $gpId = (int)$giaoPhanId;
        $cosoId = (int)$cosoId;
        $active = (int)$active;

        if ($gpId && $cosoId) {
            DB::insert('insert into ' . Tables::$giaophan_cosos . ' (giao_phan_id, co_so_giao_phan_id, active) values (?, ?, ?)',
                [$gpId, $cosoId, $active]);
        }
    }
}
