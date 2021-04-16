<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

class InformationToDownload extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX  . 'information_to_downloads';

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

    public static function insertByInfoId($infoId = null, $downloadId = null)
    {
        $infoId = (int)$infoId;
        $downloadId = (int)$downloadId;

        if ($infoId && $downloadId) {
            DB::insert('insert into ' . Tables::$information_to_downloads . ' (information_id, download_id) values (?, ?)', [
                $infoId, $downloadId
            ]);
        }
    }
}
