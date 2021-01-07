<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Admin
 *
 * @package App\Models
 */
class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_logged_in_at'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [ 'admins' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get admin by email.
     *
     * @param string $email
     * @param bool   $includeDeleted
     *
     * @return mixed
     */
    public static function getAdminByEmail(string $email = '', bool $includeDeleted = false)
    {
        if (empty($email)) {
            return self::whereNull('deleted_at')->first();
        }
        $query = self::where('email', $email);

        if (!$includeDeleted) {
            $query->whereNull('deleted_at');
        }
        return $query->first();
    }

    /**
     * Update last logged in.
     *
     * @param int $id
     */
    public static function updateLastLoggedIn(int $id)
    {
        self::where('id', $id)->update([ 'last_logged_in_at' => Carbon::now() ]);
    }
}
