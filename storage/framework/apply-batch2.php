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

applyPage('pile', [
    [
        'ต่อเติมบ้าน กำแพงกันดิน อาคาร 1–2 ชั้น',
        '<a href="/retaining-wall">ต่อเติมบ้าน กำแพงกันดิน อาคาร</a> 1–2 ชั้น',
        'rw', 1,
    ],
    [
        'ต้องรื้อรั้ว หรือยกเครื่องข้ามบ้าน',
        'ต้อง<a href="/fence">รื้อรั้ว</a> หรือยกเครื่องข้ามบ้าน',
        'fence', 1,
    ],
    [
        'ยิ่งตอกลึกเท่าไหร่ ราคาก็เพิ่มตามความยาวนั้น',
        'ยิ่งตอกลึกเท่าไหร่ ราคาก็เพิ่มตามความยาวนั้น หลังกดเสาเข็มมักทำ <a href="/footing">งานฟุตติ้ง</a> ต่อ และถ้าพื้นเป็นดินถมควรเตรียมด้วยบริการ <a href="/landfill">ถมที่ให้แน่น</a> ก่อนปลูกสร้างครับ',
        'l2', 1,
    ],
    [
        'งานเบา ฐานรากเล็ก แผ่นพื้น',
        'งานเบา ฐานรากเล็ก แผ่นพื้น ต่อด้วย <a href="/pour-concrete">เทพื้นคอนกรีต</a>',
        'pour', 1,
    ],
], [
    ' หลังกดเสาเข็มมักทำ งานฟุตติ้ง ต่อ และถ้าพื้นเป็นดินถมควรเตรียมด้วยบริการ ถมที่ให้แน่น ก่อนปลูกสร้างครับ',
    ' ต่อด้วย เทพื้นคอนกรีต',
]);

applyPage('pipe', [
    [
        'และช่วยป้องกันปัญหาน้ำท่วมขังหรือน้ำรั่วซึมในอนาคต',
        'และช่วยป้องกันปัญหาน้ำท่วมขังหรือน้ำรั่วซึมในอนาคต งานท่อหลัง <a href="/retaining-wall">งานกำแพงกันดิน</a> สำคัญมาก และพื้นที่ต่ำควร <a href="/landfill">ปรับถมที่</a> ให้ได้ระดับก่อนวางท่อครับ',
        'l2', 1,
    ],
    [
        'ท่อคอนกรีตสำหรับการวางท่อระบายน้ำถนน',
        'ท่อคอนกรีตสำหรับการวางท่อระบายน้ำถนน งานขุดแนวท่อใช้ <a href="/excavator">เช่ารถแม็คโคร</a> ได้',
        'exc', 1,
    ],
    [
        'งานวางท่อระบายน้ำ เป็นหนึ่งในงานก่อสร้างที่ต้องอาศัยทั้งประสบการณ์และความละเอียดสูง',
        'งานวางท่อระบายน้ำ เป็นหนึ่งในงานก่อสร้างที่ต้องอาศัยทั้งประสบการณ์และความละเอียดสูง ริมตลิ่งอาจทำคู่กับ <a href="/dam">เขื่อนกันตลิ่ง</a>',
        'dam', 1,
    ],
], [
    ' งานท่อหลัง งานกำแพงกันดิน สำคัญมาก และพื้นที่ต่ำควร ปรับถมที่ ให้ได้ระดับก่อนวางท่อครับ',
    ' งานขุดแนวท่อใช้ เช่ารถแม็คโคร ได้',
    ' ริมตลิ่งอาจทำคู่กับ เขื่อนกันตลิ่ง',
]);

applyPage('pour-concrete', [
    [
        'ไม่ว่าจะเป็น 10 ซม., 15 ซม. หรือ 20 ซม.',
        'ไม่ว่าจะเป็น 10 ซม., 15 ซม. หรือ 20 ซม. พื้นถนนมักทำหลัง <a href="/landfill">งานถมที่ดิน</a> ฐานเสารั้วสัมพันธ์กับ <a href="/fence">รั้วสำเร็จรูป</a> และคานพื้นต่อจาก <a href="/footing">ฐานฟุตติ้ง</a> ครับ',
        'l2a', 1,
    ],
    [
        'ทั้งแบบงานเหมา งานบ้าน หรืองานโรงงาน',
        'ทั้งแบบงานเหมา งานบ้าน หรืองานโรงงาน ควรวาง <a href="/pipe">ระบบท่อระบายน้ำ</a> รอบพื้นก่อนเท และถ้าดินอ่อนให้ <a href="/pile">ตอกเสาเข็มไอ</a> ก่อนครับ',
        'l2b', 1,
    ],
], [
    ' พื้นถนนมักทำหลัง งานถมที่ดิน ฐานเสารั้วสัมพันธ์กับ รั้วสำเร็จรูป และคานพื้นต่อจาก ฐานฟุตติ้ง ครับ',
    ' ควรวาง ระบบท่อระบายน้ำ รอบพื้นก่อนเท และถ้าดินอ่อนให้ ตอกเสาเข็มไอ ก่อนครับ',
]);

