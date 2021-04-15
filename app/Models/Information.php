<?php

namespace App\Models;

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
     * Get the description associated with the category.
     */
    public function description()
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
        return strip_tags(html_entity_decode($this->description->name,ENT_QUOTES, 'UTF-8'));
    }

    public function getDescriptionAttribute($value)
    {
        return $this->description->description;
    }

    public function getMetaTitleAttribute($value) 
    {
        return $this->description->meta_title;
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $this->description->meta_description;
    }

    public function getTagAttribute($value)
    {
        return $this->description->tag;
    }

    public function getMetaKeywordAttribute($value) 
    {
        return $this->description->meta_keyword;
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
}
