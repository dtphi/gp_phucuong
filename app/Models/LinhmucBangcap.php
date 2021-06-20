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
        $active = 1,
        $ghichu = ''
    ) {
        $linhmucId = (int)$linhmucId;

        if ($linhmucId) {
            DB::insert('insert into ' . Tables::$linhmuc_bangcaps . ' (linhmuc_id, name, type, ghichu, active) values (?, ?, ?, ?, ?)',
                [$linhmucId, $name, $type, $ghichu, $active]);
        }
    }
}
