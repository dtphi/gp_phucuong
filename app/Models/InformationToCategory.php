<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class InformationToCategory extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX  . 'information_to_categorys';

    /**
     * @var string
     */
    protected $primaryKey = ['infomation_id', 'category_id'];

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
        'infomation_id',
        'category_id'
    ];

    public static function fcDeleteByCateId($cateId = null)
    {
        $cateId = (int)$cateId;
        
        if ($cateId) {
            return DB::delete("delete from `" . Tables::$information_to_categorys . "` where category_id = '" . $cateId . "'");
        }
    }

    public static function insertByInfoId($infoId = null, $cateId = null)
    {
        $infoId = (int)$infoId;
        $cateId = (int)$cateId;

        if ($infoId && $cateId) {
            DB::insert('insert into ' . Tables::$information_to_categorys . ' (information_id, category_id) values (?, ?)', [
                $infoId, $cateId
            ]);
        }
    }
}
