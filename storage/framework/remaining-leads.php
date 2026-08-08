<?php
require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (['shipment', 'building-demolish', 'demolish', 'garden-plot', 'waste', 'steel', 'cctv-installation', 'electrical-wiring', 'outdoor-lan-cabling', 'artificial-waterfall-garden'] as $slug) {
    $c = App\Models\Service::where('slug', $slug)->value('content');
    echo "==== {$slug} ====\n";
    if (preg_match('/<div class="lead">\s*<p>(.*?)<\/p>/su', $c, $m)) {
        echo 'LEAD: '.mb_substr(trim(strip_tags($m[1])), 0, 150, 'UTF-8')."\n";
        echo 'LEAD_END: '.mb_substr(trim($m[1]), -90, null, 'UTF-8')."\n";
    } elseif (preg_match_all('/<p[^>]*>(.*?)<\/p>/su', $c, $mm)) {
        echo 'P0: '.mb_substr(trim(strip_tags($mm[1][0])), 0, 120, 'UTF-8')."\n";
        if (isset($mm[1][1])) {
            echo 'P1_END: '.mb_substr(trim($mm[1][1]), -80, null, 'UTF-8')."\n";
        }
    }
    echo "\n";
}
