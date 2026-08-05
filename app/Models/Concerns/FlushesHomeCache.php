<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Cache;

trait FlushesHomeCache
{
    public static function bootFlushesHomeCache(): void
    {
        static::saved(function () {
            static::flushHomeCacheKeys();
        });

        static::deleted(function () {
            static::flushHomeCacheKeys();
        });

        if (method_exists(static::class, 'restored')) {
            static::restored(function () {
                static::flushHomeCacheKeys();
            });
        }
    }

    public static function flushHomeCacheKeys(): void
    {
        Cache::forget('home_hero_banners_v1');
        Cache::forget('home_featured_collections_v1');
        Cache::forget('home_featured_categories_v1');
        Cache::forget('home_featured_products_v1');
        Cache::forget('home_occasions_v1');
        Cache::forget('home_occasions_v2');
        Cache::forget('home_recipients_v1');
        Cache::forget('home_recipients_v2');
        Cache::forget('home_recipients_v3');
    }
}
