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
        $ngayChucThanh = null,
        $noiThuPhong = '',
        $nguoiThuPhong = '',
        $active = 1,
        $ghichu = ''
    ) {
        $linhmucId = (int)$linhmucId;

        if ($linhmucId) {
            DB::insert('insert into ' . Tables::$linhmuc_chucthanhs . ' (linhmuc_id, chuc_thanh_id, ngay_thang_nam_chuc_thanh, noi_thu_phong, nguoi_thu_phong, active, ghichu) values (?, ?, ?, ?, ?, ?, ?)',
                [$linhmucId, $chucThanhId, $ngayChucThanh, $noiThuPhong, $nguoiThuPhong, $active, $ghichu]);
        }
    }
}
