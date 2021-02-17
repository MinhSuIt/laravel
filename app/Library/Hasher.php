<?php
namespace App\Library;

use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\CacheProfile;
use Spatie\ResponseCache\Hasher\RequestHasher;

class Hasher implements RequestHasher
{
    protected CacheProfile $cacheProfile;

    public function __construct(CacheProfile $cacheProfile)
    {
        $this->cacheProfile = $cacheProfile;
    }

    public function getHashFor(Request $request): string
    {
        $userId = '';
        $sessionFlash = '';
        if(auth()->check()){
            $userId = auth()->user()->id;
        }
        
        $sessionAll = collect(session('flash_notification')); // laracast/flashNotifier
        if( collect($sessionAll)->isNotEmpty() ){
            $sessionFlash = $sessionAll->toJson();
        }
        return 'responsecache-'.md5(
            "{$request->getHost()}-{$request->getRequestUri()}-{$request->getMethod()}/".$this->cacheProfile->useCacheNameSuffix($request).$userId.$sessionFlash
        );
    }
}
