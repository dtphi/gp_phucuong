<?php

namespace App\Models;

use DB;
use App\Models\BaseModel;
use App\Models\GroupAlbums;
use App\Http\Common\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Albums extends BaseModel
{
  use HasFactory;

  protected $table = DB_PREFIX . 'albums';

  public function groupAlbums()
	{
		return $this->belongsTo(GroupAlbums::class, 'group_albums_id');
	}
 

  protected $fillable = [
    'albums_name',
    'group_albums_id',
    'status',
    'sort_id',
    'image_origin',
    'image_thumb',
    'image',
    'update_user'
  ];

  public function getTenGroupAlbumsAttribute($value) 
  {
    $value = ($this->groupAlbums) ? $this->groupAlbums->group_name : '';
    return $value;
  }

    public function getImageOriginAttribute($value)
    {
        $imgThumb = $value;
        if (isset($this->image_thumb)
            && $this->image_thumb
            && file_exists(public_path('/.tmb' . $this->image_thumb))) {
            $imgThumb = '/.tmb' . $this->image_thumb;
        }

        return [
            'basename'  => "",
            'dirname'   => "",
            'extension' => "",
            'filename'  => "",
            'path'      => $value,
            'size'      => 0,
            'timestamp' => null,
            'type'      => null,
            'thumb'     => $imgThumb
        ];
    }

    public function getNameGroupAlbumsAttribute($value)
    {
        $value = ($this->groupAlbums) ? $this->groupAlbums->group_name : '';

        return $value;
    }

    public function getGroupImagesAttribute($value)
    {
        $value = [];
        if ($this->image) {
            $value = unserialize($this->image);
        }
        return $value;
    }

      public static function fcDeleteById($id)
      {
        DB::delete("delete from `" . Tables::$albums . "` where id = '" . (int)$id . "'");
      }
}
