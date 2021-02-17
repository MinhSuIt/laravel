<?php

namespace App\Observers;

use App\Models\Category\Category;
use App\Models\Core\Locale;
use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

class LocalObserver
{
    /**
     * Handle the locale "created" event.
     *
     * @param  \App\Locale  $locale
     * @return void
     */
    public function created(Locale $locale)
    {
        //cẩn thận ko xóa đi cache của refresh token jwt
        //cẩn thận khi dùng cache tags giữa flush và forget : 
        //ví dụ có 2 tag: a,b khi dùng tags([a,b])->flush() === tags(['a'])->flush() + tags(['b'])->flush() + tags(['a,b'])->flush() 
        // ,khi tags(['a'])->flush() hoặc tags(['b'])->flush() sẽ tags(['a,b'])->flush() 
        // ,trường hợp có cùng 1 tag name + tag name khác,khi chỉ xóa phụ thuộc vào tag name khác mà ko xóa tất cả
        // ,,Cache::tags(['people', 'artists'])->put('John', 'John' );

        // ,,Cache::tags(['people', 'authors'])->put('Anne', 'Anne');
        // ,,Cache::tags(['authors'])->flush();
        // ,,$john = Cache::tags(['people', 'artists'])->get('John');

        // ,,$anne = Cache::tags(['people', 'authors'])->get('Anne');
        // ,,dd($john,$anne); =>John,null
        //dùng tags(['a','b'])->forget() sẽ ko xóa tags(['a'])->forget() + tags(['b'])->forget()
        // ,khi tags(['a'])->forget() hoặc tags(['b'])->forget() sẽ ko tags([a,b])->forget() 
        Cache::tags(config('app.cacheResponseMiddleware'))->flush();
    }

    /**
     * Handle the locale "updated" event.
     *
     * @param  \App\Locale  $locale
     * @return void
     */
    public function updated(Locale $locale)
    {
        Cache::tags(config('app.cacheResponseMiddleware'))->flush();

    }

    /**
     * Handle the locale "deleted" event.
     *
     * @param  \App\Locale  $locale
     * @return void
     */
    public function deleted(Locale $locale)
    {
        Cache::tags(config('app.cacheResponseMiddleware'))->flush();
    }

    /**
     * Handle the locale "restored" event.
     *
     * @param  \App\Locale  $locale
     * @return void
     */
    public function restored(Locale $locale)
    {
        Cache::tags(config('app.cacheResponseMiddleware'))->flush();
    }

    /**
     * Handle the locale "force deleted" event.
     *
     * @param  \App\Locale  $locale
     * @return void
     */
    public function forceDeleted(Locale $locale)
    {
        Cache::tags(config('app.cacheResponseMiddleware'))->flush();
    }
}
