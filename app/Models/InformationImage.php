<?php

namespace App\Models;

class InformationImage extends BaseModel
{
    /**
     * @var string
     */
    protected $table = DB_PREFIX  . 'information_images';

    /**
     * @var string
     */
    protected $primaryKey = 'infomation_image_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'infomation_id',
        'image',
        'sort_order'
    ];
}
