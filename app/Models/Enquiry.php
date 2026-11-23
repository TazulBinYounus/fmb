<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enquiry extends Model
{
    public const TYPES = [
        'garments' => 'Garments sourcing',
        'property' => 'Property',
        'site_visit' => 'Site visit',
        'landowner' => 'Landowner',
        'other' => 'Other',
    ];

    public const STATUSES = ['new' => 'New', 'contacted' => 'Contacted', 'closed' => 'Closed'];

    protected $fillable = ['type', 'project_id', 'name', 'email', 'phone', 'company', 'subject', 'message', 'details', 'status', 'ip_address'];

    protected function casts(): array
    {
        return ['details' => 'array'];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }
}
