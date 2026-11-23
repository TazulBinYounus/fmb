<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\RecordsActivity;
use App\Support\SiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use ClearsSiteCache, HasTranslations, RecordsActivity;

    public const LOCATIONS = ['header' => 'Header menu', 'footer' => 'Footer quick links'];

    protected $fillable = ['location', 'parent_id', 'label', 'label_bn', 'url', 'open_in_new_tab', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['open_in_new_tab' => 'boolean', 'is_active' => 'boolean'];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    /** Full URL; relative links such as "/contact" respect the site base URL. */
    public function href(): string
    {
        $url = trim($this->url);
        if ($url === '' || $url === '#') {
            return '#';
        }

        return preg_match('~^(https?:|mailto:|tel:|#)~', $url) ? $url : url($url);
    }

    /** Active menu tree for a location (cached; refreshed when menus change). */
    public static function tree(string $location)
    {
        try {
            return SiteCache::remember("menu.$location", fn () => self::with('children.children')
                ->where('location', $location)->whereNull('parent_id')->where('is_active', true)
                ->orderBy('sort_order')->orderBy('id')->get());
        } catch (\Throwable) {
            return collect(); // database not migrated yet
        }
    }
}
