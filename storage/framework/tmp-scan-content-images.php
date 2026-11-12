<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$slugs = ['clearforest', 'landfill', 'landjustment', 'garden-plot', 'excavator', 'truck', 'building-demolish', 'dam', 'fence', 'electrical-wiring'];

foreach ($slugs as $slug) {
    $c = App\Models\Service::where('slug', $slug)->value('content');
    $hasImg = $c && preg_match('/<img/i', $c);
    echo "=== $slug ===\n";
    echo 'has_img: '.($hasImg ? 'yes' : 'no').' len: '.strlen($c ?? '')."\n";
    if (! $hasImg) {
        continue;
    }
    if (preg_match_all('/<figure[^>]*>[\s\S]*?<\/figure>/i', $c, $figs)) {
        echo 'figure_count: '.count($figs[0])."\n";
        foreach (array_slice($figs[0], 0, 2) as $i => $fig) {
            echo "--- figure sample ".($i + 1)." ---\n".trim($fig)."\n";
        }
    }
    if (preg_match_all('/<div class="blog-grid"[^>]*>[\s\S]*?<\/div>/i', $c, $grids)) {
        echo 'blog_grid_count: '.count($grids[0])."\n";
    }
    if (preg_match_all('/<img[^>]+>/i', $c, $imgs)) {
        echo 'img_count: '.count($imgs[0])."\n";
        foreach (array_slice($imgs[0], 0, 3) as $tag) {
            echo $tag."\n";
        }
    }
}

echo "\n--- all services with content img ---\n";
foreach (App\Models\Service::query()->orderBy('id')->get(['id', 'slug', 'content']) as $s) {
    if ($s->content && preg_match('/<img/i', $s->content)) {
        preg_match_all('/<img[^>]+>/i', $s->content, $m);
        echo "{$s->id}\t{$s->slug}\t".count($m[0])." imgs\n";
    }
}
