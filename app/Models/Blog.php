<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Blog extends Model
{
    public const DEFAULT_GEO = '13.836991,100.443780';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'cover_image',
        'service_id',
        'author',
        'geo',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(ImageUpload::class, 'imageable');
    }

    public function getRenderedContentAttribute(): string
    {
        $html = (string) $this->content;
        if ($html === '') {
            return '';
        }

        $decoded = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $decoded = (string) preg_replace('/<!--[\s\S]*?-->/', '', $decoded);

        return \App\Support\BootstrapIcons::replaceFontTags($decoded);
    }
}
