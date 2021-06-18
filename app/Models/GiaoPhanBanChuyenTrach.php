<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoPhanBanChuyenTrach extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_banchuyentrachs';

    public static function insertByGiaoPhanId(
        $giaoPhanId = null,
        $banChuyenTrachId = null,
        $active = 1
    ) {
        $gpId = (int)$giaoPhanId;
        $banChuyenTrachId = (int)$banChuyenTrachId;
        $active = (int)$active;

        if ($gpId && $banChuyenTrachId) {
            DB::insert('insert into ' . Tables::$giaophan_banchuyentrachs . ' (giao_phan_id, ban_chuyen_trach_id, active) values (?, ?, ?)',
                [$gpId, $banChuyenTrachId, $active]);
        }
    }
}
