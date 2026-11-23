<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\RecordsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use ClearsSiteCache, HasTranslations, RecordsActivity;

    public const CATEGORIES = ['general' => 'General', 'real_estate' => 'Real Estate', 'landowner' => 'Landowners', 'garments' => 'Garments'];

    protected $fillable = ['category', 'question', 'question_bn', 'answer', 'answer_bn', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
