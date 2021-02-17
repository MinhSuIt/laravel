<?php

namespace App\Models\Attribute;


use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryTranslation
 *
 * @package Webkul\Category\Models
 *
 * @property-read string $url_path maintained by database triggers
 */
class AttributeGroupTranslation extends Model 
{

    public $timestamps = false;
    protected $table='attribute_group_translation';
    protected $fillable = [
        'name',
    ];
}