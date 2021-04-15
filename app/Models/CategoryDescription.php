<?php

namespace App\Models;

use DB;

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

    public static function fcDeleteByCateId($cateId)
    {
        DB::delete("delete from `" . Tables::$category_descriptions . "` where category_id = '" . (int)$cateId . "'");
    }
}
