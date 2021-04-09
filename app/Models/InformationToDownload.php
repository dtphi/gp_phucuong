<?php

namespace App\Models;

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
}
