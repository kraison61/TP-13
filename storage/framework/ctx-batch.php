<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Service;

function ctx(string $slug, array $terms): void
{
    $c = Service::where('slug', $slug)->value('content');
    echo "######## {$slug} ########\n";
    foreach ($terms as $t) {
        $p = mb_strpos($c, $t, 0, 'UTF-8');
        if ($p === false) {
            echo "NO {$t}\n";
            continue;
        }
        echo "-- {$t} --\n".mb_substr($c, max(0, $p - 40), 160, 'UTF-8')."\n\n";
    }
}

ctx('landfill', ['เสาเข็ม', 'แม็คโคร', 'ระบายน้ำ', 'เคลียร์', 'รถบรรทุก', 'คอนกรีต', 'ถมสูงกว่า']);
ctx('pile', ['กำแพงกันดิน', 'รั้ว', 'ฐานราก', 'รื้อ']);
ctx('pipe', ['ท่อระบาย', 'คอนกรีต', 'ระบายน้ำ']);
ctx('building-demolish', ['รั้ว', 'เคลียร์', 'กำแพง', 'ทุบ', 'รื้อ']);
ctx('shipment', ['แบคโฮ', 'รถ 6 ล้อ', 'ขนเศษ', 'รื้อ', 'ทุบ']);
ctx('pour-concrete', ['คอนกรีต']);
ctx('footing', ['เสาเข็ม', 'ฟุตติ้ง', 'คอนกรีต', 'เทคอน']);
ctx('clearforest', ['ปรับพื้นที่', 'เคลียร์', 'ถางป่า']);
ctx('landjustment', ['ถมดิน', 'แบคโฮ', 'ระบายน้ำ', 'ปรับพื้นที่']);
