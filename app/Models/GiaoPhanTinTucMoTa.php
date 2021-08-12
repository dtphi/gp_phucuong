<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoPhanTinTucMota extends BaseModel
{
  use SoftDeletes;

  /**
   * @var string
   */
  protected $table = DB_PREFIX . 'giao_phan_tin_tuc_mo_tas';

  /**
   * @var string
   */
  protected $primaryKey = 'information_id';

  /**
   * @var bool
   */
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'description',
    'tag',
    'meta_title',
    'meta_description',
    'meta_keyword'
  ];

  public function getNameAttribute($value)
  {
    return htmlspecialchars_decode($value);
  }

  public function getDescriptionAttribute($value)
  {
    return htmlspecialchars_decode($value);
  }

  public function getMetaTitleAttribute($value)
  {
    return $value;
  }

  public function getMetaDescriptionAttribute($value)
  {
    return $value;
  }

  public function getTagAttribute($value)
  {
    return $value;
  }

  public function getMetaKeywordAttribute($value)
  {
    return $value;
  }

  public static function insertByInfoId(
    $infoId = null,
    $name = '',
    $description = '',
    $tag = '',
    $metaTitle = '',
    $metaDescription = '',
    $metaKeyword = ''
  ) {
    $infoId = (int)$infoId;

    if ($infoId && !empty($name) && !empty($metaTitle)) {
      DB::insert(
        'insert into ' . Tables::$giaophantintuc_motas . ' (information_id, name, description, tag, meta_title, meta_description, meta_keyword) values (?, ?, ?, ?, ?, ?, ?)',
        [
          $infoId,
          $name,
          $description,
          $tag,
          $metaTitle,
          $metaDescription,
          $metaKeyword
        ]
      );
    }
  }

  public static function fcDeleteByInfoId($infoId = null)
  {
    $infoId = (int)$infoId;

    if ($infoId) {
      return DB::delete("delete from " . Tables::$giaophantintuc_motas . " where information_id = '" . $infoId . "'");
    }
  }

  public static function truncateForce()
  {
    DB::statement('truncate table ' . Tables::$giaophantintuc_motas);
  }
}
