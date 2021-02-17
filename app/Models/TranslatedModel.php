<?php

namespace App\Models;

use App\Library\Traits\ContentHasImage;
use Astrotomic\Translatable\Translatable;

abstract class TranslatedModel extends BaseModel
{
    use Translatable;

    public function getTranslatedAttribute($locale, $attribute)
    {
        return $this->translate($locale, true)->{$attribute};
    }
}
