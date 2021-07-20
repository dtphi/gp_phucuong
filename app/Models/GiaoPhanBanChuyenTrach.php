<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BanChuyenTrach;

class GiaoPhanBanChuyenTrach extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophan_banchuyentrachs';

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'giao_phan_id',
        'ban_chuyen_trach_id',
        'active'
    ];

    public function banChuyenTrach()
    {
        return $this->hasOne(BanChuyenTrach::class, $this->primaryKey, 'ban_chuyen_trach_id');
    }

    public function getNameAttribute($value) {
        return $this->banChuyenTrach->name;
    }

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

    public static function fcDeleteByGiaoPhanId($giaoPhanId = null)
    {
        $giaoPhanId = (int)$giaoPhanId;

        if ($giaoPhanId) {
            return DB::delete("delete from " . Tables::$giaophan_banchuyentrachs . " where giao_phan_id = '" . $giaoPhanId . "'");
        }
    }

    public static function fcDeleteById($id = null)
    {
        $id = (int)$id;

        if ($id) {
            return DB::delete("delete from " . Tables::$giaophan_banchuyentrachs . " where id = '" . $id . "'");
        }
    }
}
