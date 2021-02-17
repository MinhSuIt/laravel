<?php

namespace App\Models\Product;

use App\Helper\ImageHelper;
use App\Library\QueryBuilder;
use App\Library\Traits\ContentHasImage;
use App\Library\Traits\IContentHasImage;
use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeOption;
use App\Models\Cart\CartItem;
use App\Models\Category\Category;
use App\Models\TranslatedModel;
use App\Rules\UniqueTranslate;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Class Product
 * @package App\Models\Product
 * @version August 16, 2020, 2:55 am UTC
 *
 * @property string $sku
 * @property string $type
 */
class Product extends TranslatedModel implements HasMedia
,IContentHasImage
{

    use SoftDeletes; //isForceDeleting check 
    use InteractsWithMedia;
    use ContentHasImage;

    const IMAGE_DISK = "public";
    const IMAGE_DIR = "products";

    const IMAGE_WIDTH = 300;
    const IMAGE_HEIGHT = 300;

    const COLLECTION_TAG = 'products';
    const CREATE_TAG = 'create-product';
    const SHOW_TAG = 'show-product';
    const EDIT_TAG = 'edit-product';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    const SLIDE_IMAGE_COLLECTION = 'SLIDE_IMAGE_COLLECTION';
    const CONTENT_IMAGE_COLLECTION = 'CONTENT_IMAGE_COLLECTION';

    const PRODUCT_TYPES = [
        [
            'key'  => 'simple',
            'name'  => 'Simple',
            'class' => '',
            'sort'  => 1
        ],
        [
            'key'   => 'variation',
            'name'  => 'variation',
            'class' => '',
            'sort'  => 2
        ]
    ];

    public $table = 'products';
    protected $with = ['translations'];


    protected $dates = ['deleted_at'];



    public $fillable = [
        'sku',
        'amount',
        'image',
        'price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sku' => 'string',
        'amount' => 'integer',
        'image' => 'string',
        'price' => 'integer',
    ];

    public $translatedAttributes = [
        'name',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'content'
    ];
    public static $rules = [
        'sku' => 'required|unique:products',
        'amount' => 'required|numeric',
        'price' => 'required|numeric',
        'image' => 'image',
    ];
    public static function getAddRules()
    {
        return array_merge(
            self::$rules,
            RuleFactory::make([
                '%name%' => ['required', 'string', new UniqueTranslate(app(ProductTranslation::class)->getTable(), 'name')],
                '%description%' => ['required', 'string'],
                '%slug%' => ['required', 'string'],
                '%meta_title%' => ['required', 'string'],
                '%meta_description%' => ['required', 'string'],
                '%meta_keywords%' => ['required', 'string'],
                '%content%' => ['required', 'string'],
            ])
        );
    }
    public static function getEditRules($product)
    {
        return array_merge(
            self::$rules,
            [
                'sku' => 'required|unique:products,' . $product->id,
            ],
            RuleFactory::make([
                '%name%' => ['required', 'string', new UniqueTranslate(app(ProductTranslation::class)->getTable(), 'name', 'product_id', $product->id)],
                '%description%' => ['required', 'string'],
                '%slug%' => ['required', 'string'],
                '%meta_title%' => ['required', 'string'],
                '%meta_description%' => ['required', 'string'],
                '%meta_keywords%' => ['required', 'string'],
                '%content%' => ['required', 'string'],
            ])
        );
    }

    protected $attributes = [
        'image' => '',
        'price' => 0,
        'sku'=>'',
        'amount'=>0,
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute');
        // return $this->belongsToMany(Attribute::class,'product_attribute','product_id','attribute_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function attributeOptions()
    {
        return $this->belongsToMany(AttributeOption::class, 'product_attribute_options', 'product_id', 'attribute_option_id');
    }
    public function getFormatPrice()
    {
        // return currency($this->price,'VND');
        if (
            currency()->getUserCurrency() ||
            request()->query('currency')
        ) {
            return currency($this->price, config('currency.default'), currency()->getUserCurrency());
        }
        return $this->price;
    }
    // public function productTranslations()
    // {
    //     return $this->translations();
    // }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    public function getItemByCartId($cartId)
    {
        return $this->cartItems()->where('cart_id', $cartId)->first();
    }
    public function isValuable($quantity)
    {
        return $this->amount >= $quantity;
    }
    public function image_url($linkImage)
    {
        if (!$linkImage)
            return;
        return Storage::url($linkImage);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::SLIDE_IMAGE_COLLECTION);
        // ->acceptsMimeTypes(['image/*']);

        $this->addMediaCollection(self::CONTENT_IMAGE_COLLECTION);
        // ->acceptsMimeTypes(['image/*']);

        // ->useFallbackUrl('/images/anonymous-user.jpg')
        // ->useFallbackPath(public_path('/images/anonymous-user.jpg'));
        // ->acceptsFile(function (File $file) {
        //     return $file->mimeType === 'image/jpeg';
        // });
        // ->acceptsMimeTypes(['image/jpeg']);
        // ->useDisk('s3');
        // ->singleFile();
        // ->onlyKeepLatest(3);
    }

}
