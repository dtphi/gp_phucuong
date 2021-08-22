<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongDoanTuSi extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'cong_doan_tu_sis';

    protected $fillable = [
        'name',
        'dia_chi',
        'dien_thoai',
        'ghi_chu',
        'active',
        'update_user'
    ];
}
