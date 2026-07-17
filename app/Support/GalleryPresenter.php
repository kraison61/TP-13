<?php

namespace App\Support;

use App\Models\ImageUpload;
use App\Models\ProjectPhase;
use App\Models\Service;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryPresenter
{
    /**
     * @return Collection<int, ImageUpload>
     */
    public static function firstPerLocation(?int $limit = null): Collection
    {
        $query = ImageUpload::query()
            ->firstPerLocation()
            ->with(['imageable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    Service::class => ['category'],
                    ProjectPhase::class => ['project'],
                ]);
            }])
            ->orderByDesc('created_at');

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * @param  Collection<int, ImageUpload>  $images
     * @return list<array{slug: string, title: string, category: string, province: string, specs: string, image: string, alt: string}>
     */
    public static function toProjects(Collection $images): array
    {
        return $images
            ->map(fn (ImageUpload $image) => self::formatProject($image))
            ->values()
            ->all();
    }

    /**
     * @param  list<array{category: string}>  $projects
     * @return list<string>
     */
    public static function categories(array $projects): array
    {
        $categories = collect($projects)
            ->pluck('category')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        return array_merge(['ทั้งหมด'], $categories);
    }

    /**
     * @return array{slug: string, title: string, category: string, province: string, specs: string, image: string, alt: string}
     */
    public static function formatProject(ImageUpload $image): array
    {
        $location = trim((string) $image->location);
        [$category, $specs] = self::resolveMeta($image);

        return [
            'slug' => Str::slug($location) ?: 'location-'.$image->id,
            'title' => $location,
            'category' => $category,
            'province' => $location,
            'specs' => $specs,
            'image' => self::imageUrl($image->img_url),
            'alt' => $location,
        ];
    }

    /**
     * @return array{0: string, 1: string}
     */
    private static function resolveMeta(ImageUpload $image): array
    {
        $imageable = $image->imageable;

        if ($imageable instanceof Service) {
            return [
                $imageable->category?->name ?? 'อื่นๆ',
                $imageable->title ?? '',
            ];
        }

        if ($imageable instanceof ProjectPhase) {
            return [
                'โครงการ',
                $imageable->title ?: ($imageable->project?->name ?? ''),
            ];
        }

        return ['อื่นๆ', ''];
    }

    public static function imageUrl(string $path, int $width = 800): string
    {
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return Storage::disk('s3')->url($path)."?width={$width}&format=webp&fit=cover";
    }

    public static function resolveLocationFromSlug(string $slug): ?string
    {
        if (preg_match('/^location-(\d+)$/', $slug, $matches)) {
            return ImageUpload::find((int) $matches[1])?->location;
        }

        return ImageUpload::query()
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->pluck('location')
            ->first(fn (string $location) => Str::slug($location) === $slug);
    }

    /**
     * @return Collection<int, ImageUpload>
     */
    public static function imagesForLocation(string $location): Collection
    {
        return ImageUpload::query()
            ->where('location', $location)
            ->with(['imageable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    Service::class => ['category'],
                    ProjectPhase::class => ['project'],
                ]);
            }])
            ->orderBy('id')
            ->get();
    }

    /**
     * @return array{
     *     proj: array{title: string, category: string, province: string, description: string, slug: string},
     *     stats: list<array{label: string, value: string}>,
     *     photos: list<array{src: string, thumb: string, caption: string, span: string}>
     * }
     */
    public static function formatDetail(string $location): array
    {
        $images = self::imagesForLocation($location);
        $first = $images->first();
        [$category, $specs] = $first ? self::resolveMeta($first) : ['อื่นๆ', ''];
        $total = $images->count();

        $dates = $images
            ->map(fn (ImageUpload $image) => $image->worked_date ?? $image->created_at)
            ->filter();

        $stats = array_values(array_filter([
            ['label' => 'จำนวนภาพ', 'value' => number_format($total).' ภาพ'],
            $specs ? ['label' => 'บริการ', 'value' => $specs] : null,
            ['label' => 'หมวดหมู่', 'value' => $category],
            $dates->isNotEmpty() ? ['label' => 'วันที่ถ่ายล่าสุด', 'value' => $dates->max()->translatedFormat('j M Y')] : null,
            $dates->count() > 1 ? ['label' => 'วันที่ถ่ายแรก', 'value' => $dates->min()->translatedFormat('j M Y')] : null,
            ['label' => 'สถานที่', 'value' => $location],
        ]));

        return [
            'proj' => [
                'title' => $location,
                'category' => $category,
                'province' => $location,
                'description' => $specs
                    ? "ภาพบันทึกหน้างาน{$location} — {$specs}"
                    : "ภาพบันทึกหน้างาน{$location}",
                'slug' => Str::slug($location) ?: 'location-'.($first?->id ?? 0),
            ],
            'stats' => $stats,
            'photos' => $images->values()->map(
                fn (ImageUpload $image, int $index) => self::formatPhoto($image, $index)
            )->all(),
        ];
    }

    /**
     * @return array{src: string, thumb: string, caption: string, span: string}
     */
    private static function formatPhoto(ImageUpload $image, int $index): array
    {
        [, $specs] = self::resolveMeta($image);
        $caption = $specs;

        if (! $caption && $image->worked_date) {
            $caption = $image->worked_date->translatedFormat('j M Y');
        }

        if (! $caption) {
            $caption = trim((string) $image->location);
        }

        return [
            'src' => self::imageUrl($image->img_url, 1200),
            'thumb' => self::imageUrl($image->img_url, 160),
            'caption' => $caption,
            'span' => self::gridSpan($index),
        ];
    }

    private static function gridSpan(int $index): string
    {
        return match ($index) {
            0 => 'lg:col-span-2 lg:row-span-2',
            1 => 'lg:row-span-2',
            5, 7 => 'lg:col-span-2',
            default => '',
        };
    }
}
