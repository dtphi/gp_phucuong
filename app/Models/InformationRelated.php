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
}
