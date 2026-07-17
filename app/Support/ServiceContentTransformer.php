<?php

namespace App\Support;

class ServiceContentTransformer
{
    public static function transform(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        $html = self::unwrapBlogContentWrapper($html);
        $html = self::cleanEditorArtifacts($html);
        $html = self::unwrapLayoutShell($html);
        $html = self::convertLegacyTailwind($html);
        $html = self::convertTailwindPatterns($html);
        $html = self::normalizeHeadings($html);
        $html = self::dedupeHeadings($html);
        $html = self::promoteQuestionIntro($html);
        $html = self::convertEmojiLists($html);
        $html = self::flattenListParagraphs($html);
        $html = self::fixBrokenMarkup($html);
        $html = self::wrapLooseText($html);
        $html = self::normalizePlainText($html);
        $html = self::addContentStructure($html);

        return BlogContentTransformer::transform($html);
    }

    private static function unwrapBlogContentWrapper(string $html): string
    {
        return preg_replace('/^<div class="blog-content">(.*)<\/div>$/s', '$1', $html) ?? $html;
    }

    private static function cleanEditorArtifacts(string $html): string
    {
        $html = preg_replace('/[\x{FEFF}\x{200B}\x{200C}\x{200D}]/u', '', $html) ?? $html;
        $html = preg_replace('/\s+data-(?:path-to-node|index-in-node|start|end|section-id)="[^"]*"/i', '', $html) ?? $html;
        $html = preg_replace('/\s+style="[^"]*"/i', '', $html) ?? $html;
        $html = preg_replace("/\s+style='[^']*'/i", '', $html) ?? $html;
        $html = preg_replace('/<span>\s*<\/span>/i', '', $html) ?? $html;
        $html = preg_replace('/<\/?response-element[^>]*>/i', '', $html) ?? $html;

        return preg_replace('/<!--[\s\S]*?-->/', '', $html) ?? $html;
    }

    private static function unwrapLayoutShell(string $html): string
    {
        $html = preg_replace('/<\/?main[^>]*>/i', '', $html) ?? $html;
        $html = preg_replace('/<\/?section[^>]*>/i', '', $html) ?? $html;

        if (preg_match('/^<div[^>]*class="[^"]*(?:lg:col-span-7|max-w-5xl)[^"]*"[^>]*>([\s\S]*)<\/div>$/i', $html, $matches)) {
            return trim($matches[1]);
        }

        return $html;
    }

    private static function convertLegacyTailwind(string $html): string
    {
        $html = preg_replace(
            '/<div class="grid md:grid-cols-2 gap-4">/',
            '<div class="service-feature-grid">',
            $html
        ) ?? $html;

        $html = preg_replace(
            '/<div class="bg-white rounded-2xl shadow p-5">/',
            '<div class="service-feature-card">',
            $html
        ) ?? $html;

        $html = preg_replace(
            '/<h([1-6])\s+class="[^"]*(?:text-brand|text-2xl|font-bold|font-semibold)[^"]*">(.*?)<\/h\1>/s',
            '<h$1>$2</h$1>',
            $html
        ) ?? $html;

        $html = preg_replace(
            '/<p\s+class="(?:mb-4 leading-relaxed|text-sm leading-relaxed)[^"]*">/',
            '<p>',
            $html
        ) ?? $html;

        return preg_replace('/\s+class="(?:text-brand|mb-4|leading-relaxed)[^"]*"/i', '', $html) ?? $html;
    }

