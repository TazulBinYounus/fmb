<?php

namespace App\Models;

use App\Support\SiteCache;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /** All settings as key => value (cached). */
    public static function allCached(): array
    {
        try {
            return SiteCache::remember('settings', fn () => self::pluck('value', 'key')->all());
        } catch (\Throwable) {
            return []; // database not migrated yet
        }
    }

    /**
     * @param  bool  $translated  use "{key}_bn" when the site is in Bangla and it is filled
     */
    public static function get(string $key, mixed $default = null, bool $translated = false): mixed
    {
        $all = self::allCached();
        if ($translated && app()->getLocale() === 'bn' && filled($all[$key.'_bn'] ?? null)) {
            return $all[$key.'_bn'];
        }
        $value = $all[$key] ?? null;

        return filled($value) ? $value : $default;
    }

    public static function put(array $values): void
    {
        foreach ($values as $key => $value) {
            self::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        SiteCache::flush();
    }
}
