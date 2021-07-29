<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSubscribe extends Model
{
    use HasFactory;

    protected $table = DB_PREFIX . 'subscribes';

    /**
     * @var string
     */
    protected $primaryKey = 'subscribe_id';


    protected $fillable = [
        'email'
    ];
}
