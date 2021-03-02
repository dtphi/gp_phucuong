<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Information extends BaseModel
{
    protected $table = 'news';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Models\NewsGroup', 'newsgroup_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'newsgroup_id',
        'newsname',
        'user_id',
        'description',
        'newslink',
        'picture'
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
