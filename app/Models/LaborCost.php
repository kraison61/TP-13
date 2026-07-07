<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaborCost extends Model
{
    protected $fillable = [
        'category_id',
        'item_name',
        'unit',
        'cost_per_unit',
        'remark',
        'document_ref',
    ];

    protected function casts(): array
    {
        return [
            'cost_per_unit' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LaborCategory::class, 'category_id');
    }
}
