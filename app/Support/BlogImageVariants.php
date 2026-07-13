<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class BlogImageVariants
{
    /** @var array<string, array{width: int, height: int, suffix: string}> */
    public const VARIANTS = [
        '16x9' => ['width' => 1200, 'height' => 675, 'suffix' => ''],
        '4x3' => ['width' => 1200, 'height' => 900, 'suffix' => '-4x3'],
        '1x1' => ['width' => 1200, 'height' => 1200, 'suffix' => '-1x1'],
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function schemaImageObjects(?string $path): array
    {
        if (! $path) {
            return [];
        }

        return collect(self::VARIANTS)
            ->map(fn (array $variant) => [
                '@type' => 'ImageObject',
                'url' => self::absoluteUrl(self::variantPath($path, $variant['suffix'])),
                'width' => $variant['width'],
                'height' => $variant['height'],
            ])
            ->values()
            ->all();
    }

    public static function variantPath(string $path, string $suffix): string
    {
        if ($suffix === '') {
            return $path;
        }

        if (str_starts_with($path, 'http')) {
            $parts = parse_url($path);
            $variantPath = self::addSuffixBeforeExtension($parts['path'] ?? '', $suffix);

            return ($parts['scheme'] ?? 'https').'://'.($parts['host'] ?? '').$variantPath
                .(isset($parts['query']) ? '?'.$parts['query'] : '');
        }

        return self::addSuffixBeforeExtension($path, $suffix);
    }

    public static function absoluteUrl(string $path): string
    {
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        $base = rtrim((string) config('schema.r2_base'), '/');

        return $base.'/'.ltrim($path, '/');
    }

    public static function addSuffixBeforeExtension(string $path, string $suffix): string
    {
        $dot = strrpos($path, '.');

        if ($dot === false) {
            return $path.$suffix;
        }

        return substr($path, 0, $dot).$suffix.substr($path, $dot);
    }

    public static function variantExists(string $originalPath, string $suffix): bool
    {
        if (str_starts_with($originalPath, 'http')) {
            return false;
        }

        $variantPath = self::variantPath($originalPath, $suffix);

        return Storage::disk('s3')->exists($variantPath);
    }

    /**
     * Center-crop and resize using PHP GD (no Intervention dependency).
     * Writes 4x3 and 1x1 variants to the s3 disk when missing.
     */
    public static function generateMissingVariants(string $originalPath): array
    {
        if (str_starts_with($originalPath, 'http')) {
            return ['skipped' => 'External URLs are not processed locally.'];
        }

        $disk = Storage::disk('s3');

        if (! $disk->exists($originalPath)) {
            return ['error' => "Original not found: {$originalPath}"];
        }

        $created = [];

        foreach (self::VARIANTS as $label => $variant) {
            if ($variant['suffix'] === '') {
                continue;
            }

            $targetPath = self::variantPath($originalPath, $variant['suffix']);

            if ($disk->exists($targetPath)) {
                continue;
            }

            $binary = $disk->get($originalPath);
            $image = self::loadImageFromBinary($binary, $originalPath);

            if ($image === null) {
                return ['error' => "Unable to decode image: {$originalPath}"];
            }

            $cropped = self::cropAndResize($image, $variant['width'], $variant['height']);
            imagedestroy($image);

            $encoded = self::encodeImage($cropped, $originalPath);
            imagedestroy($cropped);

            if ($encoded === null) {
                return ['error' => "Unable to encode {$label} variant for {$originalPath}"];
            }

            $disk->put($targetPath, $encoded, ['visibility' => 'public']);
            $created[] = $targetPath;
        }

        return ['created' => $created];
    }

    private static function loadImageFromBinary(string $binary, string $path): ?\GdImage
    {
        $image = @imagecreatefromstring($binary);

        if ($image instanceof \GdImage) {
            return $image;
        }

        return match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'jpg', 'jpeg' => @imagecreatefromjpeg('data://image/jpeg;base64,'.base64_encode($binary)) ?: null,
            'png' => @imagecreatefrompng('data://image/png;base64,'.base64_encode($binary)) ?: null,
            'webp' => function_exists('imagecreatefromwebp')
                ? (@imagecreatefromwebp('data://image/webp;base64,'.base64_encode($binary)) ?: null)
                : null,
            default => null,
        };
    }

    private static function cropAndResize(\GdImage $source, int $targetWidth, int $targetHeight): \GdImage
    {
        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $targetAspect = $targetWidth / $targetHeight;
        $sourceAspect = $sourceWidth / $sourceHeight;

        if ($sourceAspect > $targetAspect) {
            $cropWidth = (int) round($sourceHeight * $targetAspect);
            $cropHeight = $sourceHeight;
            $cropX = (int) round(($sourceWidth - $cropWidth) / 2);
            $cropY = 0;
        } else {
            $cropWidth = $sourceWidth;
            $cropHeight = (int) round($sourceWidth / $targetAspect);
            $cropX = 0;
            $cropY = (int) round(($sourceHeight - $cropHeight) / 2);
        }

        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled(
            $canvas,
            $source,
            0,
            0,
            $cropX,
            $cropY,
            $targetWidth,
            $targetHeight,
            $cropWidth,
            $cropHeight,
        );

        return $canvas;
    }

    private static function encodeImage(\GdImage $image, string $originalPath): ?string
    {
        ob_start();

        $saved = match (strtolower(pathinfo($originalPath, PATHINFO_EXTENSION))) {
            'png' => imagepng($image, null, 6),
            'webp' => function_exists('imagewebp') ? imagewebp($image, null, 85) : false,
            default => imagejpeg($image, null, 85),
        };

        $binary = ob_get_clean();

        return $saved ? $binary : null;
    }
}