    private static function convertTailwindPatterns(string $html): string
    {
        $html = preg_replace(
            '/<span class="inline-flex items-center gap-2 text-accent font-semibold tracking-\[0\.18em\] text-xs uppercase">\s*<span class="w-7 h-px bg-accent"><\/span>\s*(.*?)<\/span>/s',
            '<p class="service-kicker"><span class="service-kicker-line"></span>$1</p>',
            $html
        ) ?? $html;

        $html = preg_replace(
            '/<h2 class="mt-4 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900 leading-tight">(.*?)<\/h2>/s',
            '<h2>$1</h2>',
            $html
        ) ?? $html;

        $html = preg_replace(
            '/<h3 class="mt-10 text-xl font-bold text-navy-900">(.*?)<\/h3>/s',
            '<h3>$1</h3>',
            $html
        ) ?? $html;

        $html = preg_replace(
            '/<div class="mt-5 space-y-4 text-lg text-ink2 leading-relaxed">([\s\S]*?)<\/div>/',
            '<div class="lead">$1</div>',
            $html
        ) ?? $html;

        $html = preg_replace_callback(
            '/<ul class="mt-4 grid sm:grid-cols-2[^"]*">([\s\S]*?)<\/ul>/',
            static function (array $matches): string {
                $items = preg_replace(
                    '/<li class="flex items-start gap-2\.5">\s*<i class="bi bi-check-circle-fill text-accent mt-1 shrink-0"><\/i>\s*<span>([\s\S]*?)<\/span>\s*<\/li>/',
                    '<li><i class="bi bi-check-circle-fill"></i><span>$1</span></li>',
                    $matches[1]
                ) ?? $matches[1];

                return '<ul class="service-checklist service-checklist--grid">'.$items.'</ul>';
            },
            $html
        ) ?? $html;

        return preg_replace(
            '/<strong class="font-semibold text-navy-900">(.*?)<\/strong>/s',
            '<strong>$1</strong>',
            $html
        ) ?? $html;
    }

    private static function normalizeHeadings(string $html): string
    {
        for ($pass = 0; $pass < 3; $pass++) {
            $html = preg_replace(
                '/<h([1-6])>\s*(?:<span>\s*)*(?:<(?:b|strong)>|<b>)([\s\S]*?)<\/(?:b|strong)>(?:\s*<\/span>\s*)*<\/h\1>/s',
                '<h$1>$2</h$1>',
                $html
            ) ?? $html;

            $html = preg_replace(
                '/<h([1-6])>\s*<span>([\s\S]*?)<\/span>\s*<\/h\1>/s',
                '<h$1>$2</h$1>',
                $html
            ) ?? $html;
        }

        return preg_replace('/<h([1-6])>\s*(?:&nbsp;|\s)+/u', '<h$1>', $html) ?? $html;
    }

    private static function dedupeHeadings(string $html): string
    {
        $seen = [];

        return preg_replace_callback(
            '/<h([1-6])>([\s\S]*?)<\/h\1>/',
            static function (array $matches) use (&$seen): string {
                $key = mb_strtolower(trim(strip_tags($matches[2])));
                if ($key === '') {
                    return $matches[0];
                }

                if (isset($seen[$key])) {
                    return '';
                }

                $seen[$key] = true;

                return $matches[0];
            },
            $html
        ) ?? $html;
    }

    private static function promoteQuestionIntro(string $html): string
    {
        return preg_replace(
            '/^<p>([^<]{8,200}\?)<\/p>/u',
            '<h2>$1</h2>',
            ltrim($html),
            1
        ) ?? $html;
    }

    private static function convertEmojiLists(string $html): string
    {
        return preg_replace_callback(
            '/<ul>\s*((?:<li>[\s\S]*?<\/li>\s*)+)<\/ul>/i',
            static function (array $matches): string {
                if (! preg_match('/[\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}✅☑️]/u', $matches[1])) {
                    return $matches[0];
                }

                $items = preg_replace(
                    '/<li>\s*(?:<p>\s*)?(?:[\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}✅☑️]\s*)+(.*?(?:<\/p>\s*)?)<\/li>/u',
                    '<li><i class="bi bi-check-circle-fill"></i><span>$1</span></li>',
                    $matches[1]
                ) ?? $matches[1];

                $items = preg_replace('/<\/?p>/', '', $items) ?? $items;

                return '<ul class="service-checklist service-checklist--grid">'.$items.'</ul>';
            },
            $html
        ) ?? $html;
    }

    private static function flattenListParagraphs(string $html): string
    {
        $html = preg_replace('/<li>\s*<p>([\s\S]*?)<\/p>\s*<\/li>/', '<li>$1</li>', $html) ?? $html;

        return preg_replace('/<ol>\s*<li>\s*<p>/', '<ol><li>', $html) ?? $html;
    }

