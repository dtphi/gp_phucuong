<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CoSoGiaoPhan;

class LinhmucThuyenchuyen extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'linhmuc_thuyenchuyens';

    public function linhMuc()
    {
        return $this->belongsTo(Linhmuc::class);
    }

    public function getTenThanhAttribute($value)
    {
        $value = ($this->linhMuc) ? $this->linhMuc->ten_thanh : '';

        return $value;
    }

    public function chucVu()
    {
    return $this->hasOne(ChucVu::class, 'id', 'chuc_vu_id');
    }	

    public function getTenLinhMucAttribute($value)
    {
        $value = ($this->linhMuc) ? $this->linhMuc->ten : '';

        return $value;
    }

        /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'linh_muc_id',
        'from_giao_xu_id',
        'from_chuc_vu_id',
        'from_date',
        'duc_cha_id',
        'to_date',
        'chuc_vu_id',
        'giao_xu_id',
        'co_so_gp_id',
        'dong_id',
        'ban_chuyen_trach_id',
        'du_hoc',
        'quoc_gia',
        'ghi_chu',
        'active',
        'update_user'
    ];

    public function fromGiaoXu()
    {
        return $this->hasOne(GiaoXu::class,  $this->primaryKey, 'from_giao_xu_id');
    }

    public function fromChucVu()
    {
        return $this->hasOne(ChucVu::class,  $this->primaryKey, 'from_chuc_vu_id');
    }

    public function toChucVu()
    {
        return $this->hasOne(ChucVu::class,  $this->primaryKey, 'chuc_vu_id');
    }

    public function toGiaoXu()
    {
        return $this->hasOne(GiaoXu::class,  $this->primaryKey, 'giao_xu_id');
    }

    public function ducCha()
    {
        return $this->hasOne(Linhmuc::class,  $this->primaryKey, 'duc_cha_id');
    }

    public function coSo()
    {
        return $this->hasOne(CoSoGiaoPhan::class,  $this->primaryKey, 'co_so_gp_id');
    }

    public function dong()
    {
        return $this->hasOne(Dong::class, $this->primaryKey, 'dong_id');
    }

    public function banChuyenTrach()
    {
        return $this->hasOne(BanChuyenTrach::class, $this->primaryKey, 'ban_chuyen_trach_id');
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

    public function getTenDucChaAttribute($value)
    {
        $value = ($this->ducCha) ? $this->ducCha->ten : '';

        return $value;
    }

    public function getTenFromGiaoXuAttribute($value)
    {
        $value = ($this->fromGiaoXu) ? $this->fromGiaoXu->name : '';

        return $value;
    }

    public function getTenFromChucVuAttribute($value)
    {
        $value = ($this->fromChucVu) ? $this->fromChucVu->name : '';

        return $value;
    }

    public function getTenToChucVuAttribute($value)
    {
        $value = ($this->toChucVu) ? $this->toChucVu->name : '';

        return $value;
    }

    public function getTenToGiaoXuAttribute($value)
    {
        $value = ($this->toGiaoXu) ? $this->toGiaoXu->name : '';

        return $value;
    }

    public static function insertByLinhmucId(
        $linhmucId = null,
        $fromGiaoXuId = null,
        $fromChucVuId = null,
        $fromDate = '',
        $ducChaId = null,
        $toDate = '',
        $toChucVuId = null,
        $toGiaoXuId = null,
        $cosogpId = null,
        $dongId = null,
        $banChuyenTrachId = null,
        $duhoc = null,
        $quocGia = null,
        $active = 1,
        $ghichu = ''
    ) {
        $linhmucId = (int)$linhmucId;

        if (!empty($fromDate)) {
            $date = date_create($fromDate);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $fromDate = $dateAvailable;
        } else {
            $fromDate = now();
        }

        if (!empty($toDate)) {
            $date = date_create($toDate);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $toDate = $dateAvailable;
        } else {
            $toDate = now();
        }

        if ($linhmucId) {
            DB::insert('insert into ' . Tables::$linhmuc_thuyenchuyens . ' (linh_muc_id, from_giao_xu_id, from_chuc_vu_id, from_date, duc_cha_id, to_date, chuc_vu_id, giao_xu_id, co_so_gp_id, dong_id, ban_chuyen_trach_id, du_hoc, quoc_gia, active, ghi_chu) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [$linhmucId, $fromGiaoXuId, $fromChucVuId, $fromDate, $ducChaId, $toDate, $toChucVuId, $toGiaoXuId, $cosogpId, $dongId, $banChuyenTrachId, $duhoc, $quocGia, $active, $ghichu]);
        }
    }

    public static function fcDeleteByLinhmucId($linhmucId = null)
    {
        $linhmucId = (int)$linhmucId;

        if ($linhmucId) {
            return DB::delete("delete from " . Tables::$linhmuc_thuyenchuyens . " where linh_muc_id = '" . $linhmucId . "'");
        }
    }
}
