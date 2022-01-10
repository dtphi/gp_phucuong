<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends BaseModel
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = DB_PREFIX . 'tags';

    /**
     * Filter .
     */
    protected $fillable = [
      'name',
      'name_slug',
      'active',
      'update_user',
    ];
}
