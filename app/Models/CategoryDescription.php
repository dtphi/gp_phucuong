<?php

namespace App\Models;

class CategoryDescription extends BaseModel
{
    protected $table = DB_PREFIX  . 'category_descriptions';

    protected $primaryKey = 'category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];
}
