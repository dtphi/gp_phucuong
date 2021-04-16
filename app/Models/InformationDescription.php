<?php

namespace App\Models;

use App\Http\Common\Tables;
use DB;

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

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'tag',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];

    public static function insertByInfoId($infoId = null, $name = '', $description = '', $tag = '', $metaTitle = '', $metaDescription = '', $metaKeyword = '')
    {
        $infoId = (int)$infoId;

        if ($infoId && !empty($name) && !empty($metaTitle)) {
            DB::insert('insert into ' . Tables::$information_descriptions . ' (information_id, name, description, tag, meta_title, meta_description, meta_keyword) values (?, ?, ?, ?, ?, ?, ?)', [
                $infoId, $name, $description, $tag, $metaTitle, $metaDescription, $metaKeyword
            ]);
        }
    }
}
