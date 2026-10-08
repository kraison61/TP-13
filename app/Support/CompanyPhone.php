<?php

namespace App\Support;

use App\Models\Service;

final class CompanyPhone
{
    /**
     * Site-wide default phone (061-563-9228).
     *
     * @return array{phone: string, phone_formatted: string}
     */
    public static function default(): array
    {
        return [
            'phone' => (string) config('company.phone'),
            'phone_formatted' => (string) config('company.phone_formatted'),
        ];
    }

    /**
     * Resolve phone from the current frontend request (home + service page aware).
     *
     * @return array{phone: string, phone_formatted: string}
     */
    public static function forCurrentRequest(): array
    {
        return once(function () {
            if (request()->routeIs('home')) {
                return self::legacy();
            }

            if (! request()->routeIs('frontend.services.show')) {
                return self::default();
            }

            $slug = request()->route('slug');
            if (! is_string($slug) || $slug === '') {
                return self::default();
            }

            return self::forServiceSlug($slug);
        });
    }

    /**
     * @return array{phone: string, phone_formatted: string}
     */
    public static function forService(?Service $service): array
    {
        if (! $service) {
            return self::default();
        }

        return self::forServiceSlug($service->slug);
    }

    /**
     * @return array{phone: string, phone_formatted: string}
     */
    public static function forServiceSlug(?string $slug): array
    {
        if ($slug && self::isLegacyServiceSlug($slug)) {
            return self::legacy();
        }

        return self::default();
    }

    /**
     * Previous number kept on home and selected civil service pages.
     *
     * @return array{phone: string, phone_formatted: string}
     */
    public static function legacy(): array
    {
        $legacy = config('company.legacy_phone', []);

        return [
            'phone' => (string) ($legacy['phone'] ?? config('company.phone')),
            'phone_formatted' => (string) ($legacy['phone_formatted'] ?? config('company.phone_formatted')),
        ];
    }

    public static function isLegacyServiceSlug(?string $slug): bool
    {
        if (! $slug) {
            return false;
        }

        $slugs = config('company.legacy_phone.service_slugs', []);

        return in_array($slug, $slugs, true);
    }
}
