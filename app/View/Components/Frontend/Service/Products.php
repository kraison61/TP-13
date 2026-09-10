<?php

namespace App\View\Components\Frontend\Service;

use App\Models\Service;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Products extends Component
{
    public function __construct(public Service $service) {}

    public function shouldRender(): bool
    {
        if ($this->service->relationLoaded('products')) {
            return $this->service->products->isNotEmpty();
        }

        return $this->service->products()->exists();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.service.products');
    }
}
