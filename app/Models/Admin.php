<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * @author : dtphi .
     * @param $pass
     * @return string
     */
    public function setPasswordAttribute($pass)
    {
        $bcrypt_password = Hash::make($pass);

        $this->attributes['password'] = $bcrypt_password;

        return $bcrypt_password;
    }

    /**
     * @author : dtphi .
     * @param $query
     * @return mixed
     */
    public function scopeOrderByDescById($query)
    {
        return $query->orderByDesc('id');
    }
}
