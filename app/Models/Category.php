<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $table = DB_PREFIX  . 'categorys';

     protected $primaryKey = 'category_id';

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
}
