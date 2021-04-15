<?php

namespace App\Models;

use DB;

class Category extends BaseModel
{
    protected $table = DB_PREFIX  . 'categorys';

    protected $primaryKey = 'category_id';

    /**
     * Get the description associated with the category.
     */
    public function description()
    {
        return $this->hasOne(CategoryDescription::class, $this->primaryKey);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'parent_id',
        'sort_order',
        'status'
    ];

    public function getDisplaysAttribute($value)
    {
        if ($value) {
            return unserialize($value);
        }
        return array('home_page' => false, 'news_page' => false);
    }

    /**
     * [getNewsGroups description]
     * @param  array $data [description]
     * @return [type]       [description]
     */
    public static function getNewsGroups(array $data)
    {
        $query = self::select('id', 'father_id', 'newsgroupname')->orderByDesc('id');

        return [
            'total' => $query->count(),
            'data'  => $query->get()->toArray()
        ];
    }

    public static function fcDeleteByCateId($cateId)
    {
        DB::delete("delete from `" . Tables::$categorys . "` where category_id = '" . (int)$cateId . "'");
    }
}
