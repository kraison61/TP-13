<?php

namespace App\Support;

use App\Models\Blog;
use App\Models\Service;
use Illuminate\Support\Carbon;

class SitemapBuilder
{
    /**
     * @return list<array{loc: string, lastmod: string|null, changefreq: string, priority: string}>
     */
    public static function entries(): array
    {
        $entries = array_merge(
            self::staticEntries(),
            self::serviceEntries(),
            self::blogEntries(),
        );

        return array_values($entries);
    }

    public static function toXml(): string
    {
        $entries = self::entries();

        $urls = array_map(function (array $entry): string {
            $lastmod = $entry['lastmod']
                ? "\n    <lastmod>{$entry['lastmod']}</lastmod>"
                : '';

            return <<<XML
  <url>
    <loc>{$entry['loc']}</loc>{$lastmod}
    <changefreq>{$entry['changefreq']}</changefreq>
    <priority>{$entry['priority']}</priority>
  </url>
XML;
        }, $entries);

        $body = implode("\n", $urls);

        return '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n"
            .$body."\n"
            .'</urlset>';
    }

    /**
     * @return list<array{loc: string, lastmod: string|null, changefreq: string, priority: string}>
     */
    private static function staticEntries(): array
    {
        $pages = config('frontend.seo.sitemap.static', []);

        return array_map(function (array $page): array {
            return [
                'loc' => self::escape(route($page['route'])),
                'lastmod' => null,
                'changefreq' => $page['changefreq'],
                'priority' => $page['priority'],
            ];
        }, $pages);
    }

    /**
     * @return list<array{loc: string, lastmod: string|null, changefreq: string, priority: string}>
     */
    private static function serviceEntries(): array
    {
        return Service::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get(['slug', 'updated_at'])
            ->map(fn (Service $service): array => [
                'loc' => self::escape(route('frontend.services.show', $service->slug)),
                'lastmod' => self::formatLastmod($service->updated_at),
                'changefreq' => config('frontend.seo.sitemap.services.changefreq', 'monthly'),
                'priority' => config('frontend.seo.sitemap.services.priority', '0.8'),
            ])
            ->all();
    }

    /**
     * @return list<array{loc: string, lastmod: string|null, changefreq: string, priority: string}>
     */
    private static function blogEntries(): array
    {
        return Blog::query()
            ->whereNotNull('service_id')
            ->latest('updated_at')
            ->get(['slug', 'updated_at'])
            ->map(fn (Blog $blog): array => [
                'loc' => self::escape(route('blog.show', $blog->slug)),
                'lastmod' => self::formatLastmod($blog->updated_at),
                'changefreq' => config('frontend.seo.sitemap.blogs.changefreq', 'monthly'),
                'priority' => config('frontend.seo.sitemap.blogs.priority', '0.7'),
            ])
            ->all();
    }

    private static function formatLastmod(?Carbon $date): ?string
    {
        return $date?->toAtomString();
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
