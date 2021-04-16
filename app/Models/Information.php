<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class Information extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'informations';

    /**
     * @var string
     */
    protected $primaryKey = 'information_id';

    /**
     * Get the infoDes associated with the category.
     */
    public function infoDes()
    {
        return $this->hasOne(InformationDescription::class, $this->primaryKey);
    }

    public function relateds()
    {
        return $this->hasMany(InformationRelated::class, $this->primaryKey);
    }

    public function categories()
    {
        return $this->hasMany(InformationToCategory::class, $this->primaryKey);
    }

    public function images()
    {
        return $this->hasMany(InformationImage::class, $this->primaryKey);
    }

    public function downloads()
    {
        return $this->hasMany(InformationToDownload::class, $this->primaryKey);
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

    public function getNameAttribute($value) 
    {
        $value = $value ?? (($this->infoDes)?$this->infoDes->name:'');

        return strip_tags(html_entity_decode($value,ENT_QUOTES, 'UTF-8'));
    }

    public function getDescriptionAttribute($value)
    {
        $value = $value ?? (($this->infoDes)?$this->infoDes->description:'');

        return $value;
    }

    public function getMetaTitleAttribute($value) 
    {
        $value = $value ?? (($this->infoDes)?$this->infoDes->meta_title:'');

        return $value;
    }

    public function getMetaDescriptionAttribute($value)
    {
        $value = $value ?? (($this->infoDes)?$this->infoDes->meta_description:'');

        return $value;
    }

    public function getTagAttribute($value)
    {
        $value = $value ?? (($this->infoDes)?$this->infoDes->tag:'');

        return $value;
    }

    public function getMetaKeywordAttribute($value) 
    {
        $value = $value ?? (($this->infoDes)?$this->infoDes->meta_keyword:'');

        return $value;
    }

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

    public function getArrImageListAttribute($value)
    {
        $value = [];
        if ($this->images) {
            foreach( $this->images as $image) {
                $value[] = [
                    'image' => $image->image,
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
            foreach($this->downloads as $download) {
                $value[] = (int)$download->download_id;
            }
        }

        return $value;
    }

    public function getArrCategoryListAttribute($value)
    {
        $value = [];
        if ($this->categories) {
            foreach($this->categories as $category) {
                $value[] = (int)$category->category_id;
            }
        }

        return $value;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'date_available',
        'sort_order',
        'status',
        'viewed'
    ];

    /**
     * Get the group's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getGroupNameAttribute($value)
    {
        if (is_null($this->group)) return ucfirst($value);

        return ucfirst($this->group->newsgroupname);
    }

    public function scopeLjoinDescription($query, $alias = '')
    {
        if (empty($alias)) {
            $alias = Tables::$information_descriptions;
        }
        return $query->leftJoin(Tables::$information_descriptions . ' AS ' . $alias, $this->table . '.information_id', '=',
        $alias . '.information_id');
    }
}
