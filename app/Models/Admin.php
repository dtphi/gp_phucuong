<?php

namespace App\Models;

use App\Http\Controllers\Api\Admin\Services\ScopeService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use App\Models\PersonalAccessToken;
use Str;
use Auth;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ScopeService;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
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

    public function createToken(string $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->updateOrCreate([
            'name' => $name],[
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
        ]);

        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }

    public function actionCan($name, $ability)
    {
        $accessToken = PersonalAccessToken::where('tokenable_id', Auth::user()->id)->where('name', $name)->first();

        return Auth::user()->withAccessToken($accessToken)->tokenCan($ability);
    }
}
