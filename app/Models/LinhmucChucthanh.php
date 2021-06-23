<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinhmucChucthanh extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'linhmuc_chucthanhs';

    public static function insertByLinhmucId(
        $linhmucId = null,
        $chucThanhId = null,
        $ngayChucThanh = '',
        $noiThuPhong = '',
        $nguoiThuPhong = '',
        $active = 1,
        $ghichu = ''
    ) {
        $linhmucId = (int)$linhmucId;
        if (!empty($ngayChucThanh)) {
            $date = date_create($ngayChucThanh);
            $dateAvailable = date_format($date,"Y-m-d H:i:s");
            $ngayChucThanh = $dateAvailable;
        } else {
            $ngayChucThanh = now();
        }

        if ($linhmucId) {
            DB::insert('insert into ' . Tables::$linhmuc_chucthanhs . ' (linh_muc_id, chuc_thanh_id, ngay_thang_nam_chuc_thanh, noi_thu_phong, nguoi_thu_phong, active, ghi_chu) values (?, ?, ?, ?, ?, ?, ?)',
                [$linhmucId, $chucThanhId, $ngayChucThanh, $noiThuPhong, $nguoiThuPhong, $active, $ghichu]);
        }
    }
}
