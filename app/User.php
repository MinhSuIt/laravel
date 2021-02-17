<?php

namespace App;

use App\Rules\UniqueTranslate;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    const COLLECTION_TAG = 'users';
    const CREATE_TAG = 'create-user';
    const SHOW_TAG = 'show-user';
    const EDIT_TAG = 'edit-user';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public function setPasswordAttribute($password)
    // {
    //     return Hash::make($password);
    // }

        // Rest omitted for brevity

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
    public static $rules = [
        'name'                  => 'required',
        'email'                 => 'required|email|unique:users,email',
        'password'              => 'required|confirmed'
    ];
    public static function getAddRules()
    {
        return array_merge(
            self::$rules,[

            ]
        );
    }
    public static function getEditRules($id)
    {
        return array_merge(
            self::$rules,[
                'email'    => 'required|email|unique:users,email,'.$id,
                'password' => 'confirmed'
            ]
        );
    }
}