    private static function fixBrokenMarkup(string $html): string
    {
        $html = preg_replace('/class"table/i', 'class="table', $html) ?? $html;
        $html = preg_replace('/<table(?![^>]*class=)/i', '<table class="table table-hover"', $html) ?? $html;

        if (! preg_match('/<div class="table-responsive">[\s\S]*<table/i', $html) && preg_match('/<table/i', $html)) {
            $html = preg_replace('/(<table[^>]*>)/i', '<div class="table-responsive">$1', $html) ?? $html;
            $html = preg_replace('/(<\/table>)/i', '$1</div>', $html) ?? $html;
        }

        $html = preg_replace('/<\/ul>\s*<ul>/', '', $html) ?? $html;
        $html = preg_replace('/<p>\s*<\/p>/', '', $html) ?? $html;

        return preg_replace('/\R{3,}/', "\n\n", $html) ?? $html;
    }

    private static function wrapLooseText(string $html): string
    {
        if (! preg_match('/<[a-z]/i', $html)) {
            return $html;
        }

        return preg_replace('/^([^<]+?)(?=\s*<)/s', '<p>$1</p>', ltrim($html)) ?? $html;
    }

    private static function normalizePlainText(string $html): string
    {
        if (preg_match('/<[a-z][\s\S]*>/i', $html)) {
            return $html;
        }

        $paragraphs = preg_split('/\R{2,}/', $html) ?: [];
        $parts = [];

        foreach ($paragraphs as $paragraph) {
            $paragraph = trim($paragraph);
            if ($paragraph === '') {
                continue;
            }

            $parts[] = '<p>'.nl2br(e($paragraph), false).'</p>';
        }

        return implode("\n", $parts);
    }

    private static function addContentStructure(string $html): string
    {
        $html = preg_replace_callback(
            '/<div class="lead"><p>([^<]{8,200})<\/p><\/div>/u',
            static function (array $matches): string {
                return str_contains($matches[1], '?') ? '<h2>'.$matches[1].'</h2>' : $matches[0];
            },
            $html
        ) ?? $html;

        if (! str_contains($html, 'service-kicker')) {
            $html = '<p class="service-kicker"><span class="service-kicker-line"></span>รายละเอียดบริการ</p>'."\n".$html;
        }

        if (str_contains($html, 'class="lead"')) {
            return $html;
        }

        $html = preg_replace(
            '/(<p class="service-kicker"[^>]*>[\s\S]*?<\/p>\s*)<p>([^<]{8,200}\?)<\/p>/u',
            '$1<h2>$2</h2>',
            $html,
            1
        ) ?? $html;

        if (! str_contains($html, 'class="lead"')) {
            $html = preg_replace(
                '/(<p class="service-kicker"[^>]*>[\s\S]*?<\/p>\s*)<h2>([\s\S]*?)<\/h2>\s*<p>([\s\S]*?)<\/p>/',
                '$1<h2>$2</h2><div class="lead"><p>$3</p></div>',
                $html,
                1
            ) ?? $html;
        }

        if (! str_contains($html, 'class="lead"')) {
            $html = preg_replace(
                '/(<p class="service-kicker"[^>]*>[\s\S]*?<\/p>\s*)<h3>([\s\S]*?)<\/h3>\s*<p>([\s\S]*?)<\/p>/',
                '$1<h3>$2</h3><div class="lead"><p>$3</p></div>',
                $html,
                1
            ) ?? $html;
        }

        if (! str_contains($html, 'class="lead"')) {
            $html = preg_replace(
                '/(<p class="service-kicker"[^>]*>[\s\S]*?<\/p>\s*)<p>([\s\S]*?)<\/p>/',
                '$1<div class="lead"><p>$2</p></div>',
                $html,
                1
            ) ?? $html;
        }

        if (! str_contains($html, 'class="lead"')) {
            $html = preg_replace(
                '/^<p>([\s\S]*?)<\/p>/',
                '<div class="lead"><p>$1</p></div>',
                $html,
                1
            ) ?? $html;
        }

        return $html;
    }
}
