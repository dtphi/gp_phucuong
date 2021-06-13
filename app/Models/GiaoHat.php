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
}
