<?php

namespace App\View\Components\Frontend;

use App\Models\Finance as FinancePartner;
use App\Support\BootstrapIcons;
use App\Support\FrontendCache;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Finance extends Component
{
    public function render(): View|Closure|string
    {
        $partners = FrontendCache::rememberIds('finance.partner-ids', fn () => FinancePartner::query()
            ->where('is_active', true)
            ->orderBy('sort_order'));

        $partnersPayload = $partners->map(fn (FinancePartner $partner) => [
            'name' => $partner->name,
            'type' => $partner->type,
            'color' => $partner->color,
            'rgba_color' => $partner->rgba_color,
            'link' => $partner->link,
            'img' => $partner->img,
            'icon' => BootstrapIcons::resolveKey($partner->icon),
            'max_amount' => $partner->max_amount,
            'rate' => $partner->rate,
            'features' => $partner->features ?? [],
        ])->values()->all();

        return view('components.frontend.finance', [
            'partners' => $partners,
            'partnersPayload' => $partnersPayload,
        ]);
    }
}
