<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoXu extends BaseModel
{
  use SoftDeletes;

  /**
   * @var string
   */
  protected $table = DB_PREFIX . 'giao_xus';
  protected $fillable = [
    'name',
    'giaohat_id',
    'dia_chi',
    'dien_thoai',
    'email',
    'active',
    'danso',
    'sotinhuu',
    'giole',
    'viet',
    'latin',
    'noidung',
    'type',
    'updateuser'
  ];
}
