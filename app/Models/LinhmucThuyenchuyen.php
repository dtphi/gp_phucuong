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
            DB::insert('insert into ' . Tables::$linhmuc_thuyenchuyens . ' (linhmuc_id, fromgiaoxu_id, fromchucvu_id, from_date, duccha_id, to_date, chucvu_id, giaoxu_id, cosogp_id, dong_id, banchuyentrach_id, duhoc, quocgia, active, ghichu) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [$linhmucId, $fromGiaoXuId, $fromChucVuId, $fromDate, $ducChaId, $toDate, $toChucVuId, $toGiaoXuId, $cosogpId, $dongId, $banChuyenTrachId, $duhoc, $quocGia, $active, $ghichu]);
        }
    }
}
