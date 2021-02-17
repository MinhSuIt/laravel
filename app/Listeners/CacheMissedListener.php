<?php

namespace App\Listeners;

use App\Library\CustomHasher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class CacheMissedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $hasher;
    public function __construct(CustomHasher $hasher)
    {
        $this->hasher=$hasher;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        $key = $event->request->generalKey;
        // $ttl = $this->getLifetime($args);
        $otherKey = $this->hasher->getHashFor($event->request);
        if(!Cache::has($key)){

            // Cache::put($key,[$otherKey],$ttl);
            Cache::put($key,[$otherKey]);
            
        }else{
            $oldCache = Cache::get($key);
            if(!in_array($otherKey,$oldCache)){
                array_push($oldCache,$otherKey);
                // Cache::put($key,$oldCache,$ttl);
                Cache::put($key,$oldCache);
            }

    }
}
}
