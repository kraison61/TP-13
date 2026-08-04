<?php

namespace App\View\Components\Frontend;

use App\Models\Service;
use App\Support\CompanyPhone;
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

    /** @var array{phone: string, phone_formatted: string} */
    public array $defaultPhone;

    public function __construct()
    {
        $reference = session('quote_reference');

        if (! is_string($reference) || $reference === '') {
            $reference = 'WEB-'.now()->format('dmY').'-'.strtoupper(Str::random(4));
            session(['quote_reference' => $reference]);
        }

        $this->reference = $reference;
        $this->defaultPhone = CompanyPhone::forCurrentRequest();

        $this->services = Service::hydrate(
            FrontendCache::remember('contact.services.v3', function () {
                return Service::query()
                    ->with('category:id,slug')
                    ->where('is_active', true)
                    ->orderBy('title')
                    ->get(['id', 'title', 'service_category_id'])
                    ->map(function (Service $service) {
                        $phone = CompanyPhone::forService($service);

                        return [
                            'id' => $service->id,
                            'title' => $service->title,
                            'contact_phone' => $phone['phone'],
                            'contact_phone_formatted' => $phone['phone_formatted'],
                        ];
                    })
                    ->all();
            })
        );
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.contact');
    }
}
