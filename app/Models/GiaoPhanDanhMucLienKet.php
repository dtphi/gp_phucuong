<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use DB;
use App\Http\Common\Tables;

class GiaoPhanDanhMucLienKet extends BaseModel
{
  use HasFactory;

  protected $table = DB_PREFIX . 'danh_muc_giao_phan_lien_kets';

  public static $separate = ' >> ';

  protected $fillable = [
    'category_id',
    'path_id',
    'level',
  ];


  // groupby category_id
  public function scopeGbByCategoryId($query)
  {
    return $query->groupBy($this->table . '.category_id');
  }


  // get new name: group_name after groupby
  public static function getRawCategoryName($tbContainNameAlias = '', $rawAlias = 'name')
  {
    if (empty($tbContainNameAlias)) {
      $tbContainNameAlias = Tables::$giaophandanhmuc_lienkets;
    }

    return DB::raw("group_concat(" . $tbContainNameAlias . " . `name` ORDER BY " .
      Tables::$giaophandanhmuc_lienkets . ".level SEPARATOR '" . self::$separate . "') AS " . $rawAlias);
  }

  // delete all records in table 
  public static function truncateForce()
  {
    DB::statement(' truncate table ' . Tables::$giaophandanhmuc_lienkets);
  }

  // leftJoin table giaophandanhmucsd
  public function scopeLjoinCategory($query, $alias = '')
  {
    if (empty($alias)) {
      $alias = Tables::$giaophandanhmucs;
    }
    return $query->leftjoin(
      Tables::$giaophandanhmucs . ' as ' . $alias,
      $this->table . '.category_id',
      '=',
      $alias . '.category_id'
    );
  }

  // leftjoin table giaophandanhmuc_motas
  public function scopeLjoinCategoryDescription($query, $alias = '')
  {
    if (empty($alias)) {
      $alias = Tables::$giaophandanhmuc_motas;
    }
    return $query->leftJoin(
      Tables::$giaophandanhmuc_motas . ' as ' . $alias,
      $this->table . '.path_id',
      '=',
      $alias . '.category_id'
    );
  }

  // filter name
  public function scopeFilterLikeName($query, $alias = '', $name = '')
  {
    return $query->where($alias . '.name', 'like', "%{$name}");
  }

  // delete giaophandanhmuc lien ket
  public static function fcDeleteByCateId($cateId = null)
  {
    if ($cateId) {
      return DB::delete("delete from `" . Tables::$giaophandanhmuc_lienkets . "` where " . Tables::$giaophandanhmuc_lienkets . ".category_id = '" . (int)$cateId . "'");
    }
  }

  // delete with downlevel
  public static function fcDeleteByCateIdAndLevelDown($cateId = null, $level = 0)
  {
    if ($cateId) {
      return DB::delete("delete from `" . Tables::$giaophandanhmuc_lienkets . "` where " . Tables::$giaophandanhmuc_lienkets . ".category_id = '" . (int)$cateId . "' AND " . Tables::$giaophandanhmuc_lienkets . ".level < '" . (int)$level . "'");
    }
  }

  // replace cateid and path, level
  public static function replaceByCateidAndPathAndLevel($cateId = null, $pathId = null, $level = 0)
  {
    if ($cateId && $pathId) {
      return DB::statement("REPLACE INTO `" . Tables::$giaophandanhmuc_lienkets . "` SET " . Tables::$giaophandanhmuc_lienkets . ".category_id = '" . (int)$cateId . "', " . Tables::$giaophandanhmuc_lienkets . ".path_id = '" . (int)$pathId . "', " . Tables::$giaophandanhmuc_lienkets . ".level = '" . (int)$level . "'");
    }
  }

  // insert giaophandanhmuc_lienkets 
  public static function insertByCateId($cateId = null, $pathId = null, $level = 0)
  {
    $cateId = (int)$cateId;
    $pathId = (int)$pathId;
    $level  = (int)$level;

    if ($cateId && $pathId) {
      return DB::insert(
        'insert into ' . Tables::$giaophandanhmuc_lienkets . ' (category_id, path_id, level) values (?, ?, ?)',
        [$cateId, $pathId, $level]
      );
    }
  }

  public function getQueryCategories($data = array())
  {
    $cate1 = 'cate1';
    $cate2 = 'cate2';
    $cd1   = 'cd1';
    $cd2   = 'cd2';

    $query = $this->select(
      Tables::$giaophandanhmuc_lienkets . '.category_id AS category_id',
      $cate1 . '.parent_id',
      $cate1 . '.sort_order',
      self::getRawCategoryName($cd1)
    )
      ->gbByCategoryId()
      ->ljoinCategory($cate1)
      ->ljoinCategory($cate2)
      ->ljoinCateDescription($cd1)
      ->ljoinCateDescription($cd2);

    return $query;
  }
}
