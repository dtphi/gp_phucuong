<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoHat extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giao_hats';


    protected $fillable = [
      'name',
      'khu_vuc',
      'nguoi_quan_hat',
      'sort_id',
      'active',
      'update_user',
      'create_at',
      'update_at',
      'delete_at',
    ];
}
