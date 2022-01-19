<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinhmucBoNhiem extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'linhmuc_bonhiems';

    public function linhMuc()
    {
        return $this->belongsTo(Linhmuc::class);
    }

    public function getTenLinhMucAttribute($value)
    {
        $value = ($this->linhMuc) ? $this->linhMuc->ten : '';

        return $value;
    }

    public function chucVu()
    {
        return $this->hasOne(ChucVu::class, 'id', 'chuc_vu_id');
    }

        /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'linh_muc_id',
        'chuc_vu_id',
        'cong_viec',
        'cong_viec_tu_ngay',
        'cong_viec_tu_thang',
        'cong_viec_tu_nam',
        'cong_viec_den_ngay',
        'cong_viec_den_thang',
        'cong_viec_den_nam',
        'active'
    ];

    public function getTenChucVuAttribute($value)
    {
        $value = ($this->chucVu) ? $this->chucVu->name : '';

        return $value;
    }

    public static function insertByLinhmucId(
        $linhmucId = null,
        $chucVuId = null,
        $congViec = '',
        $congViecTuNgay = '',
        $congViecTuThang = '',
        $congViecTuNam = '',
        $congViecDenNgay = '',
        $congViecDenThang = '',
        $congViecDenNam = '',
        $active = 1
    ) {
        $linhmucId = (int)$linhmucId;
        $chucVuId = (int)$chucVuId;

        if ($linhmucId) {
            DB::insert('insert into ' . Tables::$linhmuc_bonhiems . ' (linh_muc_id, chuc_vu_id, cong_viec, cong_viec_tu_ngay, cong_viec_tu_thang, cong_viec_tu_nam, cong_viec_den_ngay, cong_viec_den_thang, cong_viec_den_nam, active) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [$linhmucId, $chucVuId, $congViec, $congViecTuNgay, $congViecTuThang, $congViecTuNam, $congViecDenNgay, $congViecDenThang, $congViecDenNam, $active]);
        }
    }

    public static function fcDeleteByLinhmucId($linhmucId = null)
    {
        $linhmucId = (int)$linhmucId;

        if ($linhmucId) {
            return DB::delete("delete from " . Tables::$linhmuc_bonhiems . " where linh_muc_id = '" . $linhmucId . "'");
        }
    }

    public static function fcDeleteById($linhmucId = null, $id = null)
    {
        $linhmucId = (int)$linhmucId;
        $id = (int)$id;

        if ($linhmucId && $id) {
            return DB::delete("delete from " . Tables::$linhmuc_bonhiems . " where linh_muc_id = $linhmucId and id = $id");
        }
    }
}
