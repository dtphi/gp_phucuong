<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoSoGiaoPhan extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'co_so_giao_phans';

    protected $fillable = [
        'name',
        'dia_chi',
        'email',
        'dien_thoai',
        'fax',
        'website',
        'active',
        'update_user'
    ];

}
