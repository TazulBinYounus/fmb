<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\RecordsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    use ClearsSiteCache, HasTranslations, RecordsActivity;

    protected $fillable = [
        'name', 'name_bn', 'designation', 'designation_bn', 'project_id', 'quote', 'quote_bn', 'photo', 'rating', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderByDesc('id');
    }
}
