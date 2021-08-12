<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class GiaoPhanTinTucDanhMuc extends BaseModel
{
  protected $table = DB_PREFIX . 'giao_phan_tin_tuc_danh_mucs';

  protected $primaryKey = ['infomation_id', 'category_id'];

  public function category()
  {
    return $this->belongsTo('App\Models\GiaoPhanDanhMuc', 'category_id');
  }

  protected $fillable = [
    'infomation_id',
    'category_id'
  ];

  public function getCategoryIdAttribute($value)
  {
    return $value;
  }

  public static function fcDeleteByCateId($cateId = null)
  {
    $cateId = (int)$cateId;

    if ($cateId) {
      return DB::delete("delete from `" . Tables::$giaophantintuc_danhmucs . "` where category_id = '" . $cateId . "'");
    }
  }

  public static function insertByInfoId($infoId = null, $cateId = null)
  {
    $infoId = (int)$infoId;
    $cateId = (int)$cateId;

    if ($infoId && $cateId) {
      DB::insert(
        'insert into ' . Tables::$giaophantintuc_danhmucs . ' (information_id, category_id) values (?, ?)',
        [
          $infoId,
          $cateId
        ]
      );
    }
  }

  // delete with infoId
  public static function fcDeleteByInfoId($infoId = null)
  {
    $infoId = (int)$infoId;

    if ($infoId) {
      return DB::delete("delete from " . Tables::$giaophantintuc_danhmucs . " where information_id = '" . $infoId . "'");
    }
  }

  public static function truncateForce()
  {
    DB::statement('truncate table ' . Tables::$giaophantintuc_danhmucs);
  }

  public function scopeFilterByInfoId($query, $infoId)
  {
    $query->where($this->table . '.information_id', (int)$infoId);

    return $query;
  }
}
