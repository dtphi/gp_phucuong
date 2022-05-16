<?php

namespace App\Models;

use DB;
use App\Models\GiaoXu;
use App\Http\Common\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LinhmucTemp extends BaseModel
{

  /**
   * @var string
   */
  protected $table = DB_PREFIX . 'linhmucs_temp';

  /**
   * @author : dtphi .
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'ten',
    'ten_thanh_id',
    'ngay_thang_nam_sinh',
    'noi_sinh',
    'giao_xu_id',
    'ho_ten_cha',
    'ho_ten_me',
    'noi_rua_toi',
    'ngay_rua_toi',
    'noi_them_suc',
    'ngay_them_suc',
    'tieu_chung_vien',
    'ngay_tieu_chung_vien',
    'dai_chung_vien',
    'ngay_dai_chung_vien',
    'image',
    'so_cmnd',
    'noi_cap_cmnd',
    'ngay_cap_cmnd',
    'trieu_dong',
    'ten_dong_id',
    'ngay_trieu_dong',
    'ngay_khan',
    'ngay_rip',
    'rip_giao_xu_id',
    'rip_ghi_chu',
    'cham_ngon',
    'ghi_chu',
    'update_user',
    'is_duc_cha',
    'code',
    'chuc_vu_active',
    'phone',
    'email',
    'password',
    'sort_id',
    'sinh_giao_xu',
    'mat_giao_xu'
  ];

  /**
   * Get the post's thanh.
   */
  public function thanh()
  {
    return $this->hasOne(Thanh::class, $this->primaryKey, 'ten_thanh_id');
  }

  public function giaoXu()
  {
    return $this->hasOne(GiaoXu::class, $this->primaryKey, 'giao_xu_id');
  }

  public function ripGiaoXu()
  {
    return $this->hasOne(GiaoXu::class, $this->primaryKey, 'rip_giao_xu_id');
  }

  public function dong()
  {
    return $this->hasOne(Dong::class, $this->primaryKey, 'ten_dong_id');
  }

  public function bangCaps()
  {
    return $this->hasMany(LinhmucBangcap::class, 'linh_muc_id');
  }

  public function chucThanhs()
  {
    return $this->hasMany(LinhmucChucthanh::class, 'linh_muc_id')
      ->orderBy('chuc_thanh_id');
  }

  public function vanThus()
  {
    return $this->hasMany(LinhmucVanthu::class, 'linh_muc_id');
  }

  public function thuyenChuyens()
  {
    return $this->hasMany(LinhmucThuyenchuyen::class, 'linh_muc_id')->orderBy('from_date');
  }

  public function boNhiems()
  {
    return $this->hasMany(LinhmucBoNhiem::class, 'linh_muc_id')
      ->orderByDesc('cong_viec_den_nam')
      ->orderByDesc('cong_viec_den_thang')
      ->orderByDesc('cong_viec_den_ngay');
  }

  public function lmThuyenChuyens()
  {
    return $this->hasMany(LinhmucGpThuyenChuyen::class, 'linh_muc_id')
      ->orderByDesc('dia_diem_den_nam')
      ->orderByDesc('dia_diem_den_thang')
      ->orderByDesc('dia_diem_den_ngay');
  }

  public function getTenThanhAttribute($value)
  {
    $value = ($this->thanh) ? $this->thanh->name : '';

    return $value;
  }

  public function getTenGiaoXuAttribute($value)
  {
    $value = ($this->giaoXu) ? $this->giaoXu->name : '';

    return $value;
  }

  public function getTenHatXuAttribute($value)
  {
    $value = ($this->giaoXu) ? $this->giaoXu->ten_giao_hat : '';

    return $value;
  }

  public function getTenDongAttribute($value)
  {
    $value = ($this->dong) ? $this->dong->name : '';

    return $value;
  }

  public function getTenCongDoanNgoaiAttribute($value)
  {
    $value = ($this->dong) ? $this->dong->name : '';

    return $value;
  }

  public function getTenRipGiaoXuAttribute($value)
  {
    $value = ($this->ripGiaoXu) ? $this->ripGiaoXu->name : '';

    return $value;
  }

}
