<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CongDoanTuSi;

class GiaoPhanHatCongDoanTuSi extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_hat_congdoantusis';

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'giao_phan_hat_id',
        'giao_phan_id',
        'giao_hat_id',
        'cong_doan_tu_si_id',
        'active'
    ];


    public function congDoanTuSi()
    {
        return $this->hasOne(CongDoanTuSi::class, $this->primaryKey, 'cong_doan_tu_si_id');
    }

    public function getNameAttribute($value) {
        return $this->congDoanTuSi->name;
    }

    public static function insertByGiaoHatId(
        $giaoPhanId = null,
        $giaoPhanHatId = null,
        $giaoHatId = null,
        $congDtsId = null,
        $active = 1
    ) {
        $gpId = (int)$giaoPhanId;
        $gpHatId = (int)$giaoPhanHatId;
        $hatId = (int)$giaoHatId;
        $congDtsId = (int)$congDtsId;
        $active = (int)$active;

        if ($gpId && $hatId && $congDtsId) {
            DB::insert('insert into ' . Tables::$giaophan_hat_congdoantusis . ' (giao_phan_id, giao_phan_hat_id, giao_hat_id, cong_doan_tu_si_id, active) values (?, ?, ?, ?, ?)',
                [$gpId, $gpHatId, $hatId, $congDtsId, $active]);
        }
    }

    public static function fcDeleteByGiaoPhanId($giaoPhanId = null)
    {
        $giaoPhanId = (int)$giaoPhanId;

        if ($giaoPhanId) {
            return DB::delete("delete from " . Tables::$giaophan_hat_congdoantusis . " where giao_phan_id = '" . $giaoPhanId . "'");
        }
    }

    public static function fcDeleteById($id = null)
    {
        $id = (int)$id;

        if ($id) {
            return DB::delete("delete from " . Tables::$giaophan_hat_congdoantusis . " where id = '" . $id . "'");
        }
    }
}
