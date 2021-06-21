<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'noicap_cmnd',
        'ngay_cap_cmnd',
        'trieu_dong',
        'ten_dong_id',
        'ngay_trieu_dong',
        'ngay_khan',
        'ngay_rip',
        'rip_giaoxu_id',
        'rip_ghi_chu',
        'ghichu',
        'updateuser',
        'sort_id'
    ];

}
