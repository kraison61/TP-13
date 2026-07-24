<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class UploadedImageStorage
{
    public static function store(UploadedFile $file, string $slug, string $directory = 'images/services'): string
    {
        $slug = Str::slug($slug) ?: 'image';
        $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $filename = sprintf(
            '%s-%s-%s.%s',
            $slug,
            (string) Str::uuid(),
            time(),
            $extension
        );

        // R2 does not support per-object ACLs — omit visibility.
        $path = $file->storeAs($directory, $filename, [
            'disk' => 's3',
        ]);

        if (! is_string($path) || $path === '') {
            throw ValidationException::withMessages([
                'file' => 'อัปโหลดไม่สำเร็จ กรุณาตรวจสอบการเชื่อมต่อ R2/S3',
            ]);
        }

        return str_replace('\\', '/', $path);
    }
}
