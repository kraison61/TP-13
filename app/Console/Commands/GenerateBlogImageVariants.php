<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Support\BlogImageVariants;
use Illuminate\Console\Command;

class GenerateBlogImageVariants extends Command
{
    protected $signature = 'blog:generate-image-variants
                            {slug? : Generate variants for a single blog slug}
                            {--all : Generate variants for every blog with a cover image}
                            {--force : Regenerate even when variant files already exist}';

    protected $description = 'Generate 4x3 and 1x1 cover image crops for blog JSON-LD schema';

    public function handle(): int
    {
        $blogs = $this->resolveBlogs();

        if ($blogs->isEmpty()) {
            $this->warn('No blogs matched.');

            return self::FAILURE;
        }

        $processed = 0;

        foreach ($blogs as $blog) {
            if (! $blog->cover_image || str_starts_with($blog->cover_image, 'http')) {
                $this->line("Skipping {$blog->slug}: no local cover image.");

                continue;
            }

            if ($this->option('force')) {
                $this->deleteExistingVariants($blog->cover_image);
            }

            $result = BlogImageVariants::generateMissingVariants($blog->cover_image);

            if (isset($result['error'])) {
                $this->error("[{$blog->slug}] {$result['error']}");

                continue;
            }

            if (isset($result['skipped'])) {
                $this->line("[{$blog->slug}] {$result['skipped']}");

                continue;
            }

            $created = $result['created'] ?? [];

            if ($created === []) {
                $this->line("[{$blog->slug}] Variants already exist.");
            } else {
                $this->info("[{$blog->slug}] Created: ".implode(', ', $created));
            }

            $processed++;
        }

        $this->info("Done. Processed {$processed} blog(s).");

        return self::SUCCESS;
    }

    private function resolveBlogs()
    {
        if ($slug = $this->argument('slug')) {
            return Blog::query()->where('slug', $slug)->get();
        }

        if ($this->option('all')) {
            return Blog::query()
                ->whereNotNull('cover_image')
                ->orderBy('id')
                ->get();
        }

        $this->error('Provide a slug or pass --all.');

        return collect();
    }

    private function deleteExistingVariants(string $originalPath): void
    {
        $disk = \Illuminate\Support\Facades\Storage::disk('s3');

        foreach (BlogImageVariants::VARIANTS as $variant) {
            if ($variant['suffix'] === '') {
                continue;
            }

            $path = BlogImageVariants::variantPath($originalPath, $variant['suffix']);

            if ($disk->exists($path)) {
                $disk->delete($path);
            }
        }
    }
}
