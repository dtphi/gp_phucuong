<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoDiem extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giao_diems';

    protected $fillable = [
        'name',
        'sort_id',
        'dia_chi',
        'ghi_chu',
        'active',
        'update_user'
    ];
}
