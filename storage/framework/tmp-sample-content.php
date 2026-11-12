<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (['clearforest', 'landfill'] as $slug) {
    $s = App\Models\Service::where('slug', $slug)->first(['slug', 'content', 'img_1', 'img_2']);
    echo "===== $slug =====\n";
    echo "img_1: {$s->img_1}\n";
    echo "content_prefix:\n".substr($s->content, 0, 800)."\n\n";
}

echo "===== blogs with img in content =====\n";
foreach (App\Models\Blog::query()->get(['id', 'slug', 'content']) as $b) {
    if ($b->content && preg_match('/<img/i', $b->content)) {
        preg_match_all('/<figure[^>]*>[\s\S]*?<\/figure>/i', $b->content, $figs);
        echo "{$b->id}\t{$b->slug}\tfigures:".count($figs[0])."\n";
        if (! empty($figs[0][0])) {
            echo trim($figs[0][0])."\n---\n";
        }
    }
}
