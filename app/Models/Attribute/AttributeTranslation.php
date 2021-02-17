<?php

namespace App\Models\Attribute;

use Illuminate\Database\Eloquent\Model;

class AttributeTranslation extends Model
{
    protected $table='attribute_translations';
    protected $fillable = ['name','slug','locale'];
    protected $attributes = [
        'slug' => '',
    ];
    public $timestamps= false;
}
