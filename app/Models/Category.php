<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class Category extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'categorys';

    /**
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
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
        'top',
        'name_slug',
        'tag',
        'column',
        'sort_order',
        'status',
        'user_create'
    ];

    /**
     * @author : dtphi .
     * @param $value
     * @return array|mixed
     */
    public function getDisplaysAttribute($value)
    {
        if ($value) {
            return unserialize($value);
        }

        return array('home_page' => false, 'news_page' => false);
    }

    /**
     * @author : dtphi .
     * @param array $data
     * @return array
     */
    public static function getNewsGroups(array $data)
    {
        $query = self::select('id', 'father_id', 'newsgroupname')->orderByDesc('id');

        return [
            'total' => $query->count(),
            'data'  => $query->get()->toArray()
        ];
    }

    /**@author : dtphi .
     * @param $cateId
     */
    public static function fcDeleteByCateId($cateId)
    {
        DB::delete("delete from `" . Tables::$categorys . "` where category_id = '" . (int)$cateId . "'");
    }

    public static function insertForce(
        $cateId = null,
        $nameSlug = '',
        $parentId = null,
        $createUser = 0,
        $status = 1
    ) {
        $cateId   = (int)$cateId;
        $parentId = (int)$parentId;
        if ($parentId == -1) {
            $parentId = 0;
        }

        if ($cateId) {
            DB::insert('insert into ' . Tables::$categorys . ' (category_id, parent_id, status, name_slug, user_create) values (?, ?, ?, ?, ?)',
                [$cateId, $parentId, $status, $nameSlug, $createUser]);
        }
    }
}
