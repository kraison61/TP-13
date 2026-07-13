<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMXPath;

class BlogContentTransformer
{
    /** @var array<string, string> */
    private const FA_TO_BI = [
        'fa-flag-checkered' => 'bi-flag-fill',
        'fa-map-marker' => 'bi-geo-alt-fill',
        'fa-calendar' => 'bi-calendar3',
        'fa-wrench' => 'bi-wrench-adjustable',
        'fa-arrows-h' => 'bi-arrows-expand',
        'fa-arrows-v' => 'bi-arrows-vertical',
        'fa-anchor' => 'bi-link-45deg',
        'fa-link' => 'bi-link-45deg',
        'fa-exclamation-triangle' => 'bi-exclamation-triangle-fill',
        'fa-cogs' => 'bi-gear-fill',
        'fa-question-circle' => 'bi-question-circle-fill',
        'fa-shield' => 'bi-shield-check',
        'fa-info-circle' => 'bi-info-circle-fill',
        'fa-calculator' => 'bi-calculator',
        'fa-level-down' => 'bi-arrow-down',
        'fa-leaf' => 'bi-flower1',
        'fa-folder-open' => 'bi-folder2-open',
        'fa-check-circle' => 'bi-check-circle-fill',
        'fa-phone' => 'bi-telephone-fill',
        'fa-envelope' => 'bi-envelope-fill',
        'fa-camera' => 'bi-camera-fill',
        'fa-home' => 'bi-house-fill',
        'fa-money' => 'bi-cash-coin',
        'fa-thumbs-up' => 'bi-hand-thumbs-up-fill',
        'fa-star' => 'bi-star-fill',
        'fa-clock-o' => 'bi-clock',
        'fa-clock' => 'bi-clock',
        'fa-truck' => 'bi-truck',
        'fa-users' => 'bi-people-fill',
        'fa-handshake-o' => 'bi-handshake',
        'fa-handshake' => 'bi-handshake',
        'fa-building' => 'bi-building',
        'fa-tint' => 'bi-droplet-fill',
        'fa-bolt' => 'bi-lightning-charge-fill',
        'fa-picture-o' => 'bi-image',
        'fa-image' => 'bi-image',
        'fa-arrow-right' => 'bi-arrow-right',
        'fa-list' => 'bi-list-ul',
        'fa-table' => 'bi-table',
        'fa-ruler' => 'bi-rulers',
        'fa-cube' => 'bi-box',
        'fa-certificate' => 'bi-award-fill',
        'fa-lightbulb-o' => 'bi-lightbulb-fill',
        'fa-lightbulb' => 'bi-lightbulb-fill',
        'fa-comments' => 'bi-chat-dots-fill',
        'fa-heart' => 'bi-heart-fill',
        'fa-tools' => 'bi-tools',
        'fa-hammer' => 'bi-hammer',
        'fa-cog' => 'bi-gear-fill',
    ];

    public static function transform(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        $html = self::stripEditorAttributes($html);
        $html = self::stripInlineStyles($html);

        if (! self::looksLikeBootstrap($html)) {
            return self::wrapSimpleContent($html);
        }

        return self::transformBootstrapHtml($html);
    }

    private static function stripEditorAttributes(string $html): string
    {
        return preg_replace('/\s+data-[a-z0-9-]+="[^"]*"/i', '', $html) ?? $html;
    }

    private static function stripInlineStyles(string $html): string
    {
        $html = preg_replace('/\s+style="[^"]*"/i', '', $html) ?? $html;

        return preg_replace("/\s+style='[^']*'/i", '', $html) ?? $html;
    }

    private static function looksLikeBootstrap(string $html): bool
    {
        return (bool) preg_match('/\b(container-fluid|col-md-|list-group|panel-|alert-|page-header|btn btn-)\b/', $html);
    }

    private static function wrapSimpleContent(string $html): string
    {
        if (preg_match('/^<div class="blog-content">/s', $html)) {
            return $html;
        }

        return '<div class="blog-content">'.$html.'</div>';
    }

