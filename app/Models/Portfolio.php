<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Portfolio extends Model
{
    protected $fillable = [
        'service_id',
        'title',
        'slug',
        'location',
        'project_length',
        'content',
        'cover_image',
        'completion_date',
    ];

    protected function casts(): array
    {
        return [
            'project_length' => 'decimal:2',
            'completion_date' => 'date',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(ImageUpload::class, 'imageable');
    }

    public function getMetaAttribute(): string
    {
        $parts = array_filter([
            $this->project_length
                ? 'ยาว '.number_format((float) $this->project_length).' ม.'
                : null,
            $this->location,
        ]);

        return implode(' · ', $parts);
    }
}
