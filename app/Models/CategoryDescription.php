<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class CategoryDescription extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'category_descriptions';

    /**
     * @var string
     */
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

    public function getDescriptionAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }

    /**
     * @author : dtphi .
     * @param $cateId
     */
    public static function fcDeleteByCateId($cateId)
    {
        DB::delete("delete from `" . Tables::$category_descriptions . "` where category_id = '" . (int)$cateId . "'");
    }

    /**
     * @author : dtphi .
     * @param null $cateId
     * @param string $name
     * @param string $description
     * @param string $metaTitle
     * @param string $metaDescription
     * @param string $metaKeyword
     */
    public static function insertByCateId(
        $cateId = null,
        $name = '',
        $description = '',
        $metaTitle = '',
        $metaDescription = '',
        $metaKeyword = ''
    ) {
        $cateId = (int)$cateId;

        if ($cateId && !empty($name) && !empty($metaTitle)) {
            DB::insert('insert into ' . Tables::$category_descriptions . ' (category_id, name, description, meta_title, meta_description, meta_keyword) values (?, ?, ?, ?, ?, ?)',
                [$cateId, $name, $description, $metaTitle, $metaDescription, $metaKeyword]);
        }
    }

    public static function truncateForce()
    {
        DB::statement('truncate table ' . Tables::$category_descriptions);
    }
}
