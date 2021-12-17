<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dong extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'dongs';

    protected $fillable = [
      'name',
      //'giaophan_id',
      'dia_chi',
      'dien_thoai',
      'email',
      'viet',
      'latin',
      'noi_dung',
      'active',
      'update_user',
    ];
}
