<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'name',
        'type',
        'color',
        'rgba_color',
        'link',
        'img',
        'icon',
        'max_amount',
        'rate',
        'features',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
