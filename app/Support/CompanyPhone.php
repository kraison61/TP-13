<?php

namespace App\Support;

use App\Models\Service;
use App\Models\ServiceCategory;

final class CompanyPhone
{
    /**
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
     * Resolve phone from the current frontend request (service page aware).
     *
     * @return array{phone: string, phone_formatted: string}
     */
    public static function forCurrentRequest(): array
    {
        return once(function () {
            if (! request()->routeIs('frontend.services.show')) {
                return self::default();
            }

            $slug = request()->route('slug');
            if (! is_string($slug) || $slug === '') {
                return self::default();
            }

            $service = Service::query()
                ->with('category:id,slug')
                ->where('slug', $slug)
                ->where('is_active', true)
                ->first(['id', 'service_category_id']);

            return self::forService($service);
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

        $category = $service->relationLoaded('category')
            ? $service->category
            : $service->category()->first();

        return self::forCategory($category);
    }

    /**
     * @return array{phone: string, phone_formatted: string}
     */
    public static function forCategory(?ServiceCategory $category): array
    {
        if (! $category) {
            return self::default();
        }

        return self::forCategorySlug($category->slug);
    }

    /**
     * @return array{phone: string, phone_formatted: string}
     */
    public static function forCategorySlug(?string $slug): array
    {
        if ($slug && self::isDepartmentCategorySlug($slug)) {
            return self::department();
        }

        return self::default();
    }

    /**
     * Phone for CCTV / electrical cabling / network / computer services.
     *
     * @return array{phone: string, phone_formatted: string}
     */
    public static function department(): array
    {
        $dept = config('company.department_phone', []);

        return [
            'phone' => (string) ($dept['phone'] ?? config('company.phone')),
            'phone_formatted' => (string) ($dept['phone_formatted'] ?? config('company.phone_formatted')),
        ];
    }

    public static function isDepartmentCategorySlug(?string $slug): bool
    {
        if (! $slug) {
            return false;
        }

        $slugs = config('company.department_phone.category_slugs', []);

        return in_array($slug, $slugs, true);
    }
}
