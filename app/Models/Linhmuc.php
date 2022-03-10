<?php

namespace App\Models;

use DB;
use App\Models\GiaoXu;
use App\Http\Common\Tables;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Linhmuc extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'linhmucs';

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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

    public function getTenRipGiaoXuAttribute($value)
    {
        $value = ($this->ripGiaoXu) ? $this->ripGiaoXu->name : '';

        return $value;
    }

    public function getArrBangCapListAttribute($value)
    {
        $value = [];
        if ($this->bangCaps) {
            foreach ($this->bangCaps as $bangCap) {
                $value[] = [
                    'id' => (int)$bangCap->id,
                    'isCheck' => false,
                    'isEdit' => 1,
                    'name' => $bangCap->name,
                    'type' => $bangCap->type,
                    'ghi_chu' =>  $bangCap->ghi_chu,
                    'active' =>  $bangCap->active,
                ];
            }
        }

        return $value;
    }

    public function getArrChucThanhListAttribute($value)
    {
        $value = [];
        if ($this->chucThanhs) {
            foreach ($this->chucThanhs as $chucThanh) {
                $value[] = [
                    'id' => (int)$chucThanh->id,
                    'isCheck' => false,
                    'isEdit' => 1,
                    'chuc_thanh_id'      => $chucThanh->chuc_thanh_id,
                    'ngay_thang_nam_chuc_thanh' => $chucThanh->ngay_thang_nam_chuc_thanh,
                    'label_ngay_thang_nam_chuc_thanh' => ($chucThanh->ngay_thang_nam_chuc_thanh)?date_format(date_create($chucThanh->ngay_thang_nam_chuc_thanh),"d-m-Y"):'',
                    'noi_thu_phong' => $chucThanh->noi_thu_phong,
                    'nguoi_thu_phong' => $chucThanh->nguoi_thu_phong,
                    'ghi_chu' => $chucThanh->ghi_chu,
                    'active' => $chucThanh->active
                ];
            }
        }

        return $value;
    }

    public function getArrVanThuListAttribute($value)
    {
        $value = [];
        if ($this->vanThus) {
            foreach ($this->vanThus as $vanThu) {
                $value[] = [
                    'id' => (int)$vanThu->id,
                    'isCheck' => false,
                    'isEdit' => 1,
                    'title'      => $vanThu->title,
                    'ghi_chu' => $vanThu->ghi_chu,
                    'type' => $vanThu->type,
                    'active' => $vanThu->active
                ];
            }
        }

        return $value;
    }

    public function getArrThuyenChuyenListAttribute($value)
    {
        $value = [];
        if ($this->thuyenChuyens) {
            foreach ($this->thuyenChuyens as $thuyenChuyen) {
                $value[] = [
                    'id' => (int)$thuyenChuyen->id,
                    'isCheck' => false,
                    'isEdit' => 1,
                    'from_giao_xu_id'      => (int)$thuyenChuyen->from_giao_xu_id,
                    'fromgiaoxuName'      => $thuyenChuyen->ten_from_giao_xu,
                    'from_chuc_vu_id' => (int)$thuyenChuyen->from_chuc_vu_id,
                    'fromchucvuName' => $thuyenChuyen->ten_from_chuc_vu,
                    'from_date' => $thuyenChuyen->from_date,
                    'label_from_date' => ($thuyenChuyen->from_date)?date_format(date_create($thuyenChuyen->from_date),"d-m-Y"):'',
                    'duc_cha_id' => $thuyenChuyen->duc_cha_id,
                    'ducchaName' => $thuyenChuyen->ten_duc_cha,
                    'to_date' => $thuyenChuyen->to_date,
                    'label_to_date' => ($thuyenChuyen->to_date)?date_format(date_create($thuyenChuyen->to_date),"d-m-Y"):'',
                    'chuc_vu_id' => $thuyenChuyen->chuc_vu_id,
                    'chucvuName' => $thuyenChuyen->ten_to_chuc_vu,
                    'giao_xu_id' => $thuyenChuyen->giao_xu_id,
                    'giaoxuName' => $thuyenChuyen->ten_to_giao_xu,
                    'giaoHatName' => $thuyenChuyen->ten_to_hat_xu,
                    'co_so_gp_id' => $thuyenChuyen->co_so_gp_id,
                    'cosogpName' => $thuyenChuyen->ten_co_so,
                    'dong_id' => $thuyenChuyen->dong_id,
                    'dongName' => $thuyenChuyen->ten_dong,
                    'ban_chuyen_trach_id' => $thuyenChuyen->ban_chuyen_trach_id,
                    'banchuyentrachName' => $thuyenChuyen->ten_ban_chuyen_trach,
                    'du_hoc' => $thuyenChuyen->du_hoc,
                    'quoc_gia' => $thuyenChuyen->quoc_gia,
                    'ghi_chu' => $thuyenChuyen->ghi_chu,
                    'active' => $thuyenChuyen->active,
										'chuc_vu_active' => $thuyenChuyen->chuc_vu_active,
                ];
            }
        }

        return $value;
    }

    public function getArrBoNhiemListAttribute($value)
    {
        $value = [];
        if ($this->boNhiems) {
            foreach ($this->boNhiems as $boNhiem) {
                $value[] = [
                    'id' => (int)$boNhiem->id,
                    'chuc_vu_id' => $boNhiem->chuc_vu_id,
                    'chucVuName' => $boNhiem->ten_chuc_vu,
                    'cong_viec' => $boNhiem->cong_viec,
                    'cong_viec_tu_ngay'      => $boNhiem->cong_viec_tu_ngay,
                    'cong_viec_tu_thang'      => $boNhiem->cong_viec_tu_thang,
                    'cong_viec_tu_nam'      => $boNhiem->cong_viec_tu_nam,
                    'cong_viec_den_ngay'      => $boNhiem->cong_viec_den_ngay,
                    'cong_viec_den_thang'      => $boNhiem->cong_viec_den_thang,
                    'cong_viec_den_nam'      => $boNhiem->cong_viec_den_nam,
                    'active' => $boNhiem->active
                ];
            }
        }

        return $value;
    }

    public function getArrLmThuyenChuyenListAttribute($value)
    {
        $value = [];
        if ($this->lmThuyenChuyens) {
            foreach ($this->lmThuyenChuyens as $thuyenCh) {
                $value[] = [
                    'id' => (int)$thuyenCh->id,
                    'chuc_vu_id' => $thuyenCh->chuc_vu_id,
                    'chucVuName' => $thuyenCh->ten_chuc_vu,
                    'dia_diem_id' => $thuyenCh->dia_diem_id,
                    'diaDiemName' => $thuyenCh->ten_dia_diem,
                    'dia_diem_loai' => $thuyenCh->dia_diem_loai,
                    'dia_diem_tu_ngay'      => $thuyenCh->dia_diem_tu_ngay,
                    'dia_diem_tu_thang'      => $thuyenCh->dia_diem_tu_thang,
                    'dia_diem_tu_nam'      => $thuyenCh->dia_diem_tu_nam,
                    'dia_diem_den_ngay'      => $thuyenCh->dia_diem_den_ngay,
                    'dia_diem_den_thang'      => $thuyenCh->dia_diem_den_thang,
                    'dia_diem_den_nam'      => $thuyenCh->dia_diem_den_nam,
                    'active' => $thuyenCh->active
                ];
            }
        }

        return $value;
    }

    public function scopeName($query, $request) {
      return  $query->where('ten', 'LIKE', '%' . $request->input('query') . '%');
  }
}
