<?php

namespace App\Models;

use App\Http\Common\Tables;
use App\Http\Controllers\Api\Admin\Base\ApiController;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'informations';

    /**
     * @var string
     */
    protected $primaryKey = 'information_id';

    /**
     * @var array
     */
    protected $categoryDisplayList = [];

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function infoDes()
    {
        return $this->hasOne(InformationDescription::class, $this->primaryKey);
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relateds()
    {
        return $this->hasMany(InformationRelated::class, $this->primaryKey);
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(InformationToCategory::class, $this->primaryKey);
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(InformationImage::class, $this->primaryKey)->whereNull('album_id');
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albumImages()
    {
        return $this->hasMany(InformationImage::class, $this->primaryKey)->where('album_id', '>', 0);
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function infoCarousel()
    {
        return $this->hasOne(InformationCarousel::class, $this->primaryKey);
    }

    public static function fcDeleteByInfoId($infoId = null)
    {
        $infoId = (int)$infoId;

        if ($infoId) {
            return DB::delete("delete from " . Tables::$informations . " where information_id = '" . $infoId . "'");
        }
    }
    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function downloads()
    {
        return $this->hasMany(InformationToDownload::class, $this->primaryKey);
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return mixed
     */
    public function getImageAttribute($value)
    {
        $imgThumb = $value;
        if (is_null($imgThumb)) {
            $value = ApiController::$thumImgNo;
            $imgThumb = $value;
        }
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

    /**
     * @author : dtphi .
     * @param $value
     * @return mixed
     */
    public function getDateAvailableAttribute($value)
    {
        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return int
     */
    public function getSortOrderAttribute($value)
    {
        return (int)$value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return int
     */
    public function getViewedAttribute($value)
    {
        return (int)$value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return int
     */
    public function getStatusAttribute($value)
    {
        return (int)$value;
    }

    public function getStatusTextAttribute($value)
    {
        return Tables::$infoStatus[$this->status];
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->name : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->description : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getMetaTitleAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->meta_title : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getMetaDescriptionAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->meta_description : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getTagAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->tag : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getMetaKeywordAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->meta_keyword : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return array
     */
    public function getArrRelatedListAttribute($value)
    {
        $relateds = [];
        if ($this->relateds) {
            foreach ($this->relateds as $related) {
                $relateds[] = (int)$related->related_id;
            }
        }

        return $relateds;
    }

    public function getSpecialCarouselsAttribute($value)
    {
        $value = [];
        if ($this->infoCarousel) {
            if ($this->infoCarousel->image) {
                $value = unserialize($this->infoCarousel->image);
            }
        }

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return array
     */
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

    /**
     * @author : dtphi .
     * @param $value
     * @return array
     */
    public function getArrAlbumListAttribute($value)
    {
        $value = [];
        if ($this->albumImages) {
            foreach ($this->albumImages as $image) {
                $value[] = [
                    'album_id' => $image->album_id,
                    'name' => $image->album_name,
                    'image_origin' => $image->image_origin,
                    'images'      => $image->arr_image_list
                ];
            }
        }

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return array
     */
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

    /**
     * @author : dtphi .
     * @param $value
     * @return array
     */
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
            $modelPath = new CategoryPath();
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

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getGroupNameAttribute($value)
    {
        if (is_null($this->group)) {
            return ucfirst($value);
        }

        return ucfirst($this->group->newsgroupname);
    }

    /**
     * @author : dtphi .
     * @param $query
     * @param string $alias
     * @return mixed
     */
    public function scopeLjoinDescription($query, $alias = '')
    {
        if (empty($alias)) {
            $alias = Tables::$information_descriptions;
        }

        return $query->leftJoin(Tables::$information_descriptions . ' AS ' . $alias, $this->table . '.information_id',
            '=',
            $alias . '.information_id');
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
            DB::insert('insert into ' . Tables::$informations . ' (information_id, user_create, name_slug, image, date_available, sort_order, information_type, status, viewed, vote, sort_description) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
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
                ]);
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
