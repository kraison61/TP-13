<?php
require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Service;

foreach (['steel','cctv-installation','electrical-wiring','outdoor-lan-cabling','artificial-waterfall-garden','waste','demolish'] as $slug) {
    $c = Service::where('slug', $slug)->value('content');
    preg_match_all('/<a[^>]*href="\/([^"]+)"/', $c, $m);
    echo $slug.' links='.count($m[1]).' → '.implode(',', $m[1])."\n";
}

// steel more insert points
$c = Service::where('slug', 'steel')->value('content');
echo "\nSTEEL has ฐานราก: ".(str_contains($c,'ฐานราก')?'Y':'N')."\n";
echo "STEEL has รื้อ: ".(str_contains($c,'รื้อ')?'Y':'N')."\n";
$p = mb_strpos($c, 'ฐานราก', 0, 'UTF-8');
if ($p!==false) echo mb_substr($c, max(0,$p-40), 140, 'UTF-8')."\n";

$c = Service::where('slug', 'cctv-installation')->value('content');
echo "\nCCTV รั้ว: ";
$p = mb_strpos($c, 'รั้ว', 0, 'UTF-8');
echo mb_substr($c, max(0,$p-30), 100, 'UTF-8')."\n";
echo "CCTV END: ".mb_substr(strip_tags($c), -100, null, 'UTF-8')."\n";

$c = Service::where('slug', 'electrical-wiring')->value('content');
echo "\nELEC has กล้อง: ".(str_contains($c,'กล้อง')?'Y':'N')."\n";
$p = mb_strpos($c, 'กล้อง', 0, 'UTF-8');
if ($p!==false) echo mb_substr($c, max(0,$p-40), 120, 'UTF-8')."\n";

$c = Service::where('slug', 'outdoor-lan-cabling')->value('content');
echo "\nLAN END: ".mb_substr(trim(strip_tags($c)), -80, null, 'UTF-8')."\n";

$c = Service::where('slug', 'artificial-waterfall-garden')->value('content');
echo "\nWF ระบายน้ำ: ".(str_contains($c,'ระบายน้ำ')?'Y':'N')."\n";
$p = mb_strpos($c, 'ระบายน้ำ', 0, 'UTF-8');
if ($p!==false) echo mb_substr($c, max(0,$p-40), 120, 'UTF-8')."\n";
$p = mb_strpos($c, 'ลงเสาเข็มหรือทำฐานราก', 0, 'UTF-8');
echo mb_substr($c, max(0,$p-20), 100, 'UTF-8')."\n";
