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
    // delta vs original session not needed; this is small edit
    if (count($serviceLinks) > $maxServiceLinks) {
        throw new RuntimeException("{$slug}: links ".count($serviceLinks)." > max");
    }

    $service->update(['content' => $content, 'updated_at' => now()]);
    echo 'OK '.$slug.' n='.count($serviceLinks)."\n";
    foreach ($serviceLinks as [$h, $t]) {
        echo "  {$h} | {$t}\n";
    }
}

// Expand L1 wraps so anchor text is unique (no content text change)
applyPage('truck', [
    [
        'มี<a href="/excavator">รถแบคโฮ</a>ตักให้ที่หน้างาน',
        '<a href="/excavator">มีรถแบคโฮตักให้ที่หน้างาน</a>',
        'expand', 1,
    ],
], []);

applyPage('landjustment', [
    [
        'เช่น <a href="/excavator">รถแบคโฮ</a> รถไถ รถเกรดเดอร์',
        'เช่น <a href="/excavator">รถแบคโฮ รถไถ รถเกรดเดอร์</a>',
        'expand', 1,
    ],
], []);

// Add inbound to waste + steel (pages with outbound room)
applyPage('pipe', [
    [
        'ริมตลิ่งอาจทำคู่กับ <a href="/dam">เขื่อนกันตลิ่ง</a>',
        'ริมตลิ่งอาจทำคู่กับ <a href="/dam">เขื่อนกันตลิ่ง</a> และงานบำบัดต่อเข้า <a href="/waste">ถังบำบัดน้ำเสีย</a>',
        'waste', 1,
    ],
], [
    ' และงานบำบัดต่อเข้า ถังบำบัดน้ำเสีย',
]);

applyPage('fence', [
    [
        'ฐานเสารั้วมักใช้ <a href="/pour-concrete">เทคอนกรีต</a> ยึดเสาให้แน่นก่อนประกอบแผ่นสำเร็จรูปครับ',
        'ฐานเสารั้วมักใช้ <a href="/pour-concrete">เทคอนกรีต</a> ยึดเสาให้แน่นก่อนประกอบแผ่นสำเร็จรูปครับ โครงเสาเหล็กเสริมใช้คู่กับ <a href="/steel">โครงเหล็กรั้ว</a> ได้',
        'steel', 1,
    ],
], [
    ' โครงเสาเหล็กเสริมใช้คู่กับ โครงเหล็กรั้ว ได้',
]);

// Boost garden-plot + demolish + waterfall inbound from pages with room
applyPage('outdoor-lan-cabling', [
    [
        'มักวางสายคู่กับ <a href="/electrical-wiring">ระบบไฟฟ้าภายนอก</a> และกล้อง <a href="/cctv-installation">ติดตั้ง CCTV ภายนอก</a> ครับ',
        'มักวางสายคู่กับ <a href="/electrical-wiring">ระบบไฟฟ้าภายนอก</a> และกล้อง <a href="/cctv-installation">ติดตั้ง CCTV ภายนอก</a> ครับ ในสวนใหญ่เดินสายคู่กับงาน <a href="/garden-plot">ขุดร่องน้ำในสวน</a> ได้',
        'gp', 1,
    ],
], [
    ' ในสวนใหญ่เดินสายคู่กับงาน ขุดร่องน้ำในสวน ได้',
]);

applyPage('cctv-installation', [
    [
        'มักทำคู่กับ <a href="/electrical-wiring">เดินสายไฟฟ้าบ้าน</a> และ <a href="/outdoor-lan-cabling">เดินสายแลนภายนอก</a> ในงานเดียวกันครับ',
        'มักทำคู่กับ <a href="/electrical-wiring">เดินสายไฟฟ้าบ้าน</a> และ <a href="/outdoor-lan-cabling">เดินสายแลนภายนอก</a> ในงานเดียวกันครับ หลังรื้อบ้านไม้เก่าติดตั้งกล้องใหม่หลังงาน <a href="/demolish">รื้อถอนบ้านไม้</a>',
        'dem', 1,
    ],
], [
    ' หลังรื้อบ้านไม้เก่าติดตั้งกล้องใหม่หลังงาน รื้อถอนบ้านไม้',
]);

applyPage('artificial-waterfall-garden', [
    [
        'จัดวางคู่กับ <a href="/garden-plot">ขุดร่องสวนน้ำ</a> และปรับระดับด้วย <a href="/landjustment">ปรับพื้นที่สวน</a> ครับ',
        'จัดวางคู่กับ <a href="/garden-plot">ขุดร่องสวนน้ำ</a> และปรับระดับด้วย <a href="/landjustment">ปรับพื้นที่สวน</a> ครับ ฐานปั๊มใช้ <a href="/footing">ฟุตติ้งฐานปั๊ม</a>',
        'ft', 1,
    ],
], [
    ' ฐานปั๊มใช้ ฟุตติ้งฐานปั๊ม',
]);

applyPage('electrical-wiring', [
    [
        'งานภายนอกอาคารต่อด้วย <a href="/outdoor-lan-cabling">เดินสาย Outdoor LAN</a> และโครงหลังคาเหล็กคู่กับ <a href="/steel">โครงเหล็กหลังคา</a> ครับ',
        'งานภายนอกอาคารต่อด้วย <a href="/outdoor-lan-cabling">เดินสาย Outdoor LAN</a> และโครงหลังคาเหล็กคู่กับ <a href="/steel">โครงเหล็กหลังคา</a> ครับ สวนน้ำตกใช้ไฟปั๊มจากงานนี้คู่กับ <a href="/artificial-waterfall-garden">รับทำสวนน้ำตก</a>',
        'wf', 1,
    ],
], [
    ' สวนน้ำตกใช้ไฟปั๊มจากงานนี้คู่กับ รับทำสวนน้ำตก',
]);
