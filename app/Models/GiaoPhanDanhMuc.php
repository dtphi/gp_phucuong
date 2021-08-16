<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use DB;
use App\Http\Common\Tables;

class GiaoPhanDanhMuc extends BaseModel
{
  use HasFactory;

  protected $table = DB_PREFIX . 'danh_muc_giao_phans';

  protected $primaryKey = 'category_id';

  protected $fillable = [
    'image',
    'parent_id',
    'top',
    'name_slug',
    'tag',
    'column',
    'sort_order',
    'status',
    'user_create'
  ];


  //eloquent realations ( hasOne ) with TABLE giaophandanhmuc_motas
  public function description()
  {
    return $this->hasOne(GiaoPhanDanhMucMoTa::class, $this->primaryKey);
  }

  // get display attributes (serialize $array) 
  public function getDisplaysAttribute($value)
  {
    if ($value) {
      return unserialize($value);
    }
    return array('home_page' => false, 'news_page' => false);
  }

  //get giao phan danh muc
  public static function getGiaoPhanDanhMucs(array $data)
  {
    $query = self::select('id', 'father_id', 'newsgroupname')->orderByDesc('id');

    return [
      'total' => $query->count(),
      'data'  => $query->get()->toArray()
    ];
  }
  public static function fcDeleteByCateId($cateId)
  {
    DB::delete("delete from `" . Tables::$giaophandanhmucs . "` where category_id = '" . (int)$cateId . "'");
  }

  public static function insertForce(
    $cateId = null,
    $nameSlug = '',
    $parentId = null,
    $createUser = 0,
    $status = 1
  ) {
    $cateId   = (int)$cateId;
    $parentId = (int)$parentId;
    if ($parentId == -1) {
      $parentId = 0;
    }

    if ($cateId) {
      DB::insert(
        'insert into ' . Tables::$giaophandanhmucs . ' (category_id, parent_id, status, name_slug, user_create) values (?, ?, ?, ?, ?)',
        [$cateId, $parentId, $status, $nameSlug, $createUser]
      );
    }
  }

  //delete all records
  public static function truncateForce()
  {
    DB::statement('truncate table ' . Tables::$giaophandanhmucs);
  }

  public function scopeFilterParentId($query, $parentId = 0)
  {
    $query->where($this->table . '.parent_id', (int)$parentId);

    return $query;
  }

  public function scopeFilterActiveStatus($query)
  {
    $query->where($this->table . '.status', Tables::$infoStatusActive);

    return $query;
  }

  public function scopeOrderByAscSort($query)
  {
    $query->orderBy($this->table . '.sort_order', 'asc');

    return $query;
  }

  public function scopeOrderByAscParentId($query)
  {
    $query->orderBy($this->table . '.parent_id', 'asc');

    return $query;
  }

  public function scopeFilterById($query, $categoryId)
  {
    $query->where($this->table . '.category_id', (int)$categoryId);

    return $query;
  }

  public function scopeFilterInByIds($query, $categoryIds = [])
  {
    $query->whereIn($this->table . '.category_id', $categoryIds);

    return $query;
  }

  // public function scopeFilterLayoutId($query, $layoutId)
  // {
  //   $query->where(Tables::$category_to_layouts . '.layout_id', (int)$layoutId);

  //   return $query;
  // }

  public function scopeLfJoinDescription($query)
  {
    $query->leftJoin(
      Tables::$giaophandanhmuc_motas,
      $this->table . '.category_id',
      '=',
      Tables::$giaophandanhmuc_motas . '.category_id'
    );

    return $query;
  }

  // public function scopeLfJoinToLayout($query)
  // {
  //   $query->leftJoin(
  //     Tables::$category_to_layouts,
  //     $this->table . '.category_id',
  //     '=',
  //     Tables::$category_to_layouts . '.category_id'
  //   );

  //   return $query;
  // }
}
