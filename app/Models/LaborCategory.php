<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaborCategory extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(LaborCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(LaborCategory::class, 'parent_id');
    }

    public function laborCosts(): HasMany
    {
        return $this->hasMany(LaborCost::class, 'category_id');
    }
}
