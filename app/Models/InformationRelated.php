<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class InformationRelated extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX  . 'information_relateds';

    /**
     * @var string
     */
    protected $primaryKey = ['information_id', 'related_id'];

    public $timestamps = false;

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'information_id',
        'related_id'
    ];

    public function getRelatedIdAttribute($value) {
        return (int)$value;
    }

    public static function fcDeleteByInfoAndRelatedId($infoId = null, $relatedId = null)
    {
        $infoId = (int)$infoId;
        $relatedId = (int)$relatedId;
        
        if ($infoId && $relatedId) {
            return DB::delete("delete from `" . Tables::$information_relateds . "` where " . Tables::$information_relateds . ".information_id = '" . $infoId .  "' and " . Tables::$information_relateds . ".related_id = '" . $relatedId . "'");
        }
    }

    public static function insertByInfoId($infoId = null, $relatedId = null)
    {
        $infoId = (int)$infoId;
        $relatedId = (int)$relatedId;

        if ($infoId && !empty($relatedId)) {
            DB::insert('insert into ' . Tables::$information_relateds . ' (information_id, related_id) values (?, ?)', [
                $infoId, $relatedId
            ]);
        }
    }
}
