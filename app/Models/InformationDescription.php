<?php

namespace App\Models;

class InformationDescription extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX  . 'information_descriptions';

    /**
     * @var string
     */
    protected $primaryKey = 'infomation_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'infomation_id',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];
}
