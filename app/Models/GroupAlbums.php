<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Albums;
use App\Http\Common\Tables;
use DB;

class GroupAlbums extends BaseModel
{
    use HasFactory;

    protected $table = DB_PREFIX . 'group_albums';

    protected $fillable = [
      'group_name',
      'status',
      'sort_id',
      'update_user'
    ];

    public function albums()
	  {
	  	return $this->hasMany(Albums::class);
	  }

    public static function fcDeleteById($id)
    {
      DB::delete("delete from `" . Tables::$group_albums . "` where id = '" . (int)$id . "'");
    }
}
