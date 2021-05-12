<?php

namespace App\Models;

use App\Http\Controllers\Api\Admin\Services\ScopeService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use HasFactory, ScopeService;

    public function scopeOrderBySortAsc($query, $value = '')
    {
        return $query->orderBy('sort', 'ASC');
    }
}
