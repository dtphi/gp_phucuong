<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tacgias extends BaseModel
{
    use HasFactory;

    protected $table =DB_PREFIX. 'tacgias';

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'deleted_at',
      ];
}
