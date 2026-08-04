<?php

namespace App\View\Components\Frontend;

use App\Support\CompanyPhone;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UtilityBar extends Component
{
    /** @var array{phone: string, phone_formatted: string} */
    public array $contactPhone;

    public function __construct()
    {
        $this->contactPhone = CompanyPhone::forCurrentRequest();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.utility-bar');
    }
}
