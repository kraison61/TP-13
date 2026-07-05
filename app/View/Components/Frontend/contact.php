<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class contact extends Component
{
    public string $reference;

    public function __construct()
    {
        $reference = session('quote_reference');

        if (! is_string($reference) || $reference === '') {
            $reference = 'WEB-'.now()->format('dmY').'-'.strtoupper(Str::random(4));
            session(['quote_reference' => $reference]);
        }

        $this->reference = $reference;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.contact');
    }
}
