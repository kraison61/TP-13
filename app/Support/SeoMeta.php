<?php

namespace App\Support;

use App\Models\Blog;
use App\Models\Service;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeoMeta
{
    /**
     * @param  array<string, mixed>  $viewData
     * @return array<string, mixed>
     */
    public static function resolve(array $viewData): array
    {
        if (! empty($viewData['seo']) && is_array($viewData['seo'])) {
            return self::normalize($viewData['seo']);
        }

        if (
            ! empty($viewData['service'])
            && $viewData['service'] instanceof Service
            && filled($viewData['service']->slug)
        ) {
            return self::forService($viewData['service']);
        }

        if (! empty($viewData['blog']) && $viewData['blog'] instanceof Blog) {
            return self::forBlog($viewData['blog']);
        }

        return self::forRoute();
    }

    /**
     * @return array<string, mixed>
     */
    public static function forService(Service $service): array
    {
        $title = $service->meta_title ?: self::formatTitle($service->title);
        $description = self::cleanText(
            $service->meta_des ?: $service->plain_description ?: $service->title
        );

        $keywords = array_filter([
            $service->title,
            $service->category?->name,
            config('company.brand'),
        ]);

        return self::build([
            'title' => $title,
            'description' => $description,
            'keywords' => implode(', ', $keywords),
            'canonical' => route('frontend.services.show', $service->slug),
            'og_type' => 'website',
            'image' => self::serviceImageUrl($service),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function forBlog(Blog $blog): array
    {
        $title = self::formatTitle($blog->title);
        $description = self::cleanText($blog->description ?: $blog->title);

        $keywords = array_filter([
            $blog->title,
            $blog->service?->title,
            config('company.brand'),
        ]);

        return self::build([
            'title' => $title,
            'description' => $description,
            'keywords' => implode(', ', $keywords),
            'canonical' => route('blog.show', $blog->slug),
            'og_type' => 'article',
            'image' => self::blogImageUrl($blog),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function forRoute(): array
    {
        $routeName = Route::currentRouteName();
        $pages = config('frontend.seo.pages', []);

        if ($routeName && isset($pages[$routeName])) {
            return self::forPage($pages[$routeName]);
        }

        return self::defaults();
    }

    /**
     * @param  array<string, mixed>  $page
     * @return array<string, mixed>
     */
    public static function forPage(array $page): array
    {
        $title = isset($page['title'])
            ? self::formatTitle((string) $page['title'])
            : self::defaultTitle();

        return self::build([
            'title' => $title,
            'description' => self::cleanText($page['description'] ?? self::defaultDescription()),
            'keywords' => $page['keywords'] ?? null,
            'canonical' => url()->current(),
            'og_type' => 'website',
            'image' => $page['image'] ?? null,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function defaults(): array
    {
        return self::build([
            'title' => self::defaultTitle(),
            'description' => self::defaultDescription(),
            'keywords' => config('frontend.seo.defaults.keywords'),
            'canonical' => url()->current(),
            'og_type' => 'website',
            'image' => null,
        ]);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private static function build(array $overrides): array
    {
        $title = (string) ($overrides['title'] ?? self::defaultTitle());
        $description = self::cleanText((string) ($overrides['description'] ?? self::defaultDescription()));
        $canonical = (string) ($overrides['canonical'] ?? url()->current());
        $image = $overrides['image'] ?? null;
        $image = $image ?: self::defaultImage();
        $ogType = (string) ($overrides['og_type'] ?? 'website');

        return self::normalize([
            'title' => $title,
            'description' => $description,
            'keywords' => $overrides['keywords'] ?? null,
            'canonical' => $canonical,
            'robots' => config('frontend.seo.robots', 'index, follow'),
            'og' => [
                'type' => $ogType,
                'title' => $title,
                'description' => $description,
                'url' => $canonical,
                'image' => $image,
                'site_name' => config('frontend.seo.site_name') ?? config('company.brand'),
                'locale' => config('frontend.seo.locale', 'th_TH'),
            ],
            'twitter' => [
                'card' => config('frontend.seo.twitter_card', 'summary_large_image'),
                'title' => $title,
                'description' => $description,
                'image' => $image,
            ],
        ]);
    }

    /**
     * @param  array<string, mixed>  $seo
     * @return array<string, mixed>
     */
    private static function normalize(array $seo): array
    {
        $base = [
            'title' => self::defaultTitle(),
            'description' => self::defaultDescription(),
            'keywords' => config('frontend.seo.defaults.keywords'),
            'canonical' => url()->current(),
            'robots' => config('frontend.seo.robots', 'index, follow'),
            'og' => [
                'type' => 'website',
                'title' => self::defaultTitle(),
                'description' => self::defaultDescription(),
                'url' => url()->current(),
                'image' => self::defaultImage(),
                'site_name' => config('frontend.seo.site_name') ?? config('company.brand'),
                'locale' => config('frontend.seo.locale', 'th_TH'),
            ],
            'twitter' => [
                'card' => config('frontend.seo.twitter_card', 'summary_large_image'),
                'title' => self::defaultTitle(),
                'description' => self::defaultDescription(),
                'image' => self::defaultImage(),
            ],
        ];

        return array_replace_recursive($base, array_filter($seo, fn ($value) => $value !== null));
    }

    private static function formatTitle(string $pageTitle): string
    {
        $brand = config('company.brand');
        $suffix = config('frontend.seo.title_suffix');

        if ($suffix) {
            return "{$pageTitle} | {$brand} | {$suffix}";
        }

        return "{$pageTitle} | {$brand}";
    }

    private static function defaultTitle(): string
    {
        $brand = config('company.brand');
        $suffix = config('frontend.seo.title_suffix');

        if ($suffix) {
            return "{$brand} | {$suffix}";
        }

        return (string) $brand;
    }

    private static function defaultDescription(): string
    {
        return self::cleanText(
            (string) (config('frontend.seo.defaults.description')
                ?? config('frontend.schema.description')
                ?? config('company.brand'))
        );
    }

    private static function defaultImage(): string
    {
        $image = config('frontend.seo.defaults.image')
            ?? config('frontend.schema.image')
            ?? '/logo.png';

        return self::absoluteUrl((string) $image);
    }

    private static function serviceImageUrl(Service $service): ?string
    {
        if (! $service->img_1) {
            return null;
        }

        if (str_starts_with($service->img_1, 'http')) {
            return $service->img_1;
        }

        return Storage::disk('s3')->url($service->img_1).'?width=1200&format=webp&fit=cover';
    }

    private static function blogImageUrl(Blog $blog): ?string
    {
        if (! $blog->cover_image) {
            return null;
        }

        if (str_starts_with($blog->cover_image, 'http')) {
            return $blog->cover_image;
        }

        return Storage::disk('s3')->url($blog->cover_image).'?width=1200&format=webp&fit=cover';
    }

    private static function absoluteUrl(string $path): string
    {
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return rtrim((string) config('app.url'), '/').'/'.ltrim($path, '/');
    }

    private static function cleanText(?string $text): string
    {
        if (! $text) {
            return '';
        }

        $plain = trim(preg_replace('/\s+/u', ' ', strip_tags(html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8'))) ?? '');

        return Str::limit($plain, 160, '…');
    }
}
