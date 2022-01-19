<?php

namespace App\Models;

use App\Http\Common\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NgayLe extends BaseModel
{
    /**
     * @var string
     */
    // chỗ này m phải điền thêm các thuộc tính m muốn thêm vào ..... vd người ta muốn thêm role = admin như trong bài viết nói ấy
    // fillable nó nhưng trường cho phép thêm vào csdl
    protected $table = DB_PREFIX . 'ngay_les';

    protected $fillable = [
        'code',
        'solar_day',
        'solar_month',
        'lunar_day',
        'lunar_month',
        'ten_le',
        'loai_le',
        'bac_le',
        'hanh',
        'is_active',
        'nam_ai',
        'nam_aii',
        'nam_bi',
        'nam_bii',
        'nam_ci',
        'nam_cii',
        'update_user',
    ];

    public static function fcDeleteByNgayLeId($id = null)
    {
        $id = (int)$id;

        if ($id) {
            return DB::delete("delete from " . Tables::$ngay_les . " where id = '" . $id . "'");
        }
    }
}
