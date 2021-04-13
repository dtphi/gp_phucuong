<?php

namespace App\Models;

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
}