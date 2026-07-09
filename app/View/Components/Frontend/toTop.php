<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class toTop extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.frontend.to-top');
    }
}
