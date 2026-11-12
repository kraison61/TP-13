<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (App\Models\Blog::query()->orderBy('id')->get(['id', 'slug', 'content']) as $b) {
    if (! $b->content || ! preg_match('/<img/i', $b->content)) {
        continue;
    }
    preg_match_all('/<img[^>]+>/i', $b->content, $imgs);
    echo "=== {$b->id} {$b->slug} (".count($imgs[0])." imgs) ===\n";
    foreach (array_slice($imgs[0], 0, 2) as $tag) {
        echo $tag."\n";
    }
    // show surrounding context for first img
    if (preg_match('/(.{0,120}<img[^>]+>.{0,120})/is', $b->content, $ctx)) {
        echo "context: ".preg_replace('/\s+/', ' ', strip_tags($ctx[1], '<img>'))."\n";
    }
    echo "\n";
}
