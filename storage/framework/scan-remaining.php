<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Service;

$done = ['retaining-wall', 'fence', 'dam', 'excavator', 'truck'];
$services = Service::orderBy('slug')->get(['slug', 'title', 'h1', 'content', 'updated_at']);

foreach ($services as $s) {
    if (in_array($s->slug, $done, true)) {
        continue;
    }
    preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>([^<]*)<\/a>/', $s->content, $m, PREG_SET_ORDER);
    $svcLinks = 0;
    foreach ($m as $row) {
        $path = ltrim(parse_url($row[1], PHP_URL_PATH) ?: '', '/');
        if ($path && ! str_contains($path, '/') && Service::where('slug', $path)->exists()) {
            $svcLinks++;
        }
    }
    echo "=== {$s->slug} len=".strlen($s->content)." svcLinks={$svcLinks} ===\n";
    echo 'title='.$s->title."\n";

    $terms = [
        'ถมดิน', 'ถมที่', 'กำแพงกันดิน', 'กำแพง', 'เขื่อน', 'เสาเข็ม', 'กดเข็ม', 'ฟุตติ้ง',
        'รั้ว', 'แบคโฮ', 'แม็คโคร', 'ท่อระบาย', 'ระบายน้ำ', 'คอนกรีต', 'เทคอน',
        'ปรับพื้นที่', 'เคลียร์', 'ถางป่า', 'รื้อ', 'ทุบ', 'ขนเศษ', 'รถ 6 ล้อ', 'รถบรรทุก',
        'ฐานราก', 'ขุดร่อง', 'ถัง', 'โครงเหล็ก', 'กล้อง', 'ไฟฟ้า', 'แลน', 'น้ำตก',
    ];
    $hits = [];
    foreach ($terms as $t) {
        if (mb_strpos($s->content, $t, 0, 'UTF-8') !== false) {
            $hits[] = $t;
        }
    }
    echo 'hits='.implode(',', $hits)."\n\n";
}
