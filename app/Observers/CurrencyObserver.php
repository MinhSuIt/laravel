<?php

namespace App\Observers;

use App\Models\Core\Currency;
use App\Models\Product\Product;
use Spatie\ResponseCache\Facades\ResponseCache;

class CurrencyObserver
{
    /**
     * Handle the currency "created" event.
     *
     * @param  \App\Currency  $currency
     * @return void
     */
    public function created(Currency $currency)
    {
        dd(123);
        ResponseCache::clear();

    }

    /**
     * Handle the currency "updated" event.
     *
     * @param  \App\Currency  $currency
     * @return void
     */
    public function updated(Currency $currency)
    {
        ResponseCache::clear();
        
    }

    /**
     * Handle the currency "deleted" event.
     *
     * @param  \App\Currency  $currency
     * @return void
     */
    public function deleted(Currency $currency)
    {
        ResponseCache::clear();
        
    }

    /**
     * Handle the currency "restored" event.
     *
     * @param  \App\Currency  $currency
     * @return void
     */
    public function restored(Currency $currency)
    {
        //
    }

    /**
     * Handle the currency "force deleted" event.
     *
     * @param  \App\Currency  $currency
     * @return void
     */
    public function forceDeleted(Currency $currency)
    {
        //
    }
}
