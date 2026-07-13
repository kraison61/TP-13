<?php

use App\Models\Blog;
use App\Support\BlogContentTransformer;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$fromId = (int) ($argv[1] ?? 17);
$dryRun = in_array('--dry-run', $argv, true);

$blogs = Blog::query()->where('id', '>=', $fromId)->orderBy('id')->get();

echo "Transforming {$blogs->count()} blog(s) from id {$fromId}...\n";

foreach ($blogs as $blog) {
    $original = $blog->content ?? '';
    $transformed = BlogContentTransformer::transform($original);

    if ($original === $transformed) {
        echo "  [skip] #{$blog->id} {$blog->title}\n";
        continue;
    }

    echo "  [update] #{$blog->id} {$blog->title}\n";

    if (! $dryRun) {
        $blog->content = $transformed;
        $blog->save();
    }
}

echo $dryRun ? "Dry run complete.\n" : "Done.\n";
