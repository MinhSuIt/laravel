<?php

namespace App\Models\Product;


use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryTranslation
 *
 * @package Webkul\Category\Models
 *
 * @property-read string $url_path maintained by database triggers
 */
class ProductTranslation extends Model 
{
    public $key = 'product:$product_id:translation:$translation_id:';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'content',
        'locale',
    ];
    protected $attributes = [
        'slug'=>'',
        'content'=>''
    ];
}