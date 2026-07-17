<?php

namespace App\View\Components\Frontend;

use App\Models\Finance as FinancePartner;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Finance extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.frontend.finance', [
            'partners' => FinancePartner::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
