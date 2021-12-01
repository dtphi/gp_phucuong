<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Albums;

class GroupAlbums extends Model
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
}
