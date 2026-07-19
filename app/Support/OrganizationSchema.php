<?php

namespace App\Support;

use App\Models\Service;
use Illuminate\Support\Collection;

class OrganizationSchema
{
    /**
     * @param  array<string, mixed>  $extras
     * @return array<string, mixed>
     */
    public static function graph(array $extras = []): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                array_replace(self::node(), $extras),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function node(): array
    {
        $base = self::baseUrl();
        $schema = config('frontend.schema');
        $company = config('company');

        return [
            '@type' => 'GeneralContractor',
            '@id' => "{$base}/#organization",
            'name' => $company['name'],
            'alternateName' => $schema['alternate_name'],
            'url' => $base,
            'logo' => self::absoluteUrl($schema['logo']),
            'image' => self::absoluteUrl($schema['image']),
            'description' => $schema['description'],
            'telephone' => self::formatTelephone($company['phone']),
            'email' => $company['email'],
            'address' => [
                '@type' => 'PostalAddress',
                ...$schema['address'],
            ],
            'areaServed' => collect($schema['area_served'])
                ->map(fn (string $name) => [
                    '@type' => 'AdministrativeArea',
                    'name' => $name,
                ])
                ->all(),
            ...OrganizationLocationSchema::fields(),
            'sameAs' => array_values(array_filter([
                $company['line_official'] ?? null,
                $company['facebook'] ?? null,
            ])),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function extrasFromServices(Collection $services): array
    {
        if ($services->isEmpty() || $services->sum('review_count') <= 0) {
            return [];
        }

        return [
            'aggregateRating' => self::aggregateRating(
                self::weightedRating($services),
                $services->sum('review_count'),
            ),
        ];
    }

    public static function organizationId(): string
    {
        return self::baseUrl().'/#organization';
    }

    /**
     * Typed JSON-LD reference for cross-node links (GSC requires @type on references).
     *
     * @return array{@type: string, @id: string}
     */
    public static function reference(): array
    {
        return [
            '@type' => 'GeneralContractor',
            '@id' => self::organizationId(),
        ];
    }

    public static function baseUrl(): string
    {
        return rtrim((string) config('app.url'), '/');
    }

    /**
     * @return array<string, mixed>
     */
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

    private static function weightedRating(Collection $services): float
    {
        $totalReviews = $services->sum('review_count');

        if ($totalReviews <= 0) {
            return 5.0;
        }

        $weighted = $services->sum(
            fn (Service $service) => (float) $service->rating_value * (int) $service->review_count
        );

        return round($weighted / $totalReviews, 1);
    }

    private static function absoluteUrl(string $path): string
    {
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return self::baseUrl().'/'.ltrim($path, '/');
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
