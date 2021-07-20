<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CoSoGiaoPhan;

class GiaoPhanCoSo extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_cosos';

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'giao_phan_id',
        'co_so_giao_phan_id',
        'active'
    ];

    public function coso()
    {
        return $this->hasOne(CoSoGiaoPhan::class, $this->primaryKey, 'co_so_giao_phan_id');
    }

    public function getNameAttribute($value) {
        return $this->coso->name;
    }


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

    public static function fcDeleteByGiaoPhanId($giaoPhanId = null)
    {
        $giaoPhanId = (int)$giaoPhanId;

        if ($giaoPhanId) {
            return DB::delete("delete from " . Tables::$giaophan_cosos . " where giao_phan_id = '" . $giaoPhanId . "'");
        }
    }

    public static function fcDeleteById($id = null)
    {
        $id = (int)$id;

        if ($id) {
            return DB::delete("delete from " . Tables::$giaophan_cosos . " where id = '" . $id . "'");
        }
    }
}
