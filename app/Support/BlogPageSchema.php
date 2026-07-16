<?php

namespace App\Support;

use App\Models\Blog;

class BlogPageSchema
{
    private const SITE = 'https://www.theeraphong.com';

    public static function graph(Blog $blog): array
    {
        $blogUrl = self::SITE.'/blogs/'.$blog->slug;

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                self::organization(),
                self::author(),
                self::webPage($blog, $blogUrl),
                self::blogPosting($blog, $blogUrl),
                self::breadcrumbList($blog, $blogUrl),
            ],
        ];
    }

    private static function organization(): array
    {
        $schema = config('schema');
        $logoUrl = BlogImageVariants::absoluteUrl($schema['logo']['path']);
        $logoSvgUrl = BlogImageVariants::absoluteUrl('images/tp-logo.svg');

        return [
            '@type' => 'GeneralContractor',
            '@id' => self::SITE.'#organization',
            'name' => config('company.legal_name'),
            'url' => self::SITE,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $logoUrl,
                'width' => $schema['logo']['width'],
                'height' => $schema['logo']['height'],
            ],
            'image' => $logoSvgUrl,
            'telephone' => '+66627188847',
            'priceRange' => '฿฿',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => '14 ต.บางกร่าง อ.เมืองนนทบุรี',
                'addressLocality' => 'นนทบุรี',
                'postalCode' => '11000',
                'addressCountry' => 'TH',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $schema['geo']['latitude'],
                'longitude' => $schema['geo']['longitude'],
            ],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => $schema['opening_hours_specification']['dayOfWeek'],
                'opens' => $schema['opening_hours_specification']['opens'],
                'closes' => $schema['opening_hours_specification']['closes'],
            ],
            'areaServed' => [
                'Bangkok',
                'Nonthaburi',
                'Pathum Thani',
                'Samut Prakan',
                'Chaiyaphum',
            ],
            'sameAs' => [
                'https://line.me/ti/p/~0627188847',
            ],
        ];
    }

    private static function author(): array
    {
        return [
            '@type' => 'Person',
            '@id' => self::SITE.'#author',
            'name' => 'ช่างรัก (Mr.Theeraphong Sarsuk)',
            'jobTitle' => 'ผู้เชี่ยวชาญด้านงานก่อสร้าง',
            'url' => self::SITE.'/about-us',
            'worksFor' => [
                '@id' => self::SITE.'#organization',
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

    private static function blogPosting(Blog $blog, string $blogUrl): array
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
                '@id' => self::SITE.'#author',
            ],
            'publisher' => [
                '@id' => self::SITE.'#organization',
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

    private static function breadcrumbList(Blog $blog, string $blogUrl): array
    {
        return [
            '@type' => 'BreadcrumbList',
            '@id' => "{$blogUrl}#breadcrumb",
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => self::SITE,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Blogs',
                    'item' => self::SITE.'/blogs',
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
