<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoPhanHat extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_hats';

    public static function insertByGiaoPhanId(
        $giaoPhanId = null,
        $giaoHatId = null,
        $active = 1
    ) {
        $gpId = (int)$giaoPhanId;
        $hatId = (int)$giaoHatId;
        $active = (int)$active;

        if ($gpId && $hatId) {
            DB::insert('insert into ' . Tables::$giaophan_hats . ' (giao_phan_id, giao_hat_id, active) values (?, ?, ?)',
                [$gpId, $hatId, $active]);
        }
    }
}
