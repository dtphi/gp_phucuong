<?php

namespace App\Models;

use App\Helpers\Constants;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Representative
 *
 * @package App\Models
 */
class Representative extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_representatives';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_number',
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'phone_number',
        'main_email',
        'sub_email1',
        'sub_email2',
        'sub_email3',
        'sub_email4',
        'password',
        'reissued_at',
        'password_last_changed_at',
        'last_logged_in_at'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [ 'representatives' ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name',
        'full_name_kana',
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
     * Get full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->last_name . '　' . $this->first_name;
    }

    /**
     * Get full name kana.
     *
     * @return string
     */
    public function getFullNameKanaAttribute()
    {
        return $this->last_name_kana . '　' . $this->first_name_kana;
    }

    /**
     * Get all sales representatives.
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function getRepresentatives(array $data)
    {
        $query = self::select();

        if (isset($data['search'])) {
            $query->where(function($query) use ($data) {
                $query->where('employee_number', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('last_name', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('first_name', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere(DB::raw('CONCAT(last_name, " ", first_name)'), 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere(DB::raw('CONCAT(last_name, "　", first_name)'), 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('last_name_kana', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('first_name_kana', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere(DB::raw('CONCAT(last_name_kana, " ", first_name_kana)'), 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere(DB::raw('CONCAT(last_name_kana, "　", first_name_kana)'), 'LIKE', '%' . $data['search'] . '%');
            });
        }
        $query->whereNull('deleted_at')
              ->orderBy($data['sort'], $data['direction']);

        return [
            'total' => $query->count(),
            'data'  => $query->offset(Constants::REPRESENTATIVES_PER_PAGE * ($data['page'] - 1))
                             ->limit(Constants::REPRESENTATIVES_PER_PAGE)
                             ->get()
                             ->toArray()
        ];
    }

    /**
     * Get sale representative by id.
     *
     * @param int  $id
     * @param bool $includeDeleted
     *
     * @return mixed
     */
    public static function getRepresentativeById(int $id, bool $includeDeleted = false)
    {
        $query = self::where('id', $id);

        if (!$includeDeleted) {
            $query->whereNull('deleted_at');
        }
        return $query->first();
    }

    /**
     * Get sale representative by employee number.
     *
     * @param $number
     *
     * @return mixed
     */
    public static function getRepresentativeByEmployeeNumber($number)
    {
        return self::where('employee_number', $number)->whereNull('deleted_at')->first();
    }

    /**
     * Get sale representative by main email.
     *
     * @param      $email
     * @param bool $includeDeleted
     *
     * @return mixed
     */
    public static function getRepresentativeByMainEmail($email, bool $includeDeleted = false)
    {
        $query = self::where('main_email', $email);

        if (!$includeDeleted) {
            $query->whereNull('deleted_at');
        }
        return $query->first();
    }

    /**
     * Check employee number exists.
     *
     * @param      $number
     * @param null $id
     *
     * @return mixed
     */
    public static function checkEmployeeNumberExists($number, $id = null)
    {
        $query = self::where('employee_number', $number);

        if ($id) {
            $query->where('id', '!=', $id);
        }
        return $query->exists();
    }

    /**
     * Check main email exists.
     *
     * @param      $email
     * @param null $id
     *
     * @return mixed
     */
    public static function checkMainEmailExists($email, $id = null)
    {
        $query = self::where('main_email', $email);

        if ($id) {
            $query->where('id', '!=', $id);
        }
        return $query->exists();
    }

    /**
     * Create new sale representative.
     *
     * @param array $request
     */
    public static function createRepresentative(array $request)
    {
        $now = Carbon::now();
        $data = [
            'employee_number' => $request['employee_number'],
            'last_name'       => $request['last_name'],
            'first_name'      => $request['first_name'],
            'last_name_kana'  => $request['last_name_kana'],
            'first_name_kana' => $request['first_name_kana'],
            'phone_number'    => $request['phone_number'],
            'main_email'      => $request['main_email'],
            'sub_email1'      => $request['sub_email1'],
            'sub_email2'      => $request['sub_email2'],
            'sub_email3'      => $request['sub_email3'],
            'sub_email4'      => $request['sub_email4'],
            'password'        => Hash::make($request['password']),
            'created_at'      => $now,
            'updated_at'      => $now
        ];
        self::insert($data);
    }

    /**
     * Update sale representative.
     *
     * @param array $request
     */
    public static function updateRepresentative(array $request)
    {
        $data = [
            'employee_number' => $request['employee_number'],
            'last_name'       => $request['last_name'],
            'first_name'      => $request['first_name'],
            'last_name_kana'  => $request['last_name_kana'],
            'first_name_kana' => $request['first_name_kana'],
            'phone_number'    => $request['phone_number'],
            'main_email'      => $request['main_email'],
            'sub_email1'      => $request['sub_email1'],
            'sub_email2'      => $request['sub_email2'],
            'sub_email3'      => $request['sub_email3'],
            'sub_email4'      => $request['sub_email4'],
            'updated_at'      => Carbon::now()
        ];
        self::where('id', $request['id'])->update($data);
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

    /**
     * Reset password for sale representative.
     *
     * @param array $request
     */
    public static function resetPassword(array $request)
    {
        $now = Carbon::now();
        $data = [
            'password'                 => Hash::make($request['password']),
            'reissued_at'              => $now,
            'password_last_changed_at' => $now,
            'updated_at'               => $now
        ];
        self::where('id', $request['id'])->update($data);
    }

    /**
     * Delete sale representative.
     *
     * @param array $request
     */
    public static function deleteRepresentative(array $request)
    {
        $data = [
            'employee_number' => $request['employee_number'],
            'main_email'      => $request['main_email'],
            'deleted_at'      => Carbon::now()
        ];
        self::where('id', $request['id'])->update($data);
    }
}
