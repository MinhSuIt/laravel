<?php

namespace App\Models\Attribute;

use App\Models\TranslatedModel;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AttributeOption extends TranslatedModel
{
    public $translatedAttributes = [
        'name',
    ];
    public $fillable = [
        'sort_order',
        'attribute_id'
    ];
    protected $attributes = [
        'sort_order' => 0,
        'attribute_id' => null
    ];
    protected $with = ['translations'];

    public $timestamps = false;
}
