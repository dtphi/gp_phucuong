<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoPhanTinTuc extends BaseModel
{
  use SoftDeletes;

  /**
   * @var string
   */
  protected $table = DB_PREFIX . 'giao_phan_tin_tucs';

  /**
   * @var string
   */
  protected $primaryKey = 'information_id';

  /**
   * @var array
   */
  protected $categoryDisplayList = [];


  public function infoDes()
  {
    return $this->hasOne(GiaoPhanTinTucMoTa::class, $this->primaryKey);
  }


  public function categories()
  {
    return $this->hasMany(GiaoPhanTinTucDanhMuc::class, $this->primaryKey);
  }


  public function getImageAttribute($value)
  {
    $imgThumb = $value;
    if (
      isset($this->image_thumb)
      && $this->image_thumb
      && file_exists(public_path('/.tmb' . $this->image_thumb))
    ) {
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

  public function getDateAvailableAttribute($value)
  {
    return $value;
  }

  public function getSortOrderAttribute($value)
  {
    return (int)$value;
  }

  public function getViewedAttribute($value)
  {
    return (int)$value;
  }

  public function getStatusAttribute($value)
  {
    return (int)$value;
  }

  public function getStatusTextAttribute($value)
  {
    return Tables::$infoStatus[$this->status];
  }

  public function getNameAttribute($value)
  {
    $value = ($this->infoDes) ? $this->infoDes->name : '';

    return $value;
  }

  public function getDescriptionAttribute($value)
  {
    $value = ($this->infoDes) ? $this->infoDes->description : '';

    return $value;
  }

  public function getMetaTitleAttribute($value)
  {
    $value = ($this->infoDes) ? $this->infoDes->meta_title : '';

    return $value;
  }

  public function getMetaDescriptionAttribute($value)
  {
    $value = ($this->infoDes) ? $this->infoDes->meta_description : '';

    return $value;
  }

  public function getTagAttribute($value)
  {
    $value = ($this->infoDes) ? $this->infoDes->tag : '';

    return $value;
  }

  public function getMetaKeywordAttribute($value)
  {
    $value = ($this->infoDes) ? $this->infoDes->meta_keyword : '';

    return $value;
  }

  /* public function getArrRelatedListAttribute($value)
  {
    $relateds = [];
    if ($this->relateds) {
      foreach ($this->relateds as $related) {
        $relateds[] = (int)$related->related_id;
      }
    }

    return $relateds;
  }
 */
 /*  public function getSpecialCarouselsAttribute($value)
  {
    $value = [];
    if ($this->infoCarousel) {
      if ($this->infoCarousel->image) {
        $value = unserialize($this->infoCarousel->image);
      }
    }

    return $value;
  } */

  public function getArrImageListAttribute($value)
  {
    $value = [];
    if ($this->images) {
      foreach ($this->images as $image) {
        $value[] = [
          'image'      => $image->image,
          'sort_order' => (int)$image->sort_order
        ];
      }
    }

    return $value;
  }

  public function getArrDownloadListAttribute($value)
  {
    $value = [];
    if ($this->downloads) {
      foreach ($this->downloads as $download) {
        $value[] = (int)$download->download_id;
      }
    }

    return $value;
  }


  public function getArrCategoryListAttribute($value)
  {
    $value = [];
    if ($this->categories) {
      foreach ($this->categories as $category) {
        $value[] = (int)$category->category_id;
      }
    }

    $this->setArrCategoryDisplayList($value);

    return $value;
  }

  public function setArrCategoryDisplayList($value = [])
  {
    if (!empty($value)) {
      $modelPath = new GiaoPhanDanhMucLienKet();
      $models    = $modelPath->getQueryCategories()->whereIn('cate1.category_id', $value)->get();

      foreach ($models as $model) {
        $this->categoryDisplayList[] = [
          'category_id' => $model->category_id,
          'name'        => $model->name
        ];
      }
    }
  }

  public function getcategoryDisplayListAttribute($value)
  {
    return $this->categoryDisplayList;
  }

  protected $fillable = [
    'image',
    'image_thumb',
    'information_type',
    'user_create',
    'name_slug',
    'sort_description',
    'date_available',
    'sort_order',
    'status',
    'viewed'
  ];


  public function getGroupNameAttribute($value)
  {
    if (is_null($this->group)) {
      return ucfirst($value);
    }

    return ucfirst($this->group->newsgroupname);
  }

  public function scopeLjoinDescription($query, $alias = '')
  {
    if (empty($alias)) {
      $alias = Tables::$giaophantintuc_motas;
    }

    return $query->leftJoin(
      Tables::$giaophantintuc_motas . ' AS ' . $alias,
      $this->table . '.information_id',
      '=',
      $alias . '.information_id'
    );
  }

  public static function insertForce(
    $infoId = null,
    $image = null,
    $dateAvailable = null,
    $sortOrder = 0,
    $status = 1,
    $viewed = 0,
    $vote = 0,
    $sortDes = '',
    $nameSlug = '',
    $createUser = 0,
    $infoType = 1
  ) {
    $infoId = (int)$infoId;
    $viewed = (int)$viewed;
    $vote   = (int)$vote;

    if ($infoId) {
      DB::insert(
        'insert into ' . Tables::$informations . ' (information_id, user_create, name_slug, image, date_available, sort_order, information_type, status, viewed, vote, sort_description) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [
          $infoId,
          $createUser,
          $nameSlug,
          $image,
          $dateAvailable,
          $sortOrder,
          $infoType,
          $status,
          $viewed,
          $vote,
          $sortDes
        ]
      );
    }
  }

  public static function truncateForce()
  {
    DB::statement('truncate table ' . Tables::$informations);
  }

  public function scopeOrderByDescDateAvailable($query)
  {
    $query->orderByDesc($this->table . '.date_available');

    return $query;
  }

  public function scopeOrderByDescViewed($query)
  {
    $query->orderByDesc($this->table . '.viewed');

    return $query;
  }
}
