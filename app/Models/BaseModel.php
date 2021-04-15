<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\Api\Admin\Services\ScopeService;

abstract class BaseModel extends Model
{
    use HasFactory, ScopeService;

    public function scopeOrderBySortAsc($query, $value='')
    {
    	return $query->orderBy('sort', 'ASC');
    }
}
