<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach ([30, 26, 17] as $id) {
    $b = App\Models\Blog::find($id);
    echo "=== blog $id ===\n";
    if (preg_match('/<img[^>]+>/', $b->content, $m, PREG_OFFSET_CAPTURE)) {
        $pos = $m[0][1];
        echo substr($b->content, max(0, $pos - 120), 500)."\n\n";
    }
}
