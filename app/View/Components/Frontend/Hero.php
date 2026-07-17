<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hero extends Component
{
    public function __construct(
        public string $layout = 'page',
        public string $eyebrow = '',
        public string $title = '',
        public string $description = '',
        public ?array $badges = null,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.hero');
    }
}
