<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\RecordsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use ClearsSiteCache, HasTranslations, RecordsActivity;

    public const POSITIONS = ['center' => 'Center', 'center top' => 'Top', 'center bottom' => 'Bottom', 'left center' => 'Left', 'right center' => 'Right'];

    protected $fillable = [
        'title', 'title_bn', 'subtitle', 'subtitle_bn', 'image', 'image_position',
        'button_text', 'button_text_bn', 'button_link', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
