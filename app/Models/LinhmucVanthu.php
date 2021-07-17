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

    public function linhMuc()
    {
        return $this->belongsTo(Linhmuc::class);
    }

    public function getTenLinhMucAttribute($value)
    {
        $value = ($this->linhMuc) ? $this->linhMuc->ten : '';

        return $value;
    }

        /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'linh_muc_id',
        'title',
        'type',
        'ghi_chu',
        'active'
    ];

    public static function insertByLinhmucId(
        $linhmucId = null,
        $title = '',
        $type = 0,
        $active = 1,
        $ghichu = ''
    ) {
        $linhmucId = (int)$linhmucId;

        if ($linhmucId) {
            DB::insert('insert into ' . Tables::$linhmuc_vanthus . ' (linh_muc_id, title, type, active, ghi_chu) values (?, ?, ?, ?, ?)',
                [$linhmucId, $title, $type, $active, $ghichu]);
        }
    }

    public static function fcDeleteByLinhmucId($linhmucId = null)
    {
        $linhmucId = (int)$linhmucId;

        if ($linhmucId) {
            return DB::delete("delete from " . Tables::$linhmuc_vanthus . " where linh_muc_id = '" . $linhmucId . "'");
        }
    }
}
