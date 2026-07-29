<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Service extends Model
{
    protected $fillable = [
        'service_category_id',
        'title',
        'slug',
        'meta_title',
        'meta_des',
        'description',
        'h1',
        'content',
        'rating_value',
        'review_count',
        'schema_type',
        'is_active',
        'icon_name',
        'dur',
        'img_1',
        'img_2',
    ];

    protected function casts(): array
    {
        return [
            'rating_value' => 'decimal:1',
            'review_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ServicePrice::class);
    }

    public function activePrice(): HasOne
    {
        // Featured "starting from" = lowest active turnkey/package price (exclude labor-only rows)
        return $this->hasOne(ServicePrice::class)
            ->where('is_active', true)
            ->whereNotNull('price')
            ->where('name', 'not like', '%ค่าแรง%')
            ->orderBy('price')
            ->orderBy('sort_order');
    }

    public function lowestPrice(): HasOne
    {
        return $this->hasOne(ServicePrice::class)
            ->where('is_active', true)
            ->whereNotNull('price')
            ->where('name', 'not like', '%ค่าแรง%')
            ->orderBy('price')
            ->orderBy('sort_order');
    }

    public function activePrices(): HasMany
    {
        return $this->hasMany(ServicePrice::class)
            ->where('is_active', true)
            ->orderByRaw("CASE WHEN name LIKE '%ค่าแรง%' THEN 1 ELSE 0 END")
            ->orderBy('price')
            ->orderBy('sort_order');
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class);
    }

    public function scopes(): HasMany
    {
        return $this->hasMany(ServiceScope::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(ImageUpload::class, 'imageable');
    }

    public function getRenderedContentAttribute(): string
    {
        return $this->renderHtmlField($this->content);
    }

    public function getRenderedDescriptionAttribute(): string
    {
        return $this->renderHtmlField($this->description);
    }

    public function getPlainDescriptionAttribute(): string
    {
        return trim(strip_tags((string) $this->description));
    }

    private function renderHtmlField(?string $html): string
    {
        if (! $html) {
            return '';
        }

        $decoded = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $decoded = (string) preg_replace('/<!--[\s\S]*?-->/', '', $decoded);

        return \App\Support\BootstrapIcons::replaceFontTags($decoded);
    }
}
