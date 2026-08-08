<?php
require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (App\Models\Service::all(['slug','content']) as $s) {
    if (preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>รถแบคโฮ<\/a>/', $s->content, $m)) {
        echo $s->slug.' → '.implode(',', $m[1])."\n";
        // show context
        $p = mb_strpos($s->content, '>รถแบคโฮ</a>', 0, 'UTF-8');
        echo '  '.mb_substr($s->content, max(0,$p-50), 100, 'UTF-8')."\n";
    }
}
