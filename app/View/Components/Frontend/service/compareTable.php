<?php

namespace App\View\Components\frontend\service;

use App\Models\Service;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class compareTable extends Component
{
    public $services;

    private const WARRANTY_SLUGS = [
        'retaining-wall', 'fence', 'dam', 'footing', 'pour-concrete', 'pipe', 'pile',
    ];

    private const ENGINEER_CERT_SLUGS = [
        'retaining-wall', 'dam', 'footing', 'pile',
    ];

    public function __construct()
    {
        
$this->services = Service::query()
->with('activePrice')
->where('is_active', true)
->whereHas('activePrice')
->orderBy('id')
->get()
->map(fn (Service $service) => (object) [
    'title' => $service->title,
    'slug' => $service->slug,
    'dur' => $service->dur,
    'price' => $service->activePrice->price,
    'unit' => $service->activePrice->unit,
    'has_warranty' => in_array($service->slug, self::WARRANTY_SLUGS),
    'has_engineer_cert' => in_array($service->slug, self::ENGINEER_CERT_SLUGS),
]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.service.compare-table');
    }
}
