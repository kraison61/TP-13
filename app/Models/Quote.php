<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'reference',
        'name',
        'phone',
        'service',
        'expected_budget',
        'requested_discount',
        'detail',
    ];

    protected function casts(): array
    {
        return [
            'requested_discount' => 'integer',
        ];
    }
}
