<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Project extends Model
{
    public const DEFAULT_GEO = '13.836991,100.443780';

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'status',
        'geo',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function phases(): HasMany
    {
        return $this->hasMany(ProjectPhase::class);
    }

    public function discountAttributions(): HasMany
    {
        return $this->hasMany(DiscountAttribution::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(ImageUpload::class, 'imageable');
    }
}
