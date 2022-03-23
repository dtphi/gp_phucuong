<?php

namespace App\Models;

use DB;
use App\Http\Common\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thanh extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'thanhs';

    protected $fillable = [
        'name',
        'latin',
        'ghi_chu',
        'bon_mang',
        'cuoc_doi',
        'active',
        'update_user'
    ];

    public function fcDeleteById($id) {
        DB::delete("delete from `" . Tables::$thanhs . "` where id = '" . (int)$id . "'");
    }
}
