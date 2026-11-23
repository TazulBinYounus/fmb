<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\RecordsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use ClearsSiteCache, HasTranslations, RecordsActivity, SoftDeletes;

    public const STATUSES = [
        'upcoming' => 'Upcoming',
        'ongoing' => 'Ongoing',
        'completed' => 'Completed',
        'sold_out' => 'Sold Out',
    ];

    public const TYPES = [
        'residential' => 'Residential',
        'commercial' => 'Commercial',
        'condominium' => 'Condominium',
        'land' => 'Land',
    ];

    protected $fillable = [
        'name', 'name_bn', 'slug', 'type', 'status', 'area', 'area_bn', 'location', 'location_bn', 'address',
        'summary', 'summary_bn', 'description', 'description_bn', 'price_from', 'price_to', 'price_note',
        'payment_info', 'payment_info_bn', 'specs', 'amenities', 'map_query', 'latitude', 'longitude',
        'video_url', 'cover_image', 'brochure', 'handover_date', 'is_featured', 'is_published', 'sort_order',
        'seo_title', 'seo_description', 'seo_keywords', 'og_image',
    ];

    protected function casts(): array
    {
        return [
            'specs' => 'array',
            'amenities' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'handover_date' => 'date',
            'price_from' => 'decimal:2',
            'price_to' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Relationships -------------------------------------------------------

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function gallery(): HasMany
    {
        return $this->images()->where('type', 'gallery');
    }

    public function floorPlans(): HasMany
    {
        return $this->images()->where('type', 'floor_plan');
    }

    public function units(): HasMany
    {
        return $this->hasMany(ProjectUnit::class)->orderBy('sort_order')->orderBy('id');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

    // Scopes ---------------------------------------------------------------

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    // Presentation helpers -------------------------------------------------

    public function statusLabel(): string
    {
        return __(self::STATUSES[$this->status] ?? $this->status);
    }

    public function typeLabel(): string
    {
        return __(self::TYPES[$this->type] ?? $this->type);
    }

    public function coverUrl(): string
    {
        return media_url($this->cover_image, 'assets/images/background/5.jpg');
    }

    /** "At a glance" rows as [label, value] in the current language. */
    public function specRows(): array
    {
        $bn = app()->getLocale() === 'bn';

        return collect($this->specs ?? [])
            ->filter(fn ($row) => filled($row['label'] ?? null))
            ->map(fn ($row) => [
                ($bn && filled($row['label_bn'] ?? null)) ? $row['label_bn'] : $row['label'],
                ($bn && filled($row['value_bn'] ?? null)) ? $row['value_bn'] : ($row['value'] ?? null),
            ])->values()->all();
    }

    /** Amenity names in the current language. */
    public function amenityNames(): array
    {
        $bn = app()->getLocale() === 'bn';

        return collect($this->amenities ?? [])
            ->map(fn ($a) => ($bn && filled($a['name_bn'] ?? null)) ? $a['name_bn'] : ($a['name'] ?? null))
            ->filter()->values()->all();
    }

    public function priceRange(): ?string
    {
        if (! $this->price_from && ! $this->price_to) {
            return null;
        }
        $range = $this->price_to && $this->price_to != $this->price_from
            ? bdt($this->price_from).' – '.bdt($this->price_to)
            : bdt($this->price_from ?: $this->price_to);

        return trim($range.' '.$this->price_note);
    }

    public function mapEmbedUrl(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return 'https://maps.google.com/maps?q='.$this->latitude.','.$this->longitude.'&z=15&output=embed';
        }

        return $this->map_query ? 'https://maps.google.com/maps?q='.rawurlencode($this->map_query).'&z=15&output=embed' : null;
    }

    /** Embeddable URL for YouTube or Facebook video links. */
    public function videoEmbedUrl(): ?string
    {
        $url = (string) $this->video_url;
        if ($url === '') {
            return null;
        }
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))([\w-]{11})~', $url, $m)) {
            return 'https://www.youtube-nocookie.com/embed/'.$m[1];
        }
        if (preg_match('~^https://(www\.|m\.)?(facebook\.com|fb\.watch)/~', $url)) {
            return 'https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=false';
        }

        return null;
    }

    public function seoTitle(): string
    {
        return $this->seo_title ?: __('Flat for Sale in :area', ['area' => $this->tr('area') ?: $this->tr('location')]).' – '.$this->tr('name');
    }
}
