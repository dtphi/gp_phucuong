<?php

namespace App\Models;

class NewsGroup extends BaseModel
{
    protected $table = 'news_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'father_id',
        'newsgroupname',
        'user_id',
        'description',
        'displays',
        'sort'
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
