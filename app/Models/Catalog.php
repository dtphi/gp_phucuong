<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Catalog
 *
 * @package App\Models
 */
class Catalog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'online_catalogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manufacturer_name',
        'manufacturer_image',
        'url'
    ];
}
