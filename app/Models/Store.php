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
 * Class Store
 *
 * @package App\Models
 */
class Store extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_rep_id',
        'code',
        'name',
        'rep_last_name',
        'rep_first_name',
        'rep_last_name_kana',
        'rep_first_name_kana',
        'phone_number',
        'fax_number',
        'address',
        'main_email',
        'sub_email1',
        'sub_email2',
        'sub_email3',
        'sub_email4',
        'memo',
        'password',
        'requested_reissuance_at',
        'reissued_at',
        'password_last_changed_at',
        'last_logged_in_at'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [ 'stores' ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'rep_full_name',
        'rep_full_name_kana',
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
     * Get the representative that owns the store.
     */
    public function representative()
    {
        return $this->belongsTo(Representative::class, 'sale_rep_id', 'id');
    }

    /**
     * Get full name of representative.
     *
     * @return string
     */
    public function getRepFullNameAttribute()
    {
        switch (true) {
            case $this->rep_last_name && !$this->rep_first_name:
                return $this->rep_last_name;
            case !$this->rep_last_name && $this->rep_first_name:
                return $this->rep_first_name;
            case $this->rep_last_name && $this->rep_first_name:
                return $this->rep_last_name . '　' . $this->rep_first_name;
            default:
                return null;
        }
    }

    /**
     * Get full name kana of representative.
     *
     * @return string
     */
    public function getRepFullNameKanaAttribute()
    {
        switch (true) {
            case $this->rep_last_name_kana && !$this->rep_first_name_kana:
                return $this->rep_last_name_kana;
            case !$this->rep_last_name_kana && $this->rep_first_name_kana:
                return $this->rep_first_name_kana;
            case $this->rep_last_name_kana && $this->rep_first_name_kana:
                return $this->rep_last_name_kana . '　' . $this->rep_first_name_kana;
            default:
                return null;
        }
    }

    /**
     * Get all stores.
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function getStores(array $data)
    {
        $subQuery = <<<EOT
            (CASE
                WHEN sales_representatives.deleted_at IS NULL THEN CONCAT(sales_representatives.employee_number, '　', sales_representatives.last_name, '　', sales_representatives.first_name)
                ELSE ''
            END) AS sale_person
EOT;

        $query = self::select([
                                  'stores.id',
                                  'stores.code',
                                  'stores.name',
                                  DB::raw($subQuery)
                              ])
                     ->join('sales_representatives', 'stores.sale_rep_id', '=', 'sales_representatives.id');

        if (isset($data['search'])) {
            $query->where(function($query) use ($data) {
                $query->where('stores.code', 'LIKE', '%' . strtoupper($data['search']) . '%')
                      ->orWhere('stores.name', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('sales_representatives.employee_number', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('sales_representatives.last_name', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('sales_representatives.first_name', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere(DB::raw('CONCAT(sales_representatives.last_name, " ", sales_representatives.first_name)'), 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere(DB::raw('CONCAT(sales_representatives.last_name, "　", sales_representatives.first_name)'), 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('sales_representatives.last_name_kana', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('sales_representatives.first_name_kana', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere(DB::raw('CONCAT(sales_representatives.last_name_kana, " ", sales_representatives.first_name_kana)'), 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere(DB::raw('CONCAT(sales_representatives.last_name_kana, "　", sales_representatives.first_name_kana)'), 'LIKE', '%' . $data['search'] . '%');
            });
        }
        $query->whereNull('stores.deleted_at')
              ->orderBy($data['sort'], $data['direction']);

        return [
            'total' => $query->count(),
            'data'  => $query->offset(Constants::STORES_PER_PAGE * ($data['page'] - 1))
                             ->limit(Constants::STORES_PER_PAGE)
                             ->get()
                             ->toArray()
        ];
    }

    /**
     * Get store by id.
     *
     * @param      $id
     * @param bool $includeDeleted
     *
     * @return mixed
     */
    public static function getStoreById($id, bool $includeDeleted = false)
    {
        $query = self::where('id', $id);

        if (!$includeDeleted) {
            $query->whereNull('deleted_at');
        }
        return $query->first();
    }

    /**
     * Get store by code.
     *
     * @param      $code
     * @param bool $includeDeleted
     *
     * @return mixed
     */
    public static function getStoreByCode($code, bool $includeDeleted = false)
    {
        $query = self::where('code', $code);

        if (!$includeDeleted) {
            $query->whereNull('deleted_at');
        }
        return $query->first();
    }

    /**
     * Get all dealers by sale representative id
     *
     * @param int $representativeId
     *
     * @return mixed
     */
    public static function getDealers(int $representativeId)
    {
        return self::where('sale_rep_id', $representativeId)
                   ->whereNull('deleted_at')
                   ->get()
                   ->toArray();
    }

    /**
     * Check code exists.
     *
     * @param      $code
     * @param null $id
     *
     * @return mixed
     */
    public static function checkCodeExists($code, $id = null)
    {
        $query = self::where('code', strtoupper($code));

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
     * Create new store.
     *
     * @param array $request
     *
     * @return mixed
     */
    public static function createStore(array $request)
    {
        $now = Carbon::now();
        $data = [
            'sale_rep_id'         => $request['sale_rep_id'],
            'code'                => strtoupper($request['code']),
            'name'                => $request['name'],
            'rep_last_name'       => $request['rep_last_name'],
            'rep_first_name'      => $request['rep_first_name'],
            'rep_last_name_kana'  => $request['rep_last_name_kana'],
            'rep_first_name_kana' => $request['rep_first_name_kana'],
            'phone_number'        => $request['phone_number'],
            'fax_number'          => $request['fax_number'],
            'address'             => $request['address'],
            'main_email'          => $request['main_email'],
            'sub_email1'          => $request['sub_email1'],
            'sub_email2'          => $request['sub_email2'],
            'sub_email3'          => $request['sub_email3'],
            'sub_email4'          => $request['sub_email4'],
            'memo'                => $request['memo'],
            'password'            => Hash::make($request['password']),
            'created_at'          => $now,
            'updated_at'          => $now
        ];
        return self::insertGetId($data);
    }

    /**
     * Update store.
     *
     * @param array $request
     */
    public static function updateStore(array $request)
    {
        $data = [
            'sale_rep_id'         => $request['sale_rep_id'],
            'code'                => strtoupper($request['code']),
            'name'                => $request['name'],
            'rep_last_name'       => $request['rep_last_name'],
            'rep_first_name'      => $request['rep_first_name'],
            'rep_last_name_kana'  => $request['rep_last_name_kana'],
            'rep_first_name_kana' => $request['rep_first_name_kana'],
            'phone_number'        => $request['phone_number'],
            'fax_number'          => $request['fax_number'],
            'address'             => $request['address'],
            'main_email'          => $request['main_email'],
            'sub_email1'          => $request['sub_email1'],
            'sub_email2'          => $request['sub_email2'],
            'sub_email3'          => $request['sub_email3'],
            'sub_email4'          => $request['sub_email4'],
            'memo'                => $request['memo'],
            'updated_at'          => Carbon::now()
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
     * Cancel reset password for store.
     *
     * @param int $id
     */
    public static function cancelResetPassword(int $id)
    {
        $data = [
            'requested_reissuance_at' => null,
            'updated_at'              => Carbon::now()
        ];
        self::where('id', $id)->update($data);
    }

    /**
     * Reset password for store.
     *
     * @param array $request
     */
    public static function resetPassword(array $request)
    {
        $now = Carbon::now();
        $data = [
            'password'                 => Hash::make($request['password']),
            'requested_reissuance_at'  => null,
            'reissued_at'              => $now,
            'password_last_changed_at' => $now,
            'updated_at'               => $now
        ];
        self::where('id', $request['id'])->update($data);
    }

    /**
     * Delete store.
     *
     * @param array $request
     */
    public static function deleteStore(array $request)
    {
        $data = [
            'code'       => $request['code'],
            'main_email' => $request['main_email'],
            'deleted_at' => Carbon::now()
        ];
        self::where('id', $request['id'])->update($data);
    }
}