applyPage('footing', [
    [
        'ตั้งแต่ขุดหลุม ฐานราก ฟุตติ้ง จนถึงเทคอนกรีต คาน เสา แผ่นพื้น งานมาตรฐาน ทีมงานมืออาชีพ ราคากันเอง',
        'ตั้งแต่ขุดหลุม ฐานราก ฟุตติ้ง จนถึง<a href="/pour-concrete">เทคอนกรีต คาน</a> เสา แผ่นพื้น งานมาตรฐาน ทีมงานมืออาชีพ ราคากันเอง ฐานรั้วบ้านใช้คู่กับ <a href="/fence">งานรั้วบ้าน</a> และแนวเขตต่างระดับควรมี <a href="/retaining-wall">โครงสร้างกำแพงกันดิน</a> ครับ',
        'lead', 1,
    ],
    [
        'แล้วถ่ายน้ำหนักลงสู่ดินผ่านเสาเข็มหรือโดยตรง',
        'แล้วถ่ายน้ำหนักลงสู่ดินผ่าน<a href="/pile">เสาเข็มหรือโดยตรง</a>',
        'pile', 1,
    ],
    [
        'ความแข็งแรงของวัสดุคอนกรีต',
        'ความแข็งแรงของวัสดุคอนกรีต บนดินถมใหม่ควรเตรียม <a href="/landfill">พื้นถมดิน</a> ให้แน่นก่อนเทฐาน',
        'lf', 1,
    ],
], [
    ' ฐานรั้วบ้านใช้คู่กับ งานรั้วบ้าน และแนวเขตต่างระดับควรมี โครงสร้างกำแพงกันดิน ครับ',
    ' บนดินถมใหม่ควรเตรียม พื้นถมดิน ให้แน่นก่อนเทฐาน',
]);

applyPage('clearforest', [
    [
        'งาน <strong>เคลียร์ ริ่ ง ปรับพื้นที่</strong> สำหรับทำถนน',
        'งาน <strong>เคลียร์ ริ่ ง <a href="/landjustment">ปรับพื้นที่</a></strong> สำหรับทำถนน',
        'lj', 1,
    ],
    [
        'ผู้เชี่ยวชาญด้านการ <strong>ถางป่า</strong>, <strong>ขุดตอ</strong> และ <strong>เคลียร์ ริ่ ง พื้นที่</strong> แบบครบวงจร',
        'ผู้เชี่ยวชาญด้านการ <strong>ถางป่า</strong>, <strong>ขุดตอ</strong> และ <strong>เคลียร์ ริ่ ง พื้นที่</strong> แบบครบวงจร ใช้ <a href="/excavator">แม็คโครให้เช่า</a> ขุดตอ และขนเศษด้วย <a href="/truck">รถบรรทุก 6 ล้อ</a> หลังเคลียร์มัก <a href="/landfill">ถมปรับระดับ</a> ครับ',
        'l2', 1,
    ],
    [
        'งานถางป่า งานขุดตอไม้ ตัดต้นไม้ใหญ่',
        'งานถางป่า งานขุดตอไม้ ตัดต้นไม้ใหญ่ เศษไม้ใช้บริการ <a href="/shipment">รับขนเศษวัสดุ</a>',
        'ship', 1,
    ],
], [
    ' ใช้ แม็คโครให้เช่า ขุดตอ และขนเศษด้วย รถบรรทุก 6 ล้อ หลังเคลียร์มัก ถมปรับระดับ ครับ',
    ' เศษไม้ใช้บริการ รับขนเศษวัสดุ',
]);

applyPage('landjustment', [
    [
        'ทั้งปรับที่ดิน ถมดิน ปรับหน้าดิน สวน ไร่นา และพื้นที่ก่อสร้าง พร้อมให้คำปรึกษาและประเมินราคาเบื้องต้นฟรี',
        'ทั้งปรับที่ดิน <a href="/landfill">ถมดิน ปรับหน้าดิน</a> สวน ไร่นา และพื้นที่ก่อสร้าง พร้อมให้คำปรึกษาและประเมินราคาเบื้องต้นฟรี งานใหญ่ใช้ <a href="/excavator">แบคโฮปรับพื้นที่</a> และอาจต่อด้วย <a href="/clearforest">งานถางป่าขุดตอ</a> ครับ',
        'lead', 1,
    ],
    [
        'มีเครื่องจักรหลากหลาย เช่น รถแบคโฮ รถไถ รถเกรดเดอร์',
        'มีเครื่องจักรหลากหลาย เช่น <a href="/excavator">รถแบคโฮ</a> รถไถ รถเกรดเดอร์',
        'exc', 1,
    ],
    [
        'การวางแผนระบบระบายน้ำอย่างรัดกุม',
        'การวางแผน<a href="/pipe">ระบบระบายน้ำ</a>อย่างรัดกุม',
        'pipe', 1,
    ],
], [
    ' งานใหญ่ใช้ แบคโฮปรับพื้นที่ และอาจต่อด้วย งานถางป่าขุดตอ ครับ',
]);
