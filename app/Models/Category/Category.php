<?php

namespace App\Models\Category;

use App\Models\Attribute\AttributeGroup;
use App\Models\Product\Product;
use App\Models\TranslatedModel;
use App\Rules\UniqueTranslate;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
/**
 * Class Category
 * @package App\Models\Category
 * @version August 14, 2020, 3:57 am UTC
 *
 * @property integer $position
 * @property string $image
 * @property boolean $status
 */
class Category extends TranslatedModel 
{
    use SoftDeletes;
    
    public $table = 'categories';

    protected $with = ['translations'];

    const IMAGE_DISK = "public";
    const IMAGE_DIR = "categories";

    const IMAGE_WIDTH = 300;
    const IMAGE_HEIGHT = 300;

    const COLLECTION_TAG = 'categories';
    const CREATE_TAG = 'create-category';
    const SHOW_TAG = 'show-category';
    const EDIT_TAG = 'edit-category';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    public $translatedAttributes = [
        'name',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
    protected $fillable  = [
        'position',
        'image',
        'status',
    ];
    public function getFillable()
    {
        return $this->fillable;
    }
    // function getStatusAttribute ($value){
    //     if($value){
    //         return 'Active';
    //     }
    //     return 'Deactive';
    // }


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'position' => 'integer',
        'image' => 'string',
        'status' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'position' => 'required',
        'image' => 'image',
        'status' => 'required'
    ];
    public static function getAddRules()
    {
        return array_merge(
            self::$rules,
            RuleFactory::make([
                '%name%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'name')],
                '%description%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'description')],
                '%slug%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'slug')],
                '%meta_title%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'meta_title')],
                '%meta_description%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'meta_description')],
                '%meta_keywords%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'meta_keywords')],
            ])
        );
    }
    public static function getEditRules($categoryId)
    {
        return array_merge(
            self::$rules,
            RuleFactory::make([
                '%name%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'name', 'category_id', $categoryId)],
                '%description%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'description')],
                '%slug%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'slug')],
                '%meta_title%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'meta_title')],
                '%meta_description%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'meta_description')],
                '%meta_keywords%' => ['required', 'string', new UniqueTranslate(app(CategoryTranslation::class)->getTable(), 'meta_keywords')],
            ])
        );
    }
    protected $attributes  = [
        'image' => '',
        'position' => 0,
        'status' => true
    ];

    public function image_url()
    {
        if (!$this->image)
            return;

        return Storage::url($this->image);
    }

    public function getImageUrlAttribute()
    {
        return $this->image_url();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }
    public function attributeGroups()
    {
        return $this->belongsToMany(AttributeGroup::class, 'category_attribute_group');
    }

    // public function category_translations()
    // {
    //     return $this->translations();
    // }

    public function scopeStatus(Builder $query,$status) : Builder
    {
        return $query->where('status', $status);
    }
    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')
    //           ->width(50)
    //           ->height(50)
    //           ->sharpen(10);
    // }

}
