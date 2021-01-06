<?php

namespace App\Http\LcgServices\LcgModels;

use Illuminate\Database\Eloquent\Model;

class LcgMember extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @author : Phi .
     * @param $query
     * @return mixed
     */
    public function scopeOrderByCreatedAtDesc($query)
    {
        return $query->orderBy($this->table . '.created_at', 'DESC');
    }
}
