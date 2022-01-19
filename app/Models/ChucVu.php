<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChucVu extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'chuc_vus';

    protected $fillable = [
        'name',
        'sort_id',
        'type_giao_xu',
        'vtbn',
        'active',
        'update_user'
    ];

    public function getVtbnAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }

    public static function fcDeleteById($id = null)
    {
        $id = (int)$id;

        if ($id) {
            return DB::delete("delete from " . Tables::$chuc_vus . " where id = '" . $id . "'");
        }
    }
}
