<?php

namespace App\Support;

use App\Models\Blog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProjectSchema
{
    public static function itemList(Collection $blogs): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'ผลงานก่อสร้าง',
            'numberOfItems' => $blogs->count(),
            'itemListElement' => $blogs->values()->map(
                fn (Blog $blog, int $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'item' => self::blogItem($blog),
                ]
            )->all(),
        ];
    }

    private static function blogItem(Blog $blog): array
    {
        $item = [
            '@type' => 'Article',
            'headline' => $blog->title,
            'url' => route('blog.show', $blog->slug),
        ];

        if ($blog->description) {
            $item['description'] = strip_tags($blog->description);
        }

        if ($coverUrl = self::coverUrl($blog)) {
            $item['image'] = $coverUrl;
        }

        if ($blog->relationLoaded('service') && $blog->service) {
            $item['about'] = [
                '@type' => 'Service',
                'name' => $blog->service->title,
            ];
        }

        return $item;
    }

    private static function coverUrl(Blog $blog): ?string
    {
        if (! $blog->cover_image) {
            return null;
        }

        if (str_starts_with($blog->cover_image, 'http')) {
            return $blog->cover_image;
        }

        return Storage::disk('s3')->url($blog->cover_image).'?width=900&format=webp&fit=cover';
    }
}
