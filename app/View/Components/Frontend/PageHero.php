<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageHero extends Component
{
    public array $badges;

    public function __construct(
        public string $eyebrow = '',
        public string $title = '',
        public string $description = '',
        ?array $badges = null,
        public ?string $current = null,
    ) {
        $this->badges = $badges ?? [];
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.page-hero');
    }
}
