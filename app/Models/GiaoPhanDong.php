<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Dong;

class GiaoPhanDong extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_dongs';

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'giao_phan_id',
        'dong_id',
        'active'
    ];

    public function dong()
    {
        return $this->hasOne(Dong::class, $this->primaryKey, 'dong_id');
    }

    public function getNameAttribute($value) {
        return $this->dong->name;
    }

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

    public static function fcDeleteByGiaoPhanId($giaoPhanId = null)
    {
        $giaoPhanId = (int)$giaoPhanId;

        if ($giaoPhanId) {
            return DB::delete("delete from " . Tables::$giaophan_dongs . " where giao_phan_id = '" . $giaoPhanId . "'");
        }
    }

    public static function fcDeleteById($id = null)
    {
        $id = (int)$id;

        if ($id) {
            return DB::delete("delete from " . Tables::$giaophan_dongs . " where id = '" . $id . "'");
        }
    }
}
