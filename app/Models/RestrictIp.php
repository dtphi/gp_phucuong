<?php

namespace App\Models;

use DB;
use App\Http\Common\Tables;
class RestrictIp extends BaseModel
{
  
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
