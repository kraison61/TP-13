<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Service;

function stripA(string $html): string
{
    return preg_replace('/<\/?a\b[^>]*>/', '', $html);
}

function applyPage(string $slug, array $replacements, array $l2PlainExtras = [], int $maxServiceLinks = 5): void
{
    $service = Service::where('slug', $slug)->firstOrFail();
    $before = $service->content;
    $content = $before;

    foreach ($replacements as $row) {
        [$old, $new, $label] = $row;
        $expectedCount = $row[3] ?? 1;
        $count = substr_count($content, $old);
        if ($count === 0) {
            throw new RuntimeException("{$slug}: MISSING {$label}");
        }
        if ($expectedCount === 1 && $count !== 1) {
            throw new RuntimeException("{$slug}: NOT UNIQUE {$label}={$count}");
        }
        $pos = strpos($content, $old);
        $content = substr($content, 0, $pos).$new.substr($content, $pos + strlen($old));
    }

    $test = stripA($content);
    $plainBefore = stripA($before);
    foreach ($l2PlainExtras as $s) {
        if (! str_contains($test, $s)) {
            throw new RuntimeException("{$slug}: L2 missing [{$s}]");
        }
        $test = str_replace($s, '', $test);
    }
    if ($test !== $plainBefore) {
        throw new RuntimeException("{$slug}: plain mismatch");
    }

    $slugs = Service::pluck('slug')->all();
    preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>([^<]*)<\/a>/', $content, $m, PREG_SET_ORDER);
    $serviceLinks = [];
    foreach ($m as $r) {
        $href = $r[1];
        if (! str_starts_with($href, '/') || str_starts_with($href, '//')) {
            continue;
        }
        $path = ltrim(parse_url($href, PHP_URL_PATH) ?: '', '/');
        if ($path !== '' && ! str_contains($path, '/') && in_array($path, $slugs, true) && $path !== $slug) {
            $serviceLinks[] = [$href, $r[2]];
        }
    }
    $delta = (strlen($content) - strlen($before)) / max(strlen($before), 1) * 100;
    if ($delta > 15) {
        throw new RuntimeException("{$slug}: delta {$delta}%");
    }
    if (count($serviceLinks) > $maxServiceLinks) {
        throw new RuntimeException("{$slug}: links ".count($serviceLinks)." > max");
    }

    $service->update(['content' => $content, 'updated_at' => now()]);
    echo 'OK '.$slug.' +'.round($delta, 2).'% n='.count($serviceLinks)."\n";
    foreach ($serviceLinks as [$h, $t]) {
        echo "  {$h} | {$t}\n";
    }
}

applyPage('shipment', [
    [
        'มีให้บริการพร้อม รถ 6 ล้อ และในกรณีที่มีความจำเป็นต้องใช้เครื่องจักร รถแบคโฮ',
        'มีให้บริการพร้อม <a href="/truck">รถ 6 ล้อ</a> และในกรณีที่มีความจำเป็นต้องใช้เครื่องจักร <a href="/excavator">รถแบคโฮ</a>',
        'truck-exc', 1,
    ],
    [
        'หรือทุบ รื้อ ถอนอาคาร',
        'หรือ<a href="/building-demolish">ทุบ รื้อ ถอนอาคาร</a>',
        'bd', 2,
    ],
    [
        'เครื่องจักร เครื่องมือ และกำลังคน งานด้านขนย้ายที่เราสามารถดำเนินการให้บริการได้ มีดังนี้',
        'เครื่องจักร เครื่องมือ และกำลังคน งานด้านขนย้ายที่เราสามารถดำเนินการให้บริการได้ มีดังนี้ หลัง <a href="/clearforest">ถางป่าเคลียร์พื้นที่</a> หรือ <a href="/demolish">รื้อบ้านไม้เก่า</a> มักใช้บริการนี้ครับ',
        'l2', 1,
    ],
], [
    ' หลัง ถางป่าเคลียร์พื้นที่ หรือ รื้อบ้านไม้เก่า มักใช้บริการนี้ครับ',
]);

applyPage('building-demolish', [
    [
        'ทุบกำแพง รื้อถอนรั้ว หรือรื้อโครงหลังคา',
        'ทุบกำแพง <a href="/fence">รื้อถอนรั้ว</a> หรือรื้อโครงหลังคา',
        'fence', 1,
    ],
    [
        '<strong>งานเคลียร์พื้นที่:</strong> ขนย้ายเศษปูน',
        '<strong>งาน<a href="/clearforest">เคลียร์พื้นที่</a>:</strong> ขนย้ายเศษปูน',
        'clear', 1,
    ],
    [
        'เก็บเศษวัสดุ จนถึงการปรับหน้าดินให้พร้อมสำหรับการก่อสร้างใหม่',
        '<a href="/shipment">เก็บเศษวัสดุ</a> จนถึงการ<a href="/landjustment">ปรับหน้าดิน</a>ให้พร้อมสำหรับการก่อสร้างใหม่ ขนออกไซต์ด้วย <a href="/truck">เช่ารถหกล้อ</a>',
        'multi', 1,
    ],
], [
    ' ขนออกไซต์ด้วย เช่ารถหกล้อ',
]);

applyPage('demolish', [
    [
        'การเสริมสร้างความแข็งแรงให้กับบ้านหลังใหม่ โดยยังคงรักษาความผูกพันกับที่ตั้งเดิมของบ้านได้',
        'การเสริมสร้างความแข็งแรงให้กับบ้านหลังใหม่ โดยยังคงรักษาความผูกพันกับที่ตั้งเดิมของบ้านได้ หลังรื้อมักต่อด้วย <a href="/shipment">ขนเศษวัสดุออก</a> และถ้าเป็นโครงสร้างปูนใช้ <a href="/building-demolish">รับทุบตึกรื้ออาคาร</a> แทนครับ',
        'l2', 1,
    ],
], [
    ' หลังรื้อมักต่อด้วย ขนเศษวัสดุออก และถ้าเป็นโครงสร้างปูนใช้ รับทุบตึกรื้ออาคาร แทนครับ',
]);

applyPage('garden-plot', [
    [
        'ดินที่ขุดขึ้นมาใช้ถมที่ยกระดับลดปัญหาน้ำท่วม',
        'ดินที่ขุดขึ้นมาใช้<a href="/landfill">ถมที่ยกระดับ</a>ลดปัญหาน้ำท่วม',
        'lf', 1,
    ],
    [
        'ซึ่งตอบโจทย์ทั้งการรดน้ำ การป้องกันน้ำท่วม และการเพาะเลี้ยงสัตว์น้ำ',
        'ซึ่งตอบโจทย์ทั้งการรดน้ำ การป้องกันน้ำท่วม และการเพาะเลี้ยงสัตว์น้ำ งานขุดใช้ <a href="/excavator">เช่าแบคโฮขุดร่อง</a> และระบายน้ำส่วนเกินด้วย <a href="/pipe">วางท่อระบายสวน</a> ครับ',
        'l2', 1,
    ],
], [
    ' งานขุดใช้ เช่าแบคโฮขุดร่อง และระบายน้ำส่วนเกินด้วย วางท่อระบายสวน ครับ',
]);
