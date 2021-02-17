<?php

namespace App\Observers;

use App\Models\Category\Category;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

class CategoryObserver
{
    public function retrieved(Category $category)
    {
        //nếu là relationship ví dụ many to many nó sẽ bao gồm luôn các trường của bảng trung gian vào $category
        // if(isset($category->pivot_product_id) && isset($category->pivot_category_id)){
        //     // check có bảng phụ của $category đó trong redis chưa rồi mới thêm

        // }


    }
    /**
     * Handle the category "created" event.
     *
     * @param  \App\Category\Category  $category
     * @return void
     */
    public function created(Category $category)
    {

        //phai config cache laravel la redis thi moi xai dc tag 
        ResponseCache::clear([
            Category::COLLECTION_TAG,
            Product::EDIT_TAG,
            Product::CREATE_TAG,
        ]);
    }

    /**
     * Handle the category "updated" event.
     *
     * @param  \App\Category\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        //ResponseCache::forget('/some-uri',Category::SHOW_TAG); sử dụng cái này để thay thế cho việc clear all category trong việc show 1 category
        //clear dạng :/category/1 ,/category/1?include=abc... hiện tại chưa lấy đc id vì middleware trong constructor,ko xài middleware trong method đc 
        ResponseCache::clear([
            Category::COLLECTION_TAG,
            Category::SHOW_TAG,
            Category::EDIT_TAG,

            Product::COLLECTION_TAG,
            Product::CREATE_TAG,
            Product::EDIT_TAG,
        ]);
    }

    /**
     * Handle the category "deleted" event.
     *
     * @param  \App\Category\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        ResponseCache::clear([
            Category::COLLECTION_TAG,
            Category::SHOW_TAG,
            Category::EDIT_TAG,

            Product::COLLECTION_TAG,
            Product::CREATE_TAG,
            Product::SHOW_TAG,
            Product::EDIT_TAG,
        ]);
    }
    public function deleting(Category $category)
    {
    }
    /**
     * Handle the category "restored" event.
     *
     * @param  \App\Category\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param  \App\Category\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
