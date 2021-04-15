<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class CategoryPath extends BaseModel
{
    /**
     * table name .
     */
    protected $table = DB_PREFIX . 'category_paths';

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

    public function scopeGbByCategoryId($query)
    {
        return $query->groupBy($this->table . '.category_id');
    }

    public function scopeLjoinCategory($query, $alias = '')
    {
        if (empty($alias)) {
            $alias = Tables::$categorys;
        }
        return $query->leftJoin(Tables::$categorys . ' AS ' . $alias, $this->table . '.category_id', '=',
        $alias . '.category_id');
    }

    public function scopeLjoinCateDescription($query, $alias = '')
    {
        if (empty($alias)) {
            $alias = Tables::$category_descriptions;
        }
        return $query->leftJoin(Tables::$category_descriptions . ' AS ' . $alias, $this->table . '.path_id', '=',
        $alias . '.category_id');
    }

    public function scopeFilterLikeName($query, $alias = '', $name = '')
    {
        return $query->where($alias . '.name', 'LIKE', "%{$name}%");
    }

    public static function fcDeleteByCateId($cateId)
    {
        DB::delete("delete from `" . Tables::$category_paths . "` where category_id = '" . (int)$cateId . "'");
    }
}
