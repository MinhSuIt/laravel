<?php

namespace App\Models\Customer;

use App\Models\Cart\Cart;
use App\Models\Cart\Order;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Customer
 * @package App\Models\Customer
 * @version September 11, 2020, 2:52 pm UTC
 *
 * @property string $name
 * @property string $email
 * @property string $password
 * @property boolean $status
 * @property string $token
 * @property string $remember_token
 */
class Customer extends Authenticatable implements JWTSubject
{
    use SoftDeletes;
    use Notifiable;

    public $table = 'customers';

    const COLLECTION_TAG = 'customers';
    const CREATE_TAG = 'create-customer';
    const SHOW_TAG = 'show-customer';
    const EDIT_TAG = 'edit-customer';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'email',
        'password',
        'status',
        // 'token',
        // 'remember_token',
        'customer_group_id'
    ];

    protected $attributes = [
        'token' => false,
        'remember_token' => '',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'status' => 'boolean',
        'token' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required|unique:customers',
        'password' => 'required',
        'status' => 'required',
        //     'token' => 'required',
        //     'remember_token' => 'required'
    ];


    public static function getAddRules()
    {
        return array_merge(
            self::$rules,
            [

            ]
        );
    }
    public static function getEditRules($id)
    {
        return array_merge(
            self::$rules,
            [
                'email' => 'required|unique:customers,email,'.$id,
            ]
        );
    }
    public function customerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }
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
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    private function profileIsComplete(): bool
    {
        return $this->email && $this->name && $this->phoneNumber && $this->address;
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
