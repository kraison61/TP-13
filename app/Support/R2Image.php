<?php

namespace App\Support;

final class R2Image
{
    public static function url(string $path, int $width = 800, string $format = 'webp'): string
    {
        $base = rtrim((string) config('schema.r2_base'), '/');
        $path = ltrim($path, '/');

        if (str_contains($path, '?')) {
            return "{$base}/{$path}";
        }

        return "{$base}/{$path}?format={$format}&width={$width}";
    }
}
