<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class projects extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $blogs,
        public $totalProjects = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.projects');
    }
}
