<?php

namespace App\Observers;

use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeGroup;
use App\Models\Category\Category;
use App\Models\Product\Product;
use Spatie\ResponseCache\Facades\ResponseCache;

class AttributeObserver
{
    /**
     * Handle the attribute "created" event.
     *
     * @param  \App\Attribute  $attribute
     * @return void
     */
    public function created(Attribute $attribute)
    {
        ResponseCache::clear([
            Attribute::COLLECTION_TAG,

            Product::CREATE_TAG,
            Product::EDIT_TAG,

            AttributeGroup::CREATE_TAG,
            AttributeGroup::EDIT_TAG,
        ]);
    }

    /**
     * Handle the attribute "updated" event.
     *
     * @param  \App\Attribute  $attribute
     * @return void
     */
    public function updated(Attribute $attribute)
    {
        ResponseCache::clear([
            Attribute::COLLECTION_TAG,
            Attribute::SHOW_TAG,
            Attribute::EDIT_TAG,

            Category::COLLECTION_TAG,

            Product::COLLECTION_TAG,
            Product::CREATE_TAG,
            Product::SHOW_TAG,
            Product::EDIT_TAG,

            AttributeGroup::COLLECTION_TAG,
            AttributeGroup::CREATE_TAG,
            AttributeGroup::SHOW_TAG,
            AttributeGroup::EDIT_TAG,
        ]);
    }

    /**
     * Handle the attribute "deleted" event.
     *
     * @param  \App\Attribute  $attribute
     * @return void
     */
    public function deleted(Attribute $attribute)
    {
        //
    }

    /**
     * Handle the attribute "restored" event.
     *
     * @param  \App\Attribute  $attribute
     * @return void
     */
    public function restored(Attribute $attribute)
    {
        //
    }

    /**
     * Handle the attribute "force deleted" event.
     *
     * @param  \App\Attribute  $attribute
     * @return void
     */
    public function forceDeleted(Attribute $attribute)
    {
        //
    }
}
