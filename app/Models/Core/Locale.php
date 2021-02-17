<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Locale
 * @package App\Models\Core
 * @version August 19, 2020, 12:26 pm UTC
 *
 * @property string $code
 * @property string $name
 * @property string $direction
 */
class Locale extends Model
{
    // use SoftDeletes;

    public $table = 'locales';

    const COLLECTION_TAG = 'locales';
    const CREATE_TAG = 'create-locale';
    const SHOW_TAG = 'show-locale';
    const EDIT_TAG = 'edit-locale';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    // protected $dates = ['deleted_at'];



    public $fillable = [
        'code',
        'name',
        'direction'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'direction' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required|unique:locales',
        'name' => 'required|unique:locales',
        'direction' => 'required'
    ];
    public static function getAddRules()
    {
        return array_merge(
            self::$rules,
            []
        );
    }
    public static function getEditRules($productId)
    {
        return array_merge(
            self::$rules,
            [
                'code' => 'required|unique:locales,code,'.$productId,
                'name' => 'required|unique:locales,name,'.$productId,
            ]
        );
    }
}
