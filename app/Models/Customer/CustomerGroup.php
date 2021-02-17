<?php

namespace App\Models\Customer;

use App\Models\TranslatedModel;
use App\Rules\UniqueTranslate;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CustomerGroup
 * @package App\Models\Customer
 * @version September 11, 2020, 2:56 pm UTC
 *
 * @property integer $sort_order
 */
class CustomerGroup extends TranslatedModel
{
    use SoftDeletes;

    public $table = 'customer_groups';

    const COLLECTION_TAG = 'customer_groups';
    const CREATE_TAG = 'create-customer_group';
    const SHOW_TAG = 'show-customer_group';
    const EDIT_TAG = 'edit-customer_group';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'sort_order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sort_order' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'sort_order' => 'required'
    ];
    public $translatedAttributes = [
        'descriptions',
        'name',
    ];
    public static function getAddRules()
    {
        return array_merge(
            self::$rules,
            RuleFactory::make([
                '%name%' => ['required', 'string', new UniqueTranslate(app(CustomerGroupTranslation::class)->getTable(), 'name')],
                '%descriptions%' => ['required', 'string', new UniqueTranslate(app(CustomerGroupTranslation::class)->getTable(), 'descriptions')],
            ])
        );
    }
    public static function getEditRules($categoryId)
    {
        return array_merge(
            self::$rules,
            RuleFactory::make([
                '%name%' => ['required', 'string', new UniqueTranslate(app(CustomerGroupTranslation::class)->getTable(), 'name', 'customer_group_id', $categoryId)],
                '%descriptions%' => ['required', 'string', new UniqueTranslate(app(CustomerGroupTranslation::class)->getTable(), 'descriptions')],
            ])
        );
    }
}
