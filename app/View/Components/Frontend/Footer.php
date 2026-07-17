<?php

namespace App\View\Components\Frontend;

use App\Models\Service;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Footer extends Component
{
    public Collection $footerServices;

    public function __construct()
    {
        $this->footerServices = Service::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->limit(5)
            ->get(['title', 'slug']);
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.footer');
    }
}
