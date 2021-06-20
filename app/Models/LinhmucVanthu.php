<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinhmucVanthu extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'linhmuc_vanthus';

    public static function insertByLinhmucId(
        $linhmucId = null,
        $title = '',
        $type = 0,
        $active = 1,
        $ghichu = ''
    ) {
        $linhmucId = (int)$linhmucId;

        if ($linhmucId) {
            DB::insert('insert into ' . Tables::$linhmuc_vanthus . ' (linhmuc_id, title, type, active, ghichu) values (?, ?, ?, ?, ?)',
                [$linhmucId, $title, $type, $active, $ghichu]);
        }
    }
}
