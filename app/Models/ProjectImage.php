<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    use ClearsSiteCache, HasTranslations;

    protected $fillable = ['project_id', 'type', 'path', 'caption', 'caption_bn', 'sort_order'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function url(): string
    {
        return media_url($this->path);
    }
}
