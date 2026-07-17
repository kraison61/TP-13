<?php

namespace App\Support;

use App\Models\Blog;

class BlogPageSchema
{
    public static function graph(Blog $blog): array
    {
        $base = OrganizationSchema::baseUrl();
        $blogUrl = route('blog.show', $blog->slug);

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                self::author($base),
                self::webPage($blog, $blogUrl),
                self::blogPosting($blog, $blogUrl, $base),
                self::breadcrumbList($blog, $blogUrl, $base),
            ],
        ];
    }

    private static function author(string $base): array
    {
        return [
            '@type' => 'Person',
            '@id' => "{$base}/#author",
            'name' => 'ช่างรัก (Mr.Theeraphong Sarsuk)',
            'jobTitle' => 'ผู้เชี่ยวชาญด้านงานก่อสร้าง',
            'url' => route('about-us'),
            'worksFor' => [
                '@id' => OrganizationSchema::organizationId(),
            ],
            'knowsAbout' => [
                'รับเหมาก่อสร้างกำแพงกันดิน',
                'รับสร้างรั้วบ้าน',
                'งานโยธา',
            ],
        ];
    }

    private static function webPage(Blog $blog, string $blogUrl): array
    {
        return [
            '@type' => 'WebPage',
            '@id' => "{$blogUrl}#webpage",
            'url' => $blogUrl,
            'name' => $blog->title,
            'inLanguage' => 'th',
        ];
    }

    private static function blogPosting(Blog $blog, string $blogUrl, string $base): array
    {
        $node = [
            '@type' => 'BlogPosting',
            '@id' => "{$blogUrl}#article",
            'mainEntityOfPage' => [
                '@id' => "{$blogUrl}#webpage",
            ],
            'headline' => $blog->title,
            'description' => $blog->description,
            'author' => [
                '@id' => "{$base}/#author",
            ],
            'publisher' => [
                '@id' => OrganizationSchema::organizationId(),
            ],
            'datePublished' => $blog->created_at
                ->setTimezone('Asia/Bangkok')
                ->toIso8601String(),
            'dateModified' => $blog->updated_at
                ->setTimezone('Asia/Bangkok')
                ->toIso8601String(),
            'inLanguage' => 'th',
            'wordCount' => self::wordCount($blog),
            'keywords' => self::keywords($blog),
        ];

        $images = BlogImageVariants::schemaImageObjects($blog->cover_image);
        if ($images !== []) {
            $node['image'] = $images;
        }

        if ($blog->relationLoaded('service') && $blog->service?->relationLoaded('category')) {
            $section = $blog->service->category?->name;
            if ($section) {
                $node['articleSection'] = $section;
            }
        }

        return $node;
    }

    private static function breadcrumbList(Blog $blog, string $blogUrl, string $base): array
    {
        return [
            '@type' => 'BreadcrumbList',
            '@id' => "{$blogUrl}#breadcrumb",
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => $base,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Blogs',
                    'item' => route('blog.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $blog->title,
                ],
            ],
        ];
    }

    /**
     * Thai has no reliable ASCII word boundaries; approximate word count as chars / 4.
     */
    private static function wordCount(Blog $blog): int
    {
        $text = trim(strip_tags((string) $blog->content));

        if ($text === '') {
            return 0;
        }

        return (int) max(1, ceil(mb_strlen($text) / 4));
    }

    private static function keywords(Blog $blog): string
    {
        $terms = [];

        if ($blog->relationLoaded('service') && $blog->service?->relationLoaded('category')) {
            $category = $blog->service->category?->name;
            if ($category) {
                $terms[] = $category;
            }
        }

        $terms = array_merge($terms, self::titleDerivedTerms($blog->title));

        return implode(', ', array_values(array_unique(array_filter($terms))));
    }

    /**
     * @return list<string>
     */
    private static function titleDerivedTerms(string $title): array
    {
        $normalized = preg_replace('/\s*\([^)]*\)\s*/u', ' ', $title) ?? $title;
        $normalized = preg_replace('/[&\/\\|,;:]+/u', ' ', $normalized) ?? $normalized;
        $parts = preg_split('/\s+/u', trim($normalized), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        return array_values(array_filter(
            $parts,
            fn (string $part) => mb_strlen($part) >= 2,
        ));
    }
}
