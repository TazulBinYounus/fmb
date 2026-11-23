<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use ClearsSiteCache, HasTranslations, RecordsActivity;

    /** Slugs used by built-in routes; they cannot be renamed or deleted from the admin. */
    public const SYSTEM_SLUGS = ['about', 'contact'];

    protected $fillable = [
        'title', 'title_bn', 'slug', 'content', 'content_bn', 'banner_image', 'is_published',
        'seo_title', 'seo_description', 'seo_keywords', 'og_image',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isSystem(): bool
    {
        return in_array($this->slug, self::SYSTEM_SLUGS, true);
    }

    public function publicUrl(): string
    {
        return $this->isSystem() ? url('/'.$this->slug) : url('/page/'.$this->slug);
    }
}
