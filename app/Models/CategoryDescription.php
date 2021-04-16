<?php

namespace App\Models;

use App\Http\Common\Tables;
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

    public static function insertByCateId($cateId = null, $name = '', $description = '', $metaTitle = '', $metaDescription = '', $metaKeyword = '')
    {
        if ($cateId && !empty($name) && !empty($metaTitle)) {
            DB::insert('insert into ' . Tables::$category_descriptions . ' (category_id, name, description, meta_title, meta_description, meta_keyword) values (?, ?, ?, ?, ?, ?)', [
                (int)$cateId, $name, $description, $metaTitle, $metaDescription, $metaKeyword
            ]);
        }
    }
}
