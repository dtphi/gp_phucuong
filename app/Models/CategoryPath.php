<?php

namespace App\Models;

class CategoryPath extends BaseModel
{
    protected $table = DB_PREFIX  . 'category_paths';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'path_id',
        'level'
    ];
}
