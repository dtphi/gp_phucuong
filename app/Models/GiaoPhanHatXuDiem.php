<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GiaoDiem;

class GiaoPhanHatXuDiem extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_hat_xu_diems';

    public function giaoDiem()
    {
        return $this->hasOne(GiaoDiem::class, $this->primaryKey, 'giao_diem_id');
    }

    public function getNameAttribute($value) {
        return $this->giaoDiem->name;
    }

    public static function insertByGiaoPhanId(
        $giaoPhanId = null,
        $giaoHatId = null,
        $giaoXuId = null,
        $giaoDiemId = null,
        $active = 1
    ) {
        $gpId = (int)$giaoPhanId;
        $hatId = (int)$giaoHatId;
        $xuId = (int)$giaoXuId;
        $diemId = (int)$giaoDiemId;
        $active = (int)$active;

        if ($gpId && $hatId) {
            DB::insert('insert into ' . Tables::$giaophan_hat_xu_diems . ' (giao_phan_id, giao_hat_id, giao_xu_id, giao_diem_id, active) values (?, ?, ?, ?, ?)',
                [$gpId, $hatId, $xuId, $diemId, $active]);
        }
    }

    public static function fcDeleteByGiaoPhanId($giaoPhanId = null)
    {
        $giaoPhanId = (int)$giaoPhanId;

        if ($giaoPhanId) {
            return DB::delete("delete from " . Tables::$giaophan_hat_xu_diems . " where giao_phan_id = '" . $giaoPhanId . "'");
        }
    }
}
