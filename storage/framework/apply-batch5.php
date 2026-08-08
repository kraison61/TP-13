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

// top-up demolish (already has 2 links)
applyPage('demolish', [
    [
        'หลังรื้อมักต่อด้วย <a href="/shipment">ขนเศษวัสดุออก</a> และถ้าเป็นโครงสร้างปูนใช้ <a href="/building-demolish">รับทุบตึกรื้ออาคาร</a> แทนครับ',
        'หลังรื้อมักต่อด้วย <a href="/shipment">ขนเศษวัสดุออก</a> และถ้าเป็นโครงสร้างปูนใช้ <a href="/building-demolish">รับทุบตึกรื้ออาคาร</a> แทนครับ ขนออกด้วย <a href="/truck">รถหกล้อรับจ้าง</a> และเคลียร์วัชพืชด้วย <a href="/clearforest">งานเคลียร์ริ่ง</a> ก่อนปลูกสร้างใหม่ครับ',
        'top', 1,
    ],
], [
    ' ขนออกด้วย รถหกล้อรับจ้าง และเคลียร์วัชพืชด้วย งานเคลียร์ริ่ง ก่อนปลูกสร้างใหม่ครับ',
]);

applyPage('garden-plot', [
    [
        'งานขุดใช้ <a href="/excavator">เช่าแบคโฮขุดร่อง</a> และระบายน้ำส่วนเกินด้วย <a href="/pipe">วางท่อระบายสวน</a> ครับ',
        'งานขุดใช้ <a href="/excavator">เช่าแบคโฮขุดร่อง</a> และระบายน้ำส่วนเกินด้วย <a href="/pipe">วางท่อระบายสวน</a> ครับ แปลงใหม่มักทำคู่กับ <a href="/landjustment">รับปรับพื้นที่สวน</a> และจัดสวนน้ำด้วย <a href="/artificial-waterfall-garden">สวนน้ำตกจำลอง</a>',
        'top', 1,
    ],
], [
    ' แปลงใหม่มักทำคู่กับ รับปรับพื้นที่สวน และจัดสวนน้ำด้วย สวนน้ำตกจำลอง',
]);

applyPage('waste', [
    [
        'เพื่อให้ระบบบำบัดน้ำเสียของคุณทำงานได้อย่างมีประสิทธิภาพสูงสุด',
        'เพื่อให้ระบบบำบัดน้ำเสียของคุณทำงานได้อย่างมีประสิทธิภาพสูงสุด ควรวาง <a href="/pipe">ท่อระบายน้ำทิ้ง</a> ให้ถูกทาง และเทฐานถังด้วย <a href="/pour-concrete">งานเทพื้นปูน</a> ครับ',
        'l2', 1,
    ],
    [
        'อย่าปล่อยให้งาน <strong>วาง ถัง แซ ท</strong> กลายเป็นปัญหาใหญ่',
        'อย่าปล่อยให้งาน <strong>วาง ถัง แซ ท</strong> กลายเป็นปัญหาใหญ่ ดินอ่อนควร <a href="/footing">ทำฟุตติ้งถัง</a> หรือ <a href="/pile">เสารองรับถังบำบัด</a> ก่อนวาง',
        'l2b', 1,
    ],
], [
    ' ควรวาง ท่อระบายน้ำทิ้ง ให้ถูกทาง และเทฐานถังด้วย งานเทพื้นปูน ครับ',
    ' ดินอ่อนควร ทำฟุตติ้งถัง หรือ เสารองรับถังบำบัด ก่อนวาง',
]);

applyPage('steel', [
    [
        'ปริมาณงานทั้งโครงการ</strong> — ยิ่งพาดกว้าง ยิ่งสูง ยิ่งงานน้อย ราคาต่อตารางเมตรยิ่งแพงขึ้น',
        'ปริมาณงานทั้งโครงการ</strong> — ยิ่งพาดกว้าง ยิ่งสูง ยิ่งงานน้อย ราคาต่อตารางเมตรยิ่งแพงขึ้น ฐานเสาเหล็กมักใช้ <a href="/footing">ฟุตติ้งโครงเหล็ก</a> และพื้นโรงงานต่อด้วย <a href="/pour-concrete">เทพื้นโรงงาน</a> ครับ',
        'l2', 1,
    ],
], [
    ' ฐานเสาเหล็กมักใช้ ฟุตติ้งโครงเหล็ก และพื้นโรงงานต่อด้วย เทพื้นโรงงาน ครับ',
]);

// check steel string
$st = Service::where('slug', 'steel')->value('content');
if (! str_contains($st, 'ปริมาณงานทั้งโครงการ</strong> — ยิ่งพาดกว้าง ยิ่งสูง ยิ่งงานน้อย ราคาต่อตารางเมตรยิ่งแพงขึ้น')) {
    echo "STEEL STRING CHECK FAIL\n";
    $p = mb_strpos($st, 'ราคาต่อตารางเมตรยิ่งแพง', 0, 'UTF-8');
    echo mb_substr($st, max(0, $p - 80), 160, 'UTF-8')."\n";
}
