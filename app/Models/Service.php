<?php
// app/Models/Service.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends Model
{
    protected $fillable = [
        'service_category_id', 'title', 'slug', 'description',
        'dur', 'icon_name', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ServicePrice::class);
    }

    public function activePrice(): HasOne
    {
        return $this->hasOne(ServicePrice::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }
}