    private static function transformBootstrapHtml(string $html): string
    {
        $html = preg_replace('/^<div class="blog-content">(.*)<\/div>$/s', '$1', $html) ?? $html;

        libxml_use_internal_errors(true);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML(
            '<?xml encoding="UTF-8"><div id="blog-root">'.$html.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $xpath = new DOMXPath($dom);
        $root = $dom->getElementById('blog-root');

        if (! $root instanceof DOMElement) {
            return self::wrapSimpleContent($html);
        }

        self::removeAttributes($xpath, '//@style');
        self::removeAttributes($xpath, '//@data-path-to-node');
        self::removeAttributes($xpath, '//@data-index-in-node');

        self::removeDuplicatePageHeaderTitle($xpath);
        self::convertFontAwesomeIcons($xpath);
        self::unwrapContainers($root);
        self::normalizeLayoutClasses($xpath);
        self::flattenSingleColumnGrids($xpath);
        self::flattenContentGrids($xpath);

        $inner = '';
        foreach ($root->childNodes as $child) {
            $inner .= $dom->saveHTML($child);
        }

        $inner = preg_replace('/\s+>/', '>', $inner) ?? $inner;
        $inner = preg_replace('/>\s+</', '><', $inner) ?? $inner;

        return '<div class="blog-content">'.trim($inner).'</div>';
    }

    private static function removeAttributes(DOMXPath $xpath, string $query): void
    {
        $attr = ltrim($query, '/@');

        foreach ($xpath->query($query) as $node) {
            if ($node instanceof DOMElement) {
                $node->removeAttribute($attr);
            }
        }
    }

    private static function removeDuplicatePageHeaderTitle(DOMXPath $xpath): void
    {
        foreach ($xpath->query('//div[contains(@class,"page-header")]//h1') as $h1) {
            $h1->parentNode?->removeChild($h1);
        }

        foreach ($xpath->query('//div[contains(@class,"page-header")]') as $header) {
            if ($header instanceof DOMElement) {
                $header->setAttribute('class', 'blog-meta');
            }
        }
    }

    private static function convertFontAwesomeIcons(DOMXPath $xpath): void
    {
        foreach ($xpath->query('//i[contains(@class,"fa")]') as $icon) {
            if (! $icon instanceof DOMElement) {
                continue;
            }

            $classes = preg_split('/\s+/', trim($icon->getAttribute('class'))) ?: [];
            $biClass = 'bi-circle-fill';

            foreach ($classes as $class) {
                if (isset(self::FA_TO_BI[$class])) {
                    $biClass = self::FA_TO_BI[$class];
                    break;
                }
            }

            $icon->setAttribute('class', 'bi '.$biClass);
        }
    }

    private static function normalizeLayoutClasses(DOMXPath $xpath): void
    {
        foreach ($xpath->query('//div[contains(@class,"row")]') as $row) {
            if (! $row instanceof DOMElement) {
                continue;
            }

            $class = $row->getAttribute('class');
            $row->setAttribute(
                'class',
                str_contains($class, 'well') || self::isInsideWell($row)
                    ? 'blog-cta-actions'
                    : 'blog-grid'
            );
        }

        foreach ($xpath->query('//div[contains(@class,"col-")]') as $col) {
            if ($col instanceof DOMElement) {
                $col->setAttribute('class', 'blog-grid-col');
            }
        }
    }

    private static function isInsideWell(DOMElement $element): bool
    {
        for ($node = $element->parentNode; $node instanceof DOMElement; $node = $node->parentNode) {
            if (str_contains($node->getAttribute('class'), 'well')) {
                return true;
            }
        }

        return false;
    }

    private static function unwrapContainers(DOMElement $root): void
    {
        for ($pass = 0; $pass < 5; $pass++) {
            $changed = false;

            foreach ($root->getElementsByTagName('div') as $div) {
                if (! $div instanceof DOMElement) {
                    continue;
                }

                $class = $div->getAttribute('class');

                if (
                    str_contains($class, 'container-fluid')
                    || preg_match('/\bcol-(?:md|sm|lg|xs)-12\b/', $class)
                ) {
                    self::unwrapElement($div);
                    $changed = true;
                    break;
                }
            }

            if (! $changed) {
                break;
            }
        }
    }

    private static function flattenSingleColumnGrids(DOMXPath $xpath): void
    {
        foreach ($xpath->query('//div[contains(@class,"blog-grid")]') as $grid) {
            if (! $grid instanceof DOMElement) {
                continue;
            }

            $cols = [];
            foreach ($grid->childNodes as $child) {
                if ($child instanceof DOMElement && str_contains($child->getAttribute('class'), 'blog-grid-col')) {
                    $cols[] = $child;
                }
            }

            if (count($cols) !== 1) {
                continue;
            }

            self::unwrapElement($cols[0]);

            if ($grid->childNodes->length === 1) {
                self::unwrapElement($grid);
            }
        }
    }

    private static function flattenContentGrids(DOMXPath $xpath): void
    {
        foreach ($xpath->query('//div[contains(@class,"blog-grid")]') as $grid) {
            if (! $grid instanceof DOMElement) {
                continue;
            }

            $hasGridCols = false;

            foreach ($grid->childNodes as $child) {
                if ($child instanceof DOMElement && str_contains($child->getAttribute('class'), 'blog-grid-col')) {
                    $hasGridCols = true;
                    break;
                }
            }

            if (! $hasGridCols) {
                self::unwrapElement($grid);
            }
        }
    }

    private static function unwrapElement(DOMElement $element): void
    {
        $parent = $element->parentNode;
        if (! $parent) {
            return;
        }

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }
}
