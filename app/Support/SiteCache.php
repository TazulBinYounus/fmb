<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Facades\Cache;

/**
 * Caches public-site content (settings, menus, banners, featured projects …).
 * Every key carries a version number; flush() bumps the version so all cached
 * content is rebuilt on the next request after an admin change.
 */
class SiteCache
{
    private const VERSION_KEY = 'site-cache-version';

    public static function remember(string $key, Closure $callback): mixed
    {
        $version = Cache::get(self::VERSION_KEY, 1);

        return Cache::remember("site.v{$version}.{$key}", now()->addDay(), $callback);
    }

    public static function flush(): void
    {
        $version = Cache::get(self::VERSION_KEY, 1);
        Cache::forever(self::VERSION_KEY, $version + 1);
    }
}
