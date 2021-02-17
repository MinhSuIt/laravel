<?php

namespace App\Models\Attribute;

use App\Models\TranslatedModel;
use App\Rules\UniqueTranslate;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Validation\RuleFactory;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attribute
 * @package App\Models\Attribute
 * @version August 25, 2020, 9:05 am UTC
 *
 * @property string $status
 */
class Attribute extends TranslatedModel
{
    use SoftDeletes;
    public $table = 'attributes';

    const COLLECTION_TAG = 'attributes';
    const CREATE_TAG = 'create-attribute';
    const SHOW_TAG = 'show-attribute';
    const EDIT_TAG = 'edit-attribute';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    protected $with = ['translations'];


    public $translatedAttributes = [
        'name',
    ];

    protected $dates = ['deleted_at'];

    

    public $fillable = [
        'status',
        'attribute_group_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'string',
        'attribute_group_id'=>'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'status' => 'required'
    ];
    public static function getAddRules()
    {
        return array_merge(
            self::$rules,
            RuleFactory::make([
                '%name%' => ['required', 'string', new UniqueTranslate(app(AttributeTranslation::class)->getTable(), 'name')],
            ])
        );
    }
    public static function getEditRules($modelId)
    {
        return array_merge(
            self::$rules,
            RuleFactory::make([
                '%name%' => ['required', 'string', new UniqueTranslate(app(AttributeTranslation::class)->getTable(), 'name', 'attribute_id', $modelId)],
            ])
        );
    }
    public function options()
    {
        return $this->hasMany(AttributeOption::class);
    }
    public function attributeGroup()
    {
        return $this->belongsTo(AttributeGroup::class);
    }
}
