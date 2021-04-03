<?php

namespace App\Models;

class CategoryDescription extends BaseModel
{
    protected $table = DB_PREFIX  . 'category_descriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];
}
