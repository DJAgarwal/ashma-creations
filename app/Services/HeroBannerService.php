<?php

namespace App\Services;

use App\Models\HeroBanner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class HeroBannerService
{
    /**
     * Retrieve active homepage hero banners ordered by display order.
     *
     * @param bool $useCache
     * @return Collection
     */
    public static function getHomepageBanners(bool $useCache = true): Collection
    {
        if ($useCache) {
            return Cache::remember('home_hero_banners_v1', 3600, function () {
                return HeroBanner::active()
                    ->ordered()
                    ->get();
            });
        }

        return HeroBanner::active()
            ->ordered()
            ->get();
    }
}
