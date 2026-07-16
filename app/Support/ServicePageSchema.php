<?php

namespace App\Support;

use App\Models\Faq;
use App\Models\Service;
use App\Models\ServicePrice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ServicePageSchema
{
    public static function graph(Service $service): array
    {
        $base = rtrim((string) config('app.url'), '/');
        $serviceUrl = route('frontend.services.show', $service->slug);

        $graph = [
            self::organization($base),
            self::serviceProduct($base, $service, $serviceUrl),
        ];

        if ($service->relationLoaded('faqs') && $service->faqs->isNotEmpty()) {
            $graph[] = self::faqPage($base, $service);
        }

        $graph[] = self::breadcrumbList($base, $service, $serviceUrl);

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    private static function organization(string $base): array
    {
        $company = config('company');
        $schema = config('frontend.schema');

        return [
            '@type' => 'GeneralContractor',
            '@id' => "{$base}/#organization",
            'name' => $company['name'],
            'url' => $base,
            'telephone' => self::formatTelephone($company['phone']),
            'image' => self::absoluteUrl($schema['image']),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => self::absoluteUrl($schema['logo']),
            ],
            'address' => [
                '@type' => 'PostalAddress',
                ...$schema['address'],
            ],
            ...OrganizationLocationSchema::fields(),
        ];
    }

    private static function serviceProduct(string $base, Service $service, string $serviceUrl): array
    {
        $node = [
            '@type' => ['Service', 'Product'],
            '@id' => "{$serviceUrl}/#service",
            'name' => $service->title,
            'serviceType' => $service->schema_type ?: $service->title,
            'description' => $service->plain_description ?: $service->title,
            'url' => $serviceUrl,
            'brand' => [
                '@type' => 'Brand',
                'name' => config('frontend.schema.alternate_name'),
            ],
            'sku' => 'TP-SRV-'.$service->id,
            'provider' => [
                '@id' => "{$base}/#organization",
            ],
            'areaServed' => collect(config('frontend.schema.area_served'))
                ->map(fn (string $name) => [
                    '@type' => 'AdministrativeArea',
                    'name' => $name,
                ])
                ->all(),
        ];

        if ($categoryName = $service->category?->name) {
            $node['category'] = $categoryName;
        }

        if ($imageUrl = self::serviceImageUrl($service)) {
            $node['image'] = $imageUrl;
        }

        $offers = self::buildOffers($service, $serviceUrl);
        if ($offers !== []) {
            $node['offers'] = $offers;
        }

        if ($service->review_count > 0) {
            $node['aggregateRating'] = self::aggregateRating(
                (float) $service->rating_value,
                (int) $service->review_count,
            );
        }

        return $node;
    }

    private static function buildOffers(Service $service, string $serviceUrl): array
    {
        $prices = $service->relationLoaded('activePrices')
            ? $service->activePrices
            : collect();

        $offers = [];

        $startingOffer = self::startingOffer($service, $serviceUrl, $prices);
        if ($startingOffer !== null) {
            $offers[] = $startingOffer;
        }

        foreach ($prices as $price) {
            $offer = self::priceOffer($service, $serviceUrl, $price);
            if ($offer !== null) {
                $offers[] = $offer;
            }
        }

        return $offers;
    }

    private static function startingOffer(Service $service, string $serviceUrl, Collection $prices): ?array
    {
        $lowest = $prices
            ->filter(fn (ServicePrice $price) => $price->price !== null)
            ->sortBy(fn (ServicePrice $price) => (float) $price->price)
            ->first();

        if (! $lowest) {
            return null;
        }

        $offer = self::offerBase($serviceUrl, $lowest);
        $offer['name'] = "{$service->title} — ราคาเริ่มต้น";

        $spec = self::priceSpecification($lowest);
        if ($spec !== null) {
            $offer['priceSpecification'] = $spec;
        }

        return $offer;
    }

    private static function priceOffer(Service $service, string $serviceUrl, ServicePrice $price): ?array
    {
        if (in_array($price->price_type, ['call_to_ask', 'variable'], true) && $price->price === null) {
            return null;
        }

        $offer = self::offerBase($serviceUrl, $price);
        $offer['name'] = "{$service->title} — {$price->name}";

        if ($price->sku) {
            $offer['sku'] = $price->sku;
        }

        $spec = self::priceSpecification($price);
        if ($spec !== null) {
            $offer['priceSpecification'] = $spec;
        }

        return $offer;
    }

    private static function offerBase(string $serviceUrl, ServicePrice $price): array
    {
        $validUntil = '2027-12-31';
        if ($price->price_valid_until) {
            $validUntil = \Illuminate\Support\Carbon::parse($price->price_valid_until)->format('Y-m-d');
        }

        $offer = [
            '@type' => 'Offer',
            'url' => $serviceUrl,
            'priceCurrency' => $price->price_currency ?: 'THB',
            'availability' => $price->availability ?: 'https://schema.org/InStock',
            'itemCondition' => 'https://schema.org/NewCondition',
            'priceValidUntil' => $validUntil,
        ];

        if ($price->price !== null) {
            $offer['price'] = (float) $price->price;
        }

        return $offer;
    }

    private static function priceSpecification(ServicePrice $price): ?array
    {
        if ($price->price === null) {
            return null;
        }

        $spec = [
            '@type' => 'UnitPriceSpecification',
            'priceCurrency' => $price->price_currency ?: 'THB',
            'minPrice' => (float) $price->price,
        ];

        if ($price->unit) {
            $spec['unitText'] = $price->unit;
            if ($unitCode = self::unitCode($price->unit)) {
                $spec['unitCode'] = $unitCode;
            }
        }

        if ($price->max_price !== null && (float) $price->max_price > (float) $price->price) {
            $spec['maxPrice'] = (float) $price->max_price;
        }

        return $spec;
    }

    private static function faqPage(string $base, Service $service): array
    {
        $serviceUrl = route('frontend.services.show', $service->slug);

        return [
            '@type' => 'FAQPage',
            '@id' => "{$serviceUrl}/#faq",
            'mainEntity' => $service->faqs
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

    private static function breadcrumbList(string $base, Service $service, string $serviceUrl): array
    {
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'หน้าแรก',
                    'item' => $base,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $service->category?->name ?? 'บริการ',
                    'item' => route('frontend.services.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $service->title,
                    'item' => $serviceUrl,
                ],
            ],
        ];
    }

    private static function serviceImageUrl(Service $service): ?string
    {
        if (! $service->img_1) {
            return null;
        }

        if (str_starts_with($service->img_1, 'http')) {
            return $service->img_1;
        }

        return Storage::disk('s3')->url($service->img_1).'?width=900&format=webp&fit=cover';
    }

    private static function unitCode(string $unit): ?string
    {
        $normalized = trim($unit);

        return match ($normalized) {
            'เมตร', 'ม.', 'ม' => 'MTR',
            'คิว' => 'MTQ',
            'ตร.ม.' => 'MTK',
            default => null,
        };
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

    private static function absoluteUrl(string $path): string
    {
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return rtrim((string) config('app.url'), '/').'/'.ltrim($path, '/');
    }

    private static function formatTelephone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? $phone;

        if (str_starts_with($digits, '0') && strlen($digits) === 10) {
            return '+66-'.substr($digits, 1, 2).'-'.substr($digits, 3, 3).'-'.substr($digits, 6);
        }

        return $phone;
    }
}
