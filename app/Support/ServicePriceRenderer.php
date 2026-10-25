<?php

namespace App\Support;

use App\Models\Service;
use App\Models\ServicePrice;
use Illuminate\Support\Collection;

class ServicePriceRenderer
{
    /**
     * Format a price for display in content or tables.
     */
    public static function format(ServicePrice $price, bool $withStartingPrefix = true): string
    {
        if ($price->price_type === 'call_to_ask' || $price->price === null) {
            return 'สอบถาม';
        }

        $formatted = number_format((float) $price->price, 0);

        if ($price->max_price !== null && (float) $price->max_price > 0) {
            $formatted .= ' – '.number_format((float) $price->max_price, 0);
        }

        if ($withStartingPrefix && $price->price_type === 'starting_at') {
            return 'เริ่มต้น '.$formatted;
        }

        return $formatted;
    }

    /**
     * Expand {{price:*}} shortcodes in HTML using this service's price rows.
     *
     * Supported:
     * - {{price:SKU_OR_ID}}       formatted label (incl. "เริ่มต้น" when starting_at)
     * - {{price_plain:SKU_OR_ID}} formatted without "เริ่มต้น"
     * - {{price_min:SKU_OR_ID}}   min/base number only
     * - {{price_max:SKU_OR_ID}}   max number, or min when no max
     * - {{price_expr:A + 5 * B}}  arithmetic using price base values (SKU or id tokens)
     */
    public static function inject(string $html, Service $service): string
    {
        if ($html === '' || ! str_contains($html, '{{price')) {
            return $html;
        }

        $prices = self::priceMap($service);
        if ($prices->isEmpty()) {
            return $html;
        }

        $html = preg_replace_callback(
            '/\{\{price_expr:([^}]+)\}\}/',
            static fn (array $m): string => self::evaluateExpression(trim($m[1]), $prices),
            $html
        ) ?? $html;

        $html = preg_replace_callback(
            '/\{\{price_min:([A-Za-z0-9_-]+)\}\}/',
            static function (array $m) use ($prices): string {
                $price = $prices->get($m[1]);

                return $price && $price->price !== null
                    ? number_format((float) $price->price, 0)
                    : 'สอบถาม';
            },
            $html
        ) ?? $html;

        $html = preg_replace_callback(
            '/\{\{price_max:([A-Za-z0-9_-]+)\}\}/',
            static function (array $m) use ($prices): string {
                $price = $prices->get($m[1]);
                if (! $price || $price->price === null) {
                    return 'สอบถาม';
                }

                $value = $price->max_price !== null && (float) $price->max_price > 0
                    ? (float) $price->max_price
                    : (float) $price->price;

                return number_format($value, 0);
            },
            $html
        ) ?? $html;

        $html = preg_replace_callback(
            '/\{\{price_plain:([A-Za-z0-9_-]+)\}\}/',
            static function (array $m) use ($prices): string {
                $price = $prices->get($m[1]);

                return $price ? self::format($price, false) : 'สอบถาม';
            },
            $html
        ) ?? $html;

        return preg_replace_callback(
            '/\{\{price:([A-Za-z0-9_-]+)\}\}/',
            static function (array $m) use ($prices): string {
                $price = $prices->get($m[1]);

                return $price ? self::format($price) : 'สอบถาม';
            },
            $html
        ) ?? $html;
    }

    /**
     * @return Collection<string, ServicePrice>
     */
    private static function priceMap(Service $service): Collection
    {
        $rows = $service->relationLoaded('prices')
            ? $service->prices
            : ($service->relationLoaded('activePrices')
                ? $service->activePrices
                : $service->prices()->get());

        $map = collect();

        foreach ($rows as $price) {
            $map->put((string) $price->id, $price);
            if (is_string($price->sku) && $price->sku !== '') {
                $map->put($price->sku, $price);
            }
        }

        return $map;
    }

    /**
     * @param  Collection<string, ServicePrice>  $prices
     */
    private static function evaluateExpression(string $expression, Collection $prices): string
    {
        $keys = $prices->keys()
            ->filter(static fn ($key): bool => is_string($key) && $key !== '')
            ->sortByDesc(static fn (string $key): int => strlen($key))
            ->values();

        $resolved = $expression;

        foreach ($keys as $key) {
            $price = $prices->get($key);
            if (! $price || $price->price === null) {
                continue;
            }

            $resolved = str_replace($key, (string) (float) $price->price, $resolved);
        }

        $result = self::safeCalculate($resolved);

        return $result === null ? 'สอบถาม' : number_format($result, 0);
    }

    private static function safeCalculate(string $expression): ?float
    {
        $expression = preg_replace('/\s+/', '', $expression) ?? '';
        if ($expression === '' || ! preg_match('/^[0-9+\-*\/().]+$/', $expression)) {
            return null;
        }

        // Shunting-yard for + - * / and parentheses over floats.
        $tokens = preg_split('/([+\-*\/()])/', $expression, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        if ($tokens === false) {
            return null;
        }

        $output = [];
        $ops = [];
        $precedence = ['+' => 1, '-' => 1, '*' => 2, '/' => 2];

        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $output[] = (float) $token;
                continue;
            }

            if ($token === '(') {
                $ops[] = $token;
                continue;
            }

            if ($token === ')') {
                while ($ops !== [] && end($ops) !== '(') {
                    $output[] = array_pop($ops);
                }
                if ($ops === [] || array_pop($ops) !== '(') {
                    return null;
                }
                continue;
            }

            if (! isset($precedence[$token])) {
                return null;
            }

            while (
                $ops !== []
                && ($top = end($ops)) !== false
                && $top !== '('
                && ($precedence[$top] ?? 0) >= $precedence[$token]
            ) {
                $output[] = array_pop($ops);
            }
            $ops[] = $token;
        }

        while ($ops !== []) {
            $op = array_pop($ops);
            if ($op === '(' || $op === ')') {
                return null;
            }
            $output[] = $op;
        }

        $stack = [];
        foreach ($output as $item) {
            if (is_float($item) || is_int($item)) {
                $stack[] = (float) $item;
                continue;
            }

            if (count($stack) < 2) {
                return null;
            }

            $b = array_pop($stack);
            $a = array_pop($stack);

            $stack[] = match ($item) {
                '+' => $a + $b,
                '-' => $a - $b,
                '*' => $a * $b,
                '/' => $b == 0.0 ? null : $a / $b,
                default => null,
            };

            if (end($stack) === null) {
                return null;
            }
        }

        return count($stack) === 1 ? (float) $stack[0] : null;
    }
}
