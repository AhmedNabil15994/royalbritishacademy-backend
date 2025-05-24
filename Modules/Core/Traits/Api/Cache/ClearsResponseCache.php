<?php

namespace Modules\Core\Traits\Api\Cache;


use  Modules\Core\Traits\Api\Cache\Cache;

trait ClearsResponseCache
{
    public static function bootClearResponseCache($tags)
    {
        self::created(function () use($tags) {
            Cache::flush($tags);
        });

        self::updating(function () use($tags) {
            Cache::flush($tags);
        });

        self::updated(function () use($tags) {
            Cache::flush($tags);
        });

        self::deleted(function () use($tags) {
            Cache::flush($tags);
        });
    }
}