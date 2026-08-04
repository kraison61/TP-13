<?php

namespace App\View\Components\Frontend;

use App\Models\Service;
use App\Support\CompanyPhone;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Footer extends Component
{
    public Collection $footerServices;

    /** @var array{phone: string, phone_formatted: string} */
    public array $contactPhone;

    public function __construct()
    {
        $this->contactPhone = CompanyPhone::forCurrentRequest();

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
