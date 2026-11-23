<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = ['path', 'original_name', 'mime_type', 'size', 'width', 'height', 'alt', 'uploaded_by'];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function url(): string
    {
        return media_url($this->path);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function humanSize(): string
    {
        return $this->size >= 1048576 ? round($this->size / 1048576, 1).' MB' : max(1, round($this->size / 1024)).' KB';
    }
}
