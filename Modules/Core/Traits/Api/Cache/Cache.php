<?php

namespace Modules\Core\Traits\Api\Cache;

use Illuminate\Support\Facades\Cache as LaravelCache;
class Cache
{
    static function lastVersionCache($tags,$key,$data)
    {
        return LaravelCache::tags((array)$tags)->rememberForever("{$key}", function () use($data) {
            return $data;
        });
    }
    
    static function rememberForever($tags,$key,$data)
    {
        return LaravelCache::tags((array)$tags)->rememberForever("{$key}", function () use($data) {
            return $data;
        });
    }
    
    static function rememberForeverWithCallback($tags,$key,$callback)
    {
        return LaravelCache::tags((array)$tags)->rememberForever("{$key}", $callback);
    }
    static function remember($tags,$key,$time,$data)
    {
        return LaravelCache::tags((array)$tags)->remember("{$key}",$time, function () use($data) {
            return $data;
        });
    }

    static function flush($tags)
    {
        cache()->store('redis')->tags($tags)->flush();
        // LaravelCache::tags((array)$tags)->flush();
    }
}