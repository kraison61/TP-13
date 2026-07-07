<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountAttribution extends Model
{
    protected $fillable = [
        'code',
        'source_page',
        'utm_source',
        'ip_address',
        'customer_name',
        'project_id',
        'status',
        'discount_amount',
        'used_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'discount_amount' => 'decimal:2',
            'used_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
