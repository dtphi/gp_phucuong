<?php

namespace App\Models;

class InformationRelated extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX  . 'information_relateds';

    /**
     * @var string
     */
    protected $primaryKey = ['infomation_id', 'related_id'];

    public $timestamps = false;

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'infomation_id',
        'related_id'
    ];
}
