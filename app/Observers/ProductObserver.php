<?php

namespace App\Observers;

use App\Models\Product\Product;
use Spatie\ResponseCache\Facades\ResponseCache;

class ProductObserver
{
    public function retrieved(Product $product)
    {
        // dump($product);
    }
    /**
     * Handle the product "created" event.
     *
     * @param  \App\odel=Models\Product\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        ResponseCache::clear([
            Product::COLLECTION_TAG,
        ]);
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\odel=Models\Product\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        ResponseCache::clear([
            Product::COLLECTION_TAG,
            Product::SHOW_TAG,
            Product::EDIT_TAG,
        ]);
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\odel=Models\Product\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        ResponseCache::clear([
            Product::COLLECTION_TAG,
            Product::SHOW_TAG,
            Product::EDIT_TAG,
        ]);
    }
    public function deleting(Product $product)
    {

    }
    /**
     * Handle the product "restored" event.
     *
     * @param  \App\odel=Models\Product\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\odel=Models\Product\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
