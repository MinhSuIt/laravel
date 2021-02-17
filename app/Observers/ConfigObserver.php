<?php

namespace App\Observers;

use App\Models\Core\Config;
use Spatie\ResponseCache\Facades\ResponseCache;

class ConfigObserver
{
    /**
     * Handle the config "created" event.
     *
     * @param  \App\Config  $config
     * @return void
     */
    public function created(Config $config)
    {
        ResponseCache::clear([
            Config::COLLECTION_TAG,

        ]);
    }

    /**
     * Handle the config "updated" event.
     *
     * @param  \App\Config  $config
     * @return void
     */
    public function updated(Config $config)
    {
        //
    }

    /**
     * Handle the config "deleted" event.
     *
     * @param  \App\Config  $config
     * @return void
     */
    public function deleted(Config $config)
    {
        //
    }

    /**
     * Handle the config "restored" event.
     *
     * @param  \App\Config  $config
     * @return void
     */
    public function restored(Config $config)
    {
        //
    }

    /**
     * Handle the config "force deleted" event.
     *
     * @param  \App\Config  $config
     * @return void
     */
    public function forceDeleted(Config $config)
    {
        //
    }
}
