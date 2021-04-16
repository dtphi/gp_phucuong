<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class InformationToDownload extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'information_to_downloads';

    /**
     * @var string
     */
    protected $primaryKey = ['infomation_id', 'download_id'];

    public $timestamps = false;

    //public $incrementing = false;

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'infomation_id',
        'download_id'
    ];

    public function getDownloadIdAttribute($value)
    {
        return $value;
    }

    public static function insertByInfoId($infoId = null, $downloadId = null)
    {
        $infoId     = (int)$infoId;
        $downloadId = (int)$downloadId;

        if ($infoId && $downloadId) {
            DB::insert('insert into ' . Tables::$information_to_downloads . ' (information_id, download_id) values (?, ?)',
                [
                    $infoId,
                    $downloadId
                ]);
        }
    }

    public static function fcDeleteByInfoId($infoId = null)
    {
        $infoId = (int)$infoId;

        if ($infoId) {
            return DB::delete("delete from " . Tables::$information_to_downloads . " where information_id = '" . $infoId . "'");
        }
    }
}
