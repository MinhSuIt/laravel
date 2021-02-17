<?php

namespace App\Models\Attribute;

use App\Library\QueryBuilder;
use App\Models\Category\Category;
use App\Models\TranslatedModel;
use App\Rules\UniqueTranslate;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Validation\RuleFactory;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Class AttributeGroup
 * @package App\Models\Attribute
 * @version August 25, 2020, 9:01 am UTC
 *
 * @property string $status
 */
class AttributeGroup extends TranslatedModel
{
    use SoftDeletes;
    public $table = 'attribute_groups';

    const COLLECTION_TAG = 'attribute_groups';
    const CREATE_TAG = 'create-attribute_group';
    const SHOW_TAG = 'show-attribute_group';
    const EDIT_TAG = 'edit-attribute_group';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    protected $with = ['translations'];
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'status' => 'required'
    ];

    public $translatedAttributes = [
        'name',
    ];
    public static function getAddRules()
    {
        return array_merge(
            self::$rules,
            RuleFactory::make([
                '%name%' => ['required', 'string', new UniqueTranslate(app(AttributeGroupTranslation::class)->getTable(), 'name')],
            ])
        );
    }
    public static function getEditRules($modelId)
    {
        return array_merge(
            self::$rules,
            RuleFactory::make([
                '%name%' => ['required', 'string', new UniqueTranslate(app(AttributeGroupTranslation::class)->getTable(), 'name', 'attribute_group_id', $modelId)],
            ])
        );
    }
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_attribute_group');
    }
}
