<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GiaoHat;
use App\Models\GiaoPhanHatXu;
use App\Models\GiaoPhanHatCongDoanTuSi;

class GiaoPhanHat extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_hats';

    public function giaoHat()
    {
        return $this->hasOne(GiaoHat::class, $this->primaryKey, 'giao_hat_id');
    }

    public function giaoXus()
    {
        return $this->hasMany(GiaoPhanHatXu::class, 'giao_hat_id', 'giao_hat_id');
    }

    public function congDoanTuSis()
    {
        return $this->hasMany(GiaoPhanHatCongDoanTuSi::class, 'giao_hat_id', 'giao_hat_id');
    }

    public function getNameAttribute($value) {
        return $this->giaoHat->name;
    }

    public function getArrGiaoXuListAttribute($value)
    {
        $value = [];
        if ($this->giaoXus) {
            foreach ($this->giaoXus as $giaoXu) {
                if ((int)$giaoXu->giao_phan_id === (int)$this->giao_phan_id) {
                    $value[] = [
                        'active'=> $giaoXu->active,
                        'giao_xu_diems'=> [],
                        'giao_hat_id'=> $giaoXu->giao_hat_id,
                        'giao_xu_id' => $giaoXu->giao_xu_id,
                        'hatId' => $this->id,
                        'hatXuName' => $giaoXu->name,
                        'id'=> $giaoXu->id
                    ];
                }
            }
        }

        return $value;
    }

    public function getArrCongDoanTuSiListAttribute($value)
    {
        $value = [];
        if ($this->congDoanTuSis) {
            foreach ($this->congDoanTuSis as $congDoanTuSi) {
                if ((int)$congDoanTuSi->giao_phan_id === (int)$this->giao_phan_id) {
                    $value[] = [
                        'active'=> $congDoanTuSi->active,
                        'giao_hat_id'=> $congDoanTuSi->giao_hat_id,
                        'cong_doan_tu_si_id' => $congDoanTuSi->cong_doan_tu_si_id,
                        'hatId' => $this->id,
                        'hatCongDtsName' => $congDoanTuSi->name,
                        'id'=> $congDoanTuSi->id
                    ];
                }
            }
        }

        return $value;
    }

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

    public static function fcDeleteByGiaoPhanId($giaoPhanId = null)
    {
        $giaoPhanId = (int)$giaoPhanId;

        if ($giaoPhanId) {
            return DB::delete("delete from " . Tables::$giaophan_hats . " where giao_phan_id = '" . $giaoPhanId . "'");
        }
    }
}
