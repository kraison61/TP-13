<?php

namespace App\Support;

use App\Models\Faq;
use App\Models\Service;
use Illuminate\Support\Collection;

class MainPageSchema
{
    public static function graph(Collection $services, Collection $faqs): array
    {
        if ($services->isEmpty() && $faqs->isEmpty()) {
            return [];
        }

        $base = rtrim((string) config('app.url'), '/');
        $graph = [];

        if ($services->isNotEmpty()) {
            $graph[] = self::servicesCatalog($base, $services);
        }

        if ($faqs->isNotEmpty()) {
            $graph[] = self::faqPage($base, $faqs);
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    private static function servicesCatalog(string $base, Collection $services): array
    {
        $schema = config('frontend.schema.service_catalog');

        return [
            '@type' => 'Service',
            '@id' => "{$base}/#services",
            'serviceType' => $schema['service_type'],
            'name' => $schema['name'],
            'description' => $schema['description'],
            'provider' => OrganizationSchema::reference(),
            'areaServed' => self::areaServed(),
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => $schema['name'],
                'itemListElement' => $services
                    ->values()
                    ->map(fn (Service $service, int $index) => [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'item' => self::serviceOffer($base, $service),
                    ])
                    ->all(),
            ],
        ];
    }

    private static function serviceOffer(string $base, Service $service): array
    {
        $item = [
            '@type' => 'Service',
            'name' => $service->title,
            'url' => route('frontend.services.show', $service->slug),
            'provider' => OrganizationSchema::reference(),
            'areaServed' => self::areaServed(),
        ];

        if ($service->review_count > 0) {
            $item['aggregateRating'] = self::aggregateRating(
                (float) $service->rating_value,
                (int) $service->review_count,
            );
        }

        $offer = [
            '@type' => 'Offer',
            'itemOffered' => $item,
            'priceCurrency' => 'THB',
        ];

        if ($servicePrice = self::resolveServicePrice($service)) {
            $offer['price'] = $servicePrice['price'];
            $offer['priceCurrency'] = $servicePrice['currency'];
        }

        return $offer;
    }

    /**
     * @return array{price: float, currency: string}|null
     */
    private static function resolveServicePrice(Service $service): ?array
    {
        $price = null;

        if ($service->relationLoaded('activePrice') && $service->activePrice?->price !== null) {
            $price = $service->activePrice;
        } elseif ($service->relationLoaded('lowestPrice') && $service->lowestPrice?->price !== null) {
            $price = $service->lowestPrice;
        } elseif ($service->relationLoaded('activePrices') && $service->activePrices->isNotEmpty()) {
            $price = $service->activePrices
                ->filter(fn ($activePrice) => $activePrice->price !== null)
                ->sortBy(fn ($activePrice) => (float) $activePrice->price)
                ->first();
        }

        if (! $price) {
            return null;
        }

        return [
            'price' => (float) $price->price,
            'currency' => $price->price_currency ?: 'THB',
        ];
    }

    private static function faqPage(string $base, Collection $faqs): array
    {
        return [
            '@type' => 'FAQPage',
            '@id' => "{$base}/#faq",
            'mainEntity' => $faqs
                ->map(fn (Faq $faq) => [
                    '@type' => 'Question',
                    'name' => $faq->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => self::plainAnswer($faq->answer),
                    ],
                ])
                ->all(),
        ];
    }

    private static function areaServed(): array
    {
        return [
            '@type' => 'AdministrativeArea',
            'name' => config('frontend.schema.area_served_label'),
        ];
    }

    private static function aggregateRating(float $ratingValue, int $reviewCount): array
    {
        return [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) round($ratingValue, 1),
            'reviewCount' => (string) $reviewCount,
            'bestRating' => '5',
            'worstRating' => '1',
        ];
    }

    private static function plainAnswer(string $answer): string
    {
        $text = trim(strip_tags($answer));

        return str_replace(["\r\n", "\r"], "\n", $text);
    }
}
