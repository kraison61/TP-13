<?php

namespace App\View\Components\Frontend;

use App\Models\Service;
use App\Support\FrontendCache;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Contact extends Component
{
    public string $reference;

    public Collection $services;

    public function __construct()
    {
        $reference = session('quote_reference');

        if (! is_string($reference) || $reference === '') {
            $reference = 'WEB-'.now()->format('dmY').'-'.strtoupper(Str::random(4));
            session(['quote_reference' => $reference]);
        }

        $this->reference = $reference;

        $this->services = Service::hydrate(
            FrontendCache::remember('contact.services', fn () => Service::query()
                ->where('is_active', true)
                ->orderBy('title')
                ->get(['id', 'title'])
                ->toArray())
        );
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.contact');
    }
}
