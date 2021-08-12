<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use DB;
use App\Http\Common\Tables;

class GiaoPhanDanhMucMoTa extends BaseModel
{
  use HasFactory;

  protected $table = DB_PREFIX . 'danh_muc_giao_phan_mo_tas';

  protected $primaryKey = 'category_id';

  protected $fillable = [
    'name',
    'description',
    'meta_title',
    'meta_description',
    'meta_keyword'
  ];

  // delete giaophandanhmuc_mota with category_id
  public static function fcDeleteByCateId($cateId)
  {
    DB::delete("delete from `" . Tables::$giaophandanhmuc_motas . "` where category_id = '" . (int)$cateId . "'");
  }

  // insert giaophandanhmuc_mota with category_id
  public static function insertByCateId(
    $cateId = null,
    $name = '',
    $description = '',
    $metaTitle = '',
    $metaDescription = '',
    $metaKeyword = ''
  ) {
    $cateId = (int)$cateId;

    if ($cateId && !empty($name) && !empty($metaTitle)) {
      DB::insert(
        'insert into ' . Tables::$giaophandanhmuc_motas . ' (category_id, name, description, meta_title, meta_description, meta_keyword) values (?, ?, ?, ?, ?, ?)',
        [$cateId, $name, $description, $metaTitle, $metaDescription, $metaKeyword]
      );
    }
  }

  public function getDescriptionAttribute($value)
  {
    return htmlspecialchars_decode($value);
  }
}
