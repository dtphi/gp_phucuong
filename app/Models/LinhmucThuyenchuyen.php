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

        if ($linhmucId) {
            DB::insert('insert into ' . Tables::$linhmuc_thuyenchuyens . ' (linh_muc_id, from_giao_xu_id, from_chuc_vu_id, from_date, duc_cha_id, to_date, chuc_vu_id, giao_xu_id, co_so_gp_id, dong_id, ban_chuyen_trach_id, du_hoc, quoc_gia, active, ghi_chu) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [$linhmucId, $fromGiaoXuId, $fromChucVuId, $fromDate, $ducChaId, $toDate, $toChucVuId, $toGiaoXuId, $cosogpId, $dongId, $banChuyenTrachId, $duhoc, $quocGia, $active, $ghichu]);
        }
    }
}
