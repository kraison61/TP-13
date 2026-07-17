<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ImageUpload extends Model
{
    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'img_url',
        'location',
        'worked_date',
    ];

    protected function casts(): array
    {
        return [
            'worked_date' => 'datetime',
        ];
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeFirstPerLocation(Builder $query): Builder
    {
        return $query
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->whereIn('id', function ($sub) {
                $sub->selectRaw('MIN(id)')
                    ->from('image_uploads')
                    ->whereNotNull('location')
                    ->where('location', '!=', '')
                    ->groupBy('location');
            });
    }
}
