<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoPhanHatCongDoanTuSi extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_hat_congdoantusis';

    public static function insertByGiaoHatId(
        $giaoPhanId = null,
        $giaoHatId = null,
        $congDtsId = null,
        $active = 1
    ) {
        $gpId = (int)$giaoPhanId;
        $hatId = (int)$giaoHatId;
        $congDtsId = (int)$congDtsId;
        $active = (int)$active;

        if ($gpId && $hatId && $congDtsId) {
            DB::insert('insert into ' . Tables::$giaophan_hat_congdoantusis . ' (giao_phan_id, giao_hat_id, cong_doan_tu_si_id, active) values (?, ?, ?, ?)',
                [$gpId, $hatId, $congDtsId, $active]);
        }
    }
}
