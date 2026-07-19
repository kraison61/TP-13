<?php

namespace App\Support;

final class CriticalCss
{
    public static function contents(): string
    {
        $path = public_path('build/critical.css');

        return is_readable($path) ? (string) file_get_contents($path) : '';
    }
}
