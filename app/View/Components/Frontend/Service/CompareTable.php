<?php

namespace App\View\Components\Frontend\Service;

use App\Models\Service;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class CompareTable extends Component
{
    public Collection $services;

    public array $columns;

    public function __construct(?Collection $services = null, ?array $columns = null)
    {
        $this->services = $services ?? $this->queryServices();
        $this->columns = $columns ?? config('frontend.service_compare.columns', []);
    }

    private function queryServices(): Collection
    {
        return Service::query()
            ->with([
                'lowestPrice',
                'scopes' => fn ($q) => $q->whereIn('group', ['warranty', 'cert']),
            ])
            ->where('is_active', true)
            ->whereHas('lowestPrice')
            ->orderBy('id')
            ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.service.compare-table');
    }
}
