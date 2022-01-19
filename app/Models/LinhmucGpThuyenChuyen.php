<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinhmucGpThuyenChuyen extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'linhmuc_gp_thuyenchuyens';

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

    public function fromGiaoXu()
    {
        return $this->hasOne(GiaoXu::class,  $this->primaryKey, 'dia_diem_id');
    }

    public function coSo()
    {
        return $this->hasOne(CoSoGiaoPhan::class,  $this->primaryKey, 'dia_diem_id');
    }

    public function dong()
    {
        return $this->hasOne(Dong::class, $this->primaryKey, 'dia_diem_id');
    }

    public function banChuyenTrach()
    {
        return $this->hasOne(BanChuyenTrach::class, $this->primaryKey, 'dia_diem_id');
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
        'dia_diem_id',
        'dia_diem_loai',
        'dia_diem_tu_ngay',
        'dia_diem_tu_thang',
        'dia_diem_tu_nam',
        'dia_diem_den_ngay',
        'dia_diem_den_thang',
        'dia_diem_den_nam',
        'active'
    ];

    public function getTenChucVuAttribute($value)
    {
        $value = ($this->chucVu) ? $this->chucVu->name : '';

        return $value;
    }

    public function getTenGiaoXuAttribute($value)
    {
        $value = ($this->fromGiaoXu) ? $this->fromGiaoXu->name : '';

        return $value;
    }

    public function getTenBanChuyenTrachAttribute($value)
    {
        $value = ($this->banChuyenTrach) ? $this->banChuyenTrach->name : '';

        return $value;
    }

    public function getTenDongAttribute($value)
    {
        $value = ($this->dong) ? $this->dong->name : '';

        return $value;
    }

    public function getTenCoSoAttribute($value)
    {
        $value = ($this->coSo) ? $this->coSo->name : '';

        return $value;
    }

    public function getTenDiaDiemAttribute($value)
    {
        switch ($this->dia_diem_loai)
        {
            case 1:
                {
                    $value = 'Giáo Xứ ' . $this->ten_giao_xu;
                    break;
                }
            case 2:
                {
                    $value = 'Cơ Sở Giáo Phận ' . $this->ten_co_so;
                    break;
                }
            case 3:
                {
                    $value = 'Dòng ' . $this->ten_dong;
                    break;
                }
            case 4:
                {
                    $value = 'Ban Chuyên Trach ' . $this->ten_ban_chuyen_trach;
                    break;
                }
        }

        return $value;
    }

    public static function insertByLinhmucId(
        $linhmucId = null,
        $chucVuId = null,
        $diaDiemId = null,
        $diaDiemLoai = 0,
        $diaDiemTuNgay = '',
        $diaDiemTuThang = '',
        $diaDiemTuNam = '',
        $diaDiemDenNgay = '',
        $diaDiemDenThang = '',
        $diaDiemDenNam = '',
        $active = 1
    ) {
        $linhmucId = (int)$linhmucId;
        $chucVuId = (int)$chucVuId;
        $diaDiemId = (int)$diaDiemId;

        if ($linhmucId) {
            DB::insert('insert into ' . Tables::$linhmuc_gp_thuyenchuyens . ' (linh_muc_id, chuc_vu_id, dia_diem_id, dia_diem_loai, dia_diem_tu_ngay, dia_diem_tu_thang, dia_diem_tu_nam, dia_diem_den_ngay, dia_diem_den_thang, dia_diem_den_nam, active) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [$linhmucId, $chucVuId, $diaDiemId, $diaDiemLoai, $diaDiemTuNgay, $diaDiemTuThang, $diaDiemTuNam, $diaDiemDenNgay, $diaDiemDenThang, $diaDiemDenNam, $active]);
        }
    }

    public static function fcDeleteByLinhmucId($linhmucId = null)
    {
        $linhmucId = (int)$linhmucId;

        if ($linhmucId) {
            return DB::delete("delete from " . Tables::$linhmuc_gp_thuyenchuyens . " where linh_muc_id = '" . $linhmucId . "'");
        }
    }

    public static function fcDeleteById($linhmucId = null, $id = null)
    {
        $linhmucId = (int)$linhmucId;
        $id = (int)$id;

        if ($linhmucId && $id) {
            return DB::delete("delete from " . Tables::$linhmuc_gp_thuyenchuyens . " where linh_muc_id = $linhmucId and id = $id");
        }
    }
}
