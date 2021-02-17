<?php
namespace App\Utils;

use Illuminate\Support\Facades\Cache as FacadesCache;

class Cache {
    public function get($key)
    {
        return FacadesCache::get($key);
    }
    public function set($key,$data,$ttl = 600)
    {
        FacadesCache::put($key,$data,$ttl);
    }
    public function clearCache()
    {
        FacadesCache::flush();
    }
    public function forget($key)
    {
        FacadesCache::forget($key);
    }
}