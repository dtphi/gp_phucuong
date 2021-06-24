<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CoSoGiaoPhan;

class LinhmucBangcap extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'linhmuc_bangcaps';

    public static function insertByLinhmucId(
        $linhmucId = null,
        $name = null,
        $type = 0,
        $ghichu = '',
        $active = 1
    ) {
        $linhmucId = (int)$linhmucId;

        if ($linhmucId) {
            DB::insert('insert into ' . Tables::$linhmuc_bangcaps . ' (linh_muc_id, name, type, ghi_chu, active) values (?, ?, ?, ?, ?)',
                [$linhmucId, $name, $type, $ghichu, $active]);
        }
    }

    public static function fcDeleteByLinhmucId($linhmucId = null)
    {
        $linhmucId = (int)$linhmucId;

        if ($linhmucId) {
            return DB::delete("delete from " . Tables::$linhmuc_bangcaps . " where linh_muc_id = '" . $linhmucId . "'");
        }
    }
}
