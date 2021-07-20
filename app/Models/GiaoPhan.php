<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GiaoPhanHat;
use App\Models\GiaoPhanDong;
use App\Models\GiaoPhanCoSo;
use App\Models\GiaoPhanBanChuyenTrach;

class GiaoPhan extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophans';

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'khai_quat',
        'active',
        'sort_id',
        'update_user',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'tag'
    ];

    public function hats()
    {
        return $this->hasMany(GiaoPhanHat::class, 'giao_phan_id');
    }

    public function dongs()
    {
        return $this->hasMany(GiaoPhanDong::class, 'giao_phan_id');
    }

    public function cosos()
    {
        return $this->hasMany(GiaoPhanCoSo::class, 'giao_phan_id');
    }

    public function banChuyenTrachs()
    {
        return $this->hasMany(GiaoPhanBanChuyenTrach::class, 'giao_phan_id');
    }

    public function getKhaiQuatAttribute($value)
    {
        return html_entity_decode(htmlspecialchars_decode($value));
    }

    public function getArrHatListAttribute($value)
    {
        $value = [];
        if ($this->hats) {
            foreach ($this->hats as $hat) {
                $value[] = [
                    'id' => $hat->id,
                    'isCheck'=> false,
                    'giaoHatOldId' => $hat->id,
                    'isEdit' => 1,
                    'active'=> $hat->active,
                    'cong_doan_tu_sis'=> $hat->arr_cong_doan_tu_si_list,
                    'giao_hat_id'=> $hat->giao_hat_id,
                    'giao_xus' => $hat->arr_giao_xu_list,
                    'hatName' => $hat->name
                ];
            }
        }

        return $value;
    }

    public function getArrDongListAttribute($value)
    {
        $value = [];
        if ($this->dongs) {
            foreach ($this->dongs as $dong) {
                $value[] = [
                    'id' => $dong->id,
                    'isCheck'=>false,
                    'dongOldId' => $dong->id,
                    'isEdit' => 1,
                    'active'=> $dong->active,
                    'dong_id'=> $dong->dong_id,
                    'dongName' => $dong->name
                ];
            }
        }

        return $value;
    }

    public function getArrCosoListAttribute($value)
    {
        $value = [];
        if ($this->cosos) {
            foreach ($this->cosos as $coso) {
                $value[] = [
                    'id' => $coso->id,
                    'isCheck'=> false,
                    'coSoOldId' => $coso->id,
                    'isEdit' => 1,
                    'active'=> $coso->active,
                    'co_so_giao_phan_id'=> $coso->co_so_giao_phan_id,
                    'cosoName' => $coso->name
                ];
            }
        }

        return $value;
    }

    public function getArrBanChuyenTrachListAttribute($value)
    {
        $value = [];
        if ($this->banChuyenTrachs) {
            foreach ($this->banChuyenTrachs as $banChuyenTrach) {
                $value[] = [
                    'id' => $banChuyenTrach->id,
                    'isCheck'=> false,
                    'banChuyenTrachOldId' => $banChuyenTrach->id,
                    'isEdit' => 1,
                    'active'=> $banChuyenTrach->active,
                    'ban_chuyen_trach_id'=> $banChuyenTrach->ban_chuyen_trach_id,
                    'banChuyenTrachName' => $banChuyenTrach->name
                ];
            }
        }

        return $value;
    }

}
