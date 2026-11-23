<?php

namespace App\Models\Concerns;

use App\Support\SiteCache;

/** Refreshes cached public-site content whenever a record changes. */
trait ClearsSiteCache
{
    public static function bootClearsSiteCache(): void
    {
        static::saved(fn () => SiteCache::flush());
        static::deleted(fn () => SiteCache::flush());
    }
}
