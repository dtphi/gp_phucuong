<?php

namespace App\Models;

use DB;
use App\Models\GiaoXu;
use App\Models\GiaoPhan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GiaoHat extends BaseModel
{ 
    /**
     * 
     * @var string
     */
    protected $table = DB_PREFIX . 'giao_hats';


    protected $fillable = [
      'name',
      'khuvuc',
      'nguoiquanhat',
      'sort_id',
      'active',
      'updateuser',
      'updatetime',
      'create_at',
      'update_at',
      'delete_at',
    ];

    public function giaoxus()
	{
		return $this->hasMany(GiaoXu::class);
	}
}
