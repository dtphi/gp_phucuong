<?php

namespace App\Models;

use DB;
use App\Http\Common\Tables;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestrictIp extends BaseModel
{
  use SoftDeletes;
  
  protected $fillable = [
    'ip',
    'active',
    'update_user'
  ];

  public static function fcDeleteById($id)
  {
    DB::delete("delete from `" . Tables::$restrict_ips . "` where id = '" . (int)$id . "'");
  }
}
