<?php

namespace App\Providers;

use App\Events\RegisterCustomerEvent;
use App\Listeners\CacheHitListener;
use App\Listeners\CacheMissedListener;
use App\Listeners\ClearedResponseCacheListener;
use App\Listeners\ClearingResponseCacheListener;
use App\Listeners\KeyForgottenListener;
use App\Listeners\KeyWrittenListener;
use App\Listeners\Redis\CacheMissedListener as RedisCacheMissedListener;
use App\Listeners\Redis\ClearingResponseCacheListener as RedisClearingResponseCacheListener;
use App\Listeners\RegisterCustomerListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Spatie\ResponseCache\Events\CacheMissed;
use Spatie\ResponseCache\Events\ClearedResponseCache;
use Spatie\ResponseCache\Events\ClearingResponseCache;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RegisterCustomerEvent::class =>[
            RegisterCustomerListener::class
        ],
        // CacheMissed::class =>[
        //     CacheMissedListener::class
        // ],
        // ClearingResponseCache::class=>[
        //     ClearingResponseCacheListener::class
        // ],
        // ClearedResponseCache::class=>[
        //     ClearedResponseCacheListener::class
        // ],


        // CacheMissed::class =>[
        //     RedisCacheMissedListener::class
        // ],
        // ClearingResponseCache::class=>[
        //     RedisClearingResponseCacheListener::class
        // ],
        // ClearedResponseCache::class=>[
        //     ClearedResponseCacheListener::class
        // ],



        //event cachehit của laravel sẽ xảy ra trước của package laravel-responsable
        //khi đc Cache::get
        // 'Illuminate\Cache\Events\CacheHit' => [
        //     CacheHitListener::class
        // ],

        //khi lấy cache của 1 key ko tồn tại(hết hạn)
        // 'Illuminate\Cache\Events\CacheMissed' => [
        //     CacheMissedListener::class
        // ],

        //khi lấy cache của 1 key bị forget : Cache:forget (Cache:flush ko kích hoạt event này)
        // 'Illuminate\Cache\Events\KeyForgotten' => [
        //     KeyForgottenListener::class
        // ],
        
        //khi Cache::get
        // 'Illuminate\Cache\Events\KeyWritten' => [
        //     KeyWrittenListener::class
        // ],
    
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
