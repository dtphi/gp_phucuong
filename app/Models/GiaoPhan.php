<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaoPhan extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'giaophans';

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'khaiquat',
        'active',
        'sort_id',
        'updateuser',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'tag'
    ];

    public function getKhaiquatAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }

}
