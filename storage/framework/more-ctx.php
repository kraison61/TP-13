<?php
require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$c = App\Models\Service::where('slug', 'garden-plot')->value('content');
$p = mb_strpos($c, 'ถมที่', 0, 'UTF-8');
echo mb_substr($c, max(0,$p-50), 150, 'UTF-8')."\n";

$c2 = App\Models\Service::where('slug', 'cctv-installation')->value('content');
$p2 = mb_strpos($c2, 'รั้ว', 0, 'UTF-8');
echo "CCTV: ".mb_substr($c2, max(0,$p2-40), 120, 'UTF-8')."\n";

$c3 = App\Models\Service::where('slug', 'waste')->value('content');
echo "WASTE END: ".mb_substr($c3, -200, null, 'UTF-8')."\n";
