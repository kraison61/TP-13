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

applyPage('steel', [
    [
        'สำหรับงานฐานราก งานรื้อของเดิม รางน้ำ และงานเก็บรายละเอียดที่มักไม่อยู่ในราคาต่อตารางเมตร',
        'สำหรับงานฐานราก <a href="/building-demolish">งานรื้อของเดิม</a> รางน้ำ และงานเก็บรายละเอียดที่มักไม่อยู่ในราคาต่อตารางเมตร เสาสูงควร <a href="/pile">ตอกเข็มรับโครง</a> และเดินไฟโรงงานคู่กับ <a href="/electrical-wiring">เดินสายไฟโรงงาน</a>',
        'l2', 1,
    ],
], [
    ' เสาสูงควร ตอกเข็มรับโครง และเดินไฟโรงงานคู่กับ เดินสายไฟโรงงาน',
]);

applyPage('cctv-installation', [
    [
        'รอบบ้านทุกด้าน รั้ว ภายใน',
        'รอบบ้านทุกด้าน <a href="/fence">รั้ว</a> ภายใน',
        'fence', 1,
    ],
    [
        'ลูกค้าไม่ต้องจัดหาอุปกรณ์เอง และไม่มีค่าใช้จ่ายซ่อนเร้น',
        'ลูกค้าไม่ต้องจัดหาอุปกรณ์เอง และไม่มีค่าใช้จ่ายซ่อนเร้น มักทำคู่กับ <a href="/electrical-wiring">เดินสายไฟฟ้าบ้าน</a> และ <a href="/outdoor-lan-cabling">เดินสายแลนภายนอก</a> ในงานเดียวกันครับ',
        'l2', 1,
    ],
], [
    ' มักทำคู่กับ เดินสายไฟฟ้าบ้าน และ เดินสายแลนภายนอก ในงานเดียวกันครับ',
]);

applyPage('electrical-wiring', [
    [
        'เดินสายไฟ ไฟเบอร์ออปติก LAN และกล้องวงจรปิด CCTV เดินท่อรอไว้ครั้งเดียวจบ',
        'เดินสายไฟ ไฟเบอร์ออปติก LAN และ<a href="/cctv-installation">กล้องวงจรปิด CCTV</a> เดินท่อรอไว้ครั้งเดียวจบ',
        'cctv', 1,
    ],
    [
        'ความต่างเกือบ 3 เท่านี้มาจากวิธีเดินสาย ขนาดสาย และเกรดอุปกรณ์เป็นหลัก',
        'ความต่างเกือบ 3 เท่านี้มาจากวิธีเดินสาย ขนาดสาย และเกรดอุปกรณ์เป็นหลัก งานภายนอกอาคารต่อด้วย <a href="/outdoor-lan-cabling">เดินสาย Outdoor LAN</a> และโครงหลังคาเหล็กคู่กับ <a href="/steel">โครงเหล็กหลังคา</a> ครับ',
        'l2', 1,
    ],
], [
    ' งานภายนอกอาคารต่อด้วย เดินสาย Outdoor LAN และโครงหลังคาเหล็กคู่กับ โครงเหล็กหลังคา ครับ',
]);

applyPage('outdoor-lan-cabling', [
    [
        'เปลือกจะเสื่อมเร็วและทำให้สัญญาณมีปัญหาในระยะเวลาไม่นาน',
        'เปลือกจะเสื่อมเร็วและทำให้สัญญาณมีปัญหาในระยะเวลาไม่นาน มักวางสายคู่กับ <a href="/electrical-wiring">ระบบไฟฟ้าภายนอก</a> และกล้อง <a href="/cctv-installation">ติดตั้ง CCTV ภายนอก</a> ครับ',
        'l2', 1,
    ],
], [
    ' มักวางสายคู่กับ ระบบไฟฟ้าภายนอก และกล้อง ติดตั้ง CCTV ภายนอก ครับ',
]);

applyPage('artificial-waterfall-garden', [
    [
        'จึงมักไม่ต้องลงเสาเข็มหรือทำฐานรากขนาดใหญ่',
        'จึงมักไม่ต้อง<a href="/pile">ลงเสาเข็มหรือทำฐานราก</a>ขนาดใหญ่',
        'pile', 1,
    ],
    [
        'จุดจ่ายไฟสำหรับปั๊มและทางระบายน้ำ',
        'จุดจ่ายไฟสำหรับปั๊มและทาง<a href="/pipe">ระบายน้ำ</a>',
        'pipe', 1,
    ],
    [
        'และควบคุมรูปทรงกับทิศทางน้ำได้ตามแบบ',
        'และควบคุมรูปทรงกับทิศทางน้ำได้ตามแบบ จัดวางคู่กับ <a href="/garden-plot">ขุดร่องสวนน้ำ</a> และปรับระดับด้วย <a href="/landjustment">ปรับพื้นที่สวน</a> ครับ',
        'l2', 1,
    ],
], [
    ' จัดวางคู่กับ ขุดร่องสวนน้ำ และปรับระดับด้วย ปรับพื้นที่สวน ครับ',
]);

applyPage('waste', [
    [
        'ควรวาง <a href="/pipe">ท่อระบายน้ำทิ้ง</a> ให้ถูกทาง และเทฐานถังด้วย <a href="/pour-concrete">งานเทพื้นปูน</a> ครับ',
        'ควรวาง <a href="/pipe">ท่อระบายน้ำทิ้ง</a> ให้ถูกทาง และเทฐานถังด้วย <a href="/pour-concrete">งานเทพื้นปูน</a> ครับ ขุดหลุมถังใช้ <a href="/excavator">แบคโฮขุดหลุมถัง</a> ได้',
        'top', 1,
    ],
], [
    ' ขุดหลุมถังใช้ แบคโฮขุดหลุมถัง ได้',
]);

applyPage('demolish', [
    [
        'ขนออกด้วย <a href="/truck">รถหกล้อรับจ้าง</a> และเคลียร์วัชพืชด้วย <a href="/clearforest">งานเคลียร์ริ่ง</a> ก่อนปลูกสร้างใหม่ครับ',
        'ขนออกด้วย <a href="/truck">รถหกล้อรับจ้าง</a> และเคลียร์วัชพืชด้วย <a href="/clearforest">งานเคลียร์ริ่ง</a> ก่อนปลูกสร้างใหม่ครับ จากนั้น <a href="/landjustment">ปรับพื้นที่หลังรื้อ</a>',
        'top', 1,
    ],
], [
    ' จากนั้น ปรับพื้นที่หลังรื้อ',
]);
