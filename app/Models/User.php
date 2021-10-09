<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public $timestamps = false;
    
    protected $fillable = [
        // 'name',
        'email',
        'password',
    ];

     protected $hidden = [
        'password',       
    ];

    //  protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    } 
}
