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
        return $this->hasMany(InformationRelated::class, 'information_id');
    }

    public function getNameAttribute() 
    {
        return $this->description->name;
    }

    public function getMetaTitleAttribute() 
    {
        return $this->description->meta_title;
    }

    public function getRelatedListAttribute($value)
    {
        $relateds = [];
        foreach ($this->relateds as $related) {
           $relateds[] = $related->related_id;
        }

        return $relateds;
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
