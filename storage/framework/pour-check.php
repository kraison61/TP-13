<?php
require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$c = App\Models\Service::where('slug', 'pour-concrete')->value('content');
echo (str_contains($c, '10 ซม.') ? 'has 10' : 'no')."\n";
$p = mb_strpos($c, 'ซม.', 0, 'UTF-8');
echo mb_substr($c, max(0,$p-80), 200, 'UTF-8')."\n";
$p2 = mb_strpos($c, 'งานเหมา', 0, 'UTF-8');
echo mb_substr($c, max(0,$p2-40), 120, 'UTF-8')."\n";
