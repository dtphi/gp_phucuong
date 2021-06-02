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

    public static function truncateForce()
    {
        DB::statement('truncate table ' . Tables::$categorys);
    }

    public function scopeFilterParentId($query, $parentId = 0)
    {
        $query->where($this->table . '.parent_id', (int)$parentId);

        return $query;
    }

    public function scopeFilterActiveStatus($query)
    {
        $query->where($this->table . '.status', Tables::$infoStatusActive);

        return $query;
    }

    public function scopeOrderByAscSort($query)
    {
        $query->orderBy($this->table . '.sort_order', 'asc');

        return $query;
    }

    public function scopeOrderByAscParentId($query)
    {
        $query->orderBy($this->table . '.parent_id', 'asc');

        return $query;
    }

    public function scopeFilterById($query, $categoryId)
    {
        $query->where($this->table . '.category_id', (int)$categoryId);

        return $query;
    }

    public function scopeFilterLayoutId($query, $layoutId)
    {
        $query->where(Tables::$category_to_layouts . '.layout_id', (int)$layoutId);

        return $query;
    }

    public function scopeLfJoinDescription($query)
    {
        $query->leftJoin(Tables::$category_descriptions, $this->table . '.category_id',
        '=', Tables::$category_descriptions . '.category_id');

        return $query;
    }

    public function scopeLfJoinToLayout($query)
    {
        $query->leftJoin(Tables::$category_to_layouts, $this->table . '.category_id',
        '=', Tables::$category_to_layouts . '.category_id');

        return $query;
    }
}
