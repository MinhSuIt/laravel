<?php

namespace App\Models\Category;


use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryTranslation
 *
 * @package Webkul\Category\Models
 *
 * @property-read string $url_path maintained by database triggers
 */
class CategoryTranslation extends Model 
{

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'locale',
    ];
    protected $attributes = [
        'slug'=>''
    ];
}