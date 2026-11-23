<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectUnit extends Model
{
    use ClearsSiteCache;

    public const AVAILABILITY = ['available' => 'Available', 'booked' => 'Booked', 'sold' => 'Sold'];

    protected $fillable = [
        'project_id', 'name', 'bedrooms', 'bathrooms', 'balconies', 'size_sqft', 'price', 'floor_plan', 'availability', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
