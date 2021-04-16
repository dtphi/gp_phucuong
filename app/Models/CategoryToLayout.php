<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class CategoryToLayout extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX  . 'category_to_layouts';

    /**
     * @var string
     */
    protected $primaryKey = ['category_id', 'layout_id'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    //public $incrementing = false;

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'layout_id'
    ];

    public static function fcDeleteByCateId($cateId = null)
    {
        $cateId = (int)$cateId;

        if ($cateId) {
            return DB::delete("delete from `" . Tables::$category_to_layouts . "` where " . Tables::$category_to_layouts . ".category_id = '" . $cateId . "'");
        }
    }

        public static function insertByCateId($cateId = null, $layoutId = null)
        {
            $cateId = (int)$cateId;
            $layoutId = (int)$layoutId;

            if ($cateId && $layoutId) {
                return DB::insert('insert into ' . Tables::$category_to_layouts . ' (category_id, layout_id) values (?, ?)', [$cateId, $layoutId]);
            }

        }
}
