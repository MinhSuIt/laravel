<?php

namespace App\Observers;

use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeGroup;
use App\Models\Category\Category;
use App\Models\Product\Product;
use Spatie\ResponseCache\Facades\ResponseCache;

class AttributeGroupObserver
{
    /**
     * Handle the attribute group "created" event.
     *
     * @param  \App\AttributeGroup  $attributeGroup
     * @return void
     */
    public function created(AttributeGroup $attributeGroup)
    {
        ResponseCache::clear([
            AttributeGroup::COLLECTION_TAG,

            Attribute::CREATE_TAG,
            Attribute::EDIT_TAG,
        ]);
    }

    /**
     * Handle the attribute group "updated" event.
     *
     * @param  \App\AttributeGroup  $attributeGroup
     * @return void
     */
    public function updated(AttributeGroup $attributeGroup)
    {
        ResponseCache::clear([
            AttributeGroup::COLLECTION_TAG,
            AttributeGroup::SHOW_TAG,
            AttributeGroup::EDIT_TAG,

            Attribute::COLLECTION_TAG,
            Attribute::CREATE_TAG,
            Attribute::SHOW_TAG,
            Attribute::EDIT_TAG,

            Category::COLLECTION_TAG,
            Category::CREATE_TAG,
            Category::SHOW_TAG,
            Category::EDIT_TAG,

            Product::COLLECTION_TAG,
        ]);
    }

    /**
     * Handle the attribute group "deleted" event.
     *
     * @param  \App\AttributeGroup  $attributeGroup
     * @return void
     */
    public function deleted(AttributeGroup $attributeGroup)
    {
        ResponseCache::clear([
            AttributeGroup::COLLECTION_TAG,
            AttributeGroup::SHOW_TAG,
            AttributeGroup::EDIT_TAG,

            Attribute::COLLECTION_TAG,
            Attribute::CREATE_TAG,
            Attribute::SHOW_TAG,
            Attribute::EDIT_TAG,

            Category::COLLECTION_TAG,
            Category::CREATE_TAG,
            Category::SHOW_TAG,
            Category::EDIT_TAG,

            Product::COLLECTION_TAG,
        ]);
    }

    /**
     * Handle the attribute group "restored" event.
     *
     * @param  \App\AttributeGroup  $attributeGroup
     * @return void
     */
    public function restored(AttributeGroup $attributeGroup)
    {
        //
    }

    /**
     * Handle the attribute group "force deleted" event.
     *
     * @param  \App\AttributeGroup  $attributeGroup
     * @return void
     */
    public function forceDeleted(AttributeGroup $attributeGroup)
    {
        //
    }
}
