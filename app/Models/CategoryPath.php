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
     * @var string
     */
    public static $separate = ' >> ';

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'path_id',
        'level'
    ];

    /**
     * @author : dtphi .
     * @param $query
     * @return mixed
     */
    public function scopeGbByCategoryId($query)
    {
        return $query->groupBy($this->table . '.category_id');
    }

    /**
     * @author : dtphi .
     * @param $query
     * @param string $alias
     * @return mixed
     */
    public function scopeLjoinCategory($query, $alias = '')
    {
        if (empty($alias)) {
            $alias = Tables::$categorys;
        }

        return $query->leftJoin(Tables::$categorys . ' AS ' . $alias, $this->table . '.category_id', '=',
            $alias . '.category_id');
    }

    /**
     * @author : dtphi .
     * @param $query
     * @param string $alias
     * @return mixed
     */
    public function scopeLjoinCateDescription($query, $alias = '')
    {
        if (empty($alias)) {
            $alias = Tables::$category_descriptions;
        }

        return $query->leftJoin(Tables::$category_descriptions . ' AS ' . $alias, $this->table . '.path_id', '=',
            $alias . '.category_id');
    }

    /**
     * @author : dtphi .
     * @param $query
     * @param string $alias
     * @param string $name
     * @return mixed
     */
    public function scopeFilterLikeName($query, $alias = '', $name = '')
    {
        return $query->where($alias . '.name', 'LIKE', "%{$name}%");
    }

    /**
     * @author : dtphi .
     * @param null $cateId
     * @return mixed
     */
    public static function fcDeleteByCateId($cateId = null)
    {
        if ($cateId) {
            return DB::delete("delete from `" . Tables::$category_paths . "` where " . Tables::$category_paths . ".category_id = '" . (int)$cateId . "'");
        }
    }

    /**
     * @author : dtphi .
     * @param null $cateId
     * @param int $level
     * @return mixed
     */
    public static function fcDeleteByCateIdAndLevelDown($cateId = null, $level = 0)
    {
        if ($cateId) {
            return DB::delete("delete from `" . Tables::$category_paths . "` where " . Tables::$category_paths . ".category_id = '" . (int)$cateId . "' AND " . Tables::$category_paths . ".level < '" . (int)$level . "'");
        }
    }

    /**
     * @author : dtphi .
     * @param null $cateId
     * @param null $pathId
     * @param int $level
     * @return mixed
     */
    public static function replaceByCateidAndPathAndLevel($cateId = null, $pathId = null, $level = 0)
    {
        if ($cateId && $pathId) {
            return DB::statement("REPLACE INTO `" . Tables::$category_paths . "` SET " . Tables::$category_paths . ".category_id = '" . (int)$cateId . "', " . Tables::$category_paths . ".path_id = '" . (int)$pathId . "', " . Tables::$category_paths . ".level = '" . (int)$level . "'");
        }
    }

    /**
     * @author : dtphi .
     * @param string $tbContainNameAlias
     * @param string $rawAlias
     * @return mixed
     */
    public static function getRawCategoryName($tbContainNameAlias = '', $rawAlias = 'name')
    {
        if (empty($tbContainNameAlias)) {
            $tbContainNameAlias = Tables::$category_descriptions;
        }

        return DB::raw("group_concat(" . $tbContainNameAlias . ".`name` ORDER BY " . Tables::$category_paths . ".level SEPARATOR '" . self::$separate . "') AS " . $rawAlias);
    }

    /**
     * @author : dtphi .
     * @param null $cateId
     * @param null $pathId
     * @param int $level
     * @return mixed
     */
    public static function insertByCateId($cateId = null, $pathId = null, $level = 0)
    {
        $cateId = (int)$cateId;
        $pathId = (int)$pathId;
        $level  = (int)$level;

        if ($cateId && $pathId) {
            return DB::insert('insert into ' . Tables::$category_paths . ' (category_id, path_id, level) values (?, ?, ?)',
                [$cateId, $pathId, $level]);
        }
    }

    public function getQueryCategories($data = array())
    {
        $cate1 = 'cate1';
        $cate2 = 'cate2';
        $cd1   = 'cd1';
        $cd2   = 'cd2';

        $query = $this->select(Tables::$category_paths . '.category_id AS category_id', $cate1 . '.parent_id',
            $cate1 . '.sort_order', self::getRawCategoryName($cd1))
            ->gbByCategoryId()
            ->ljoinCategory($cate1)
            ->ljoinCategory($cate2)
            ->ljoinCateDescription($cd1)
            ->ljoinCateDescription($cd2);

        return $query;
    }
}
