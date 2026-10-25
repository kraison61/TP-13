<?php

/**
 * Assign stable SKUs to electrical-wiring prices and rewrite service content
 * to use {{price:*}} shortcodes resolved from service_prices at render time.
 */

use App\Models\Service;
use App\Models\ServicePrice;
use Illuminate\Support\Facades\DB;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$service = Service::query()->where('id', 20)->orWhere('slug', 'electrical-wiring')->first();
if (! $service) {
    fwrite(STDERR, "Service electrical-wiring not found\n");
    exit(1);
}

$skuById = [
    165 => 'ELEC-PKG-10',
    166 => 'ELEC-PKG-EXTRA',
    167 => 'ELEC-SURVEY',
    168 => 'ELEC-MAIN',
    169 => 'ELEC-MAT-LIGHT',
    170 => 'ELEC-MAT-OUTLET',
    171 => 'ELEC-GROUND-LABOR',
    172 => 'ELEC-MAT-AC',
    173 => 'ELEC-SUBPANEL',
    174 => 'ELEC-MAINPANEL-LABOR',
    175 => 'ELEC-MAT-GROUND',
    176 => 'ELEC-MAT-CU',
    177 => 'ELEC-LABOR-LIGHT-SURFACE',
    178 => 'ELEC-LABOR-OUTLET-SURFACE',
    179 => 'ELEC-LABOR-LIGHT-CONCEALED',
    180 => 'ELEC-LABOR-OUTLET-CONCEALED',
    181 => 'ELEC-LABOR-AC',
    182 => 'ELEC-LABOR-OUTLET-OUTDOOR',
];

DB::transaction(function () use ($service, $skuById) {
    foreach ($skuById as $id => $sku) {
        ServicePrice::query()
            ->where('service_id', $service->id)
            ->where('id', $id)
            ->update(['sku' => $sku, 'updated_at' => now()]);
    }

    $content = $service->content;
    if (! is_string($content) || $content === '') {
        throw new RuntimeException('Service content is empty');
    }

    // Avoid double-processing if script is re-run.
    if (str_contains($content, '{{price:')) {
        echo "Content already contains price shortcodes; SKUs updated only.\n";

        return;
    }

    $replacements = [
        'อัปเดตล่าสุด 30 กันยายน 2569' => 'อัปเดตล่าสุด 4 ตุลาคม 2569',

        // Lead
        'ค่าแรงล้วนเริ่มที่ 250 บาทต่อจุดสำหรับงานเดินลอย และขึ้นไปถึง 1,200 บาทต่อจุดสำหรับงานฝังผนังที่ต้องกรีดผนังและร้อยท่อ (จุดไฟแอร์ 800–1,500 บาท) ส่วนราคาแบบรวมวัสดุอยู่ที่ 700–2,800 บาทต่อจุด'
            => 'ค่าแรงล้วนเริ่มที่ {{price_min:ELEC-LABOR-LIGHT-SURFACE}} บาทต่อจุดสำหรับงานเดินลอย และขึ้นไปถึง {{price_max:ELEC-LABOR-OUTLET-OUTDOOR}} บาทต่อจุดสำหรับงานฝังผนังที่ต้องกรีดผนังและร้อยท่อ (จุดไฟแอร์ {{price:ELEC-LABOR-AC}} บาท) ส่วนราคาแบบรวมวัสดุอยู่ที่ {{price_min:ELEC-MAT-LIGHT}}–{{price_max:ELEC-MAT-OUTLET}} บาทต่อจุดสำหรับจุดไฟ/ปลั๊ก และจุดไฟแอร์{{price:ELEC-MAT-AC}} บาท',

        // Labor table
        '<tr><td>จุดไฟแสงสว่าง + สวิตช์ (ตีกิ๊บ/ท่อลอย)</td><td>250 – 450</td><td>ราคาถูกสุด เหมาะบ้านไม้/พื้นที่เปิด</td></tr>'
            => '<tr><td>จุดไฟแสงสว่าง + สวิตช์ (ตีกิ๊บ/ท่อลอย)</td><td>{{price:ELEC-LABOR-LIGHT-SURFACE}}</td><td>ราคาถูกสุด เหมาะบ้านไม้/พื้นที่เปิด</td></tr>',
        '<tr><td>จุดปลั๊กไฟ (ตีกิ๊บ/ท่อลอย)</td><td>250 – 450</td><td>—</td></tr>'
            => '<tr><td>จุดปลั๊กไฟ (ตีกิ๊บ/ท่อลอย)</td><td>{{price:ELEC-LABOR-OUTLET-SURFACE}}</td><td>—</td></tr>',
        '<tr><td>จุดไฟแสงสว่าง + สวิตช์ (ฝังผนังร้อยท่อ)</td><td>600 – 900</td><td>รวมกรีดผนัง ฝังท่อ ฉาบซ่อม</td></tr>'
            => '<tr><td>จุดไฟแสงสว่าง + สวิตช์ (ฝังผนังร้อยท่อ)</td><td>{{price:ELEC-LABOR-LIGHT-CONCEALED}}</td><td>รวมกรีดผนัง ฝังท่อ ฉาบซ่อม</td></tr>',
        '<tr><td>จุดปลั๊กไฟ (ฝังผนังร้อยท่อ)</td><td>700 – 1,000</td><td>—</td></tr>'
            => '<tr><td>จุดปลั๊กไฟ (ฝังผนังร้อยท่อ)</td><td>{{price:ELEC-LABOR-OUTLET-CONCEALED}}</td><td>—</td></tr>',
        '<tr><td>จุดปลั๊กกันน้ำภายนอกบ้าน</td><td>900 – 1,200</td><td>ต้องกันน้ำ กันแดด</td></tr>'
            => '<tr><td>จุดปลั๊กกันน้ำภายนอกบ้าน</td><td>{{price:ELEC-LABOR-OUTLET-OUTDOOR}}</td><td>ต้องกันน้ำ กันแดด</td></tr>',
        '<tr><td>จุดไฟแอร์ + เบรกเกอร์ย่อย</td><td>800 – 1,500</td><td>ใช้สายใหญ่กว่า แยกวงจร</td></tr>'
            => '<tr><td>จุดไฟแอร์ + เบรกเกอร์ย่อย</td><td>{{price:ELEC-LABOR-AC}}</td><td>ใช้สายใหญ่กว่า แยกวงจร</td></tr>',
        '<tr><td>เดินสายเมนเข้าอาคาร</td><td>80 – 120 /เมตร</td><td>คิดตามระยะจริง</td></tr>'
            => '<tr><td>เดินสายเมนเข้าอาคาร</td><td>{{price:ELEC-MAIN}} /เมตร</td><td>คิดตามระยะจริง</td></tr>',
        '<tr><td>ติดตั้งตู้คอนซูมเมอร์ยูนิต (ตู้หลัก)</td><td>2,500 – 4,500 /ตู้</td><td>ไม่รวมค่าตู้</td></tr>'
            => '<tr><td>ติดตั้งตู้คอนซูมเมอร์ยูนิต (ตู้หลัก)</td><td>{{price:ELEC-MAINPANEL-LABOR}} /ตู้</td><td>ไม่รวมค่าตู้</td></tr>',
        '<tr><td>ติดตั้งตู้ย่อยตามชั้น</td><td>2,000 – 2,500 /ตู้</td><td>บ้าน 2 ชั้นขึ้นไปแนะนำมี</td></tr>'
            => '<tr><td>ติดตั้งตู้ย่อยตามชั้น</td><td>{{price:ELEC-SUBPANEL}} /ตู้</td><td>บ้าน 2 ชั้นขึ้นไปแนะนำมี</td></tr>',
        '<tr><td>ติดตั้งหลักดิน + เดินสายดิน</td><td>1,500 – 3,000 /ชุด</td><td>ห้ามตัดออกเพื่อประหยัด</td></tr>'
            => '<tr><td>ติดตั้งหลักดิน + เดินสายดิน</td><td>{{price:ELEC-GROUND-LABOR}} /ชุด</td><td>ห้ามตัดออกเพื่อประหยัด</td></tr>',

        // Materials table
        '<tr><td>จุดไฟแสงสว่าง + สวิตช์</td><td>700 – 1,000</td></tr>'
            => '<tr><td>จุดไฟแสงสว่าง + สวิตช์</td><td>{{price:ELEC-MAT-LIGHT}}</td></tr>',
        '<tr><td>จุดปลั๊ก 3 รู มีสายดิน (เดี่ยว/คู่)</td><td>900 – 2,200</td></tr>'
            => '<tr><td>จุดปลั๊ก 3 รู มีสายดิน (เดี่ยว/คู่)</td><td>{{price:ELEC-MAT-OUTLET}}</td></tr>',
        '<tr><td>จุดไฟแอร์ พร้อมเบรกเกอร์</td><td>1,500 – 2,800</td></tr>'
            => '<tr><td>จุดไฟแอร์ พร้อมเบรกเกอร์</td><td>{{price:ELEC-MAT-AC}}</td></tr>',
        '<tr><td>ตู้คอนซูมเมอร์ 10–14 ช่อง พร้อม RCD/RCBO</td><td>8,000 – 16,000</td></tr>'
            => '<tr><td>ตู้คอนซูมเมอร์ 10–14 ช่อง พร้อม RCD/RCBO</td><td>{{price:ELEC-MAT-CU}}</td></tr>',
        '<tr><td>ชุดหลักดิน + สายดินครบระบบ</td><td>3,000 – 6,000</td></tr>'
            => '<tr><td>ชุดหลักดิน + สายดินครบระบบ</td><td>{{price:ELEC-MAT-GROUND}}</td></tr>',

        // Package
        'ราคา <strong>20,000 บาท สำหรับ 1–10 จุด รวมค่าแรงและวัสดุแล้ว</strong> ตั้งแต่จุดที่ 11 ขึ้นไปคิด <strong>จุดละ 2,000 บาท</strong>'
            => 'ราคา <strong>{{price:ELEC-PKG-10}} บาท สำหรับ 1–10 จุด รวมค่าแรงและวัสดุแล้ว</strong> ตั้งแต่จุดที่ 11 ขึ้นไปคิด <strong>จุดละ {{price:ELEC-PKG-EXTRA}} บาท</strong>',
        '<tr><td>1–10 จุด</td><td>เหมา 20,000 บาท</td></tr>'
            => '<tr><td>1–10 จุด</td><td>เหมา {{price:ELEC-PKG-10}} บาท</td></tr>',
        '<tr><td>จุดที่ 11 ขึ้นไป</td><td>จุดละ 2,000 บาท</td></tr>'
            => '<tr><td>จุดที่ 11 ขึ้นไป</td><td>จุดละ {{price:ELEC-PKG-EXTRA}} บาท</td></tr>',
        '<tr><td>ตัวอย่าง 15 จุด</td><td>20,000 + (5 × 2,000) = 30,000 บาท</td></tr>'
            => '<tr><td>ตัวอย่าง 15 จุด</td><td>{{price:ELEC-PKG-10}} + (5 × {{price:ELEC-PKG-EXTRA}}) = {{price_expr:ELEC-PKG-10 + 5 * ELEC-PKG-EXTRA}} บาท</td></tr>',
        '<tr><td>ตัวอย่าง 25 จุด</td><td>20,000 + (15 × 2,000) = 50,000 บาท</td></tr>'
            => '<tr><td>ตัวอย่าง 25 จุด</td><td>{{price:ELEC-PKG-10}} + (15 × {{price:ELEC-PKG-EXTRA}}) = {{price_expr:ELEC-PKG-10 + 15 * ELEC-PKG-EXTRA}} บาท</td></tr>',
        'บ้าน 30 จุด = 20,000 + (20 × 2,000) = 60,000 บาท'
            => 'บ้าน 30 จุด = {{price:ELEC-PKG-10}} + (20 × {{price:ELEC-PKG-EXTRA}}) = {{price_expr:ELEC-PKG-10 + 20 * ELEC-PKG-EXTRA}} บาท',
        'แพ็กเกจเหมา 1–10 จุด 20,000 บาทรวมวัสดุ จุดเพิ่มจุดละ 2,000 บาท'
            => 'แพ็กเกจเหมา 1–10 จุด {{price:ELEC-PKG-10}} บาทรวมวัสดุ จุดเพิ่มจุดละ {{price:ELEC-PKG-EXTRA}} บาท',
        'ค่าบริการเริ่มต้น 1,500 บาท (ขึ้นกับระยะทาง)'
            => 'ค่าบริการ{{price:ELEC-SURVEY}} บาท (ขึ้นกับระยะทาง)',

        // Year comparison (2569 column)
        '<tr><td>ค่าแรงจุดไฟแสงสว่าง (เดินลอย)</td><td>200 – 350</td><td>250 – 450</td><td>▲</td></tr>'
            => '<tr><td>ค่าแรงจุดไฟแสงสว่าง (เดินลอย)</td><td>200 – 350</td><td>{{price:ELEC-LABOR-LIGHT-SURFACE}}</td><td>▲</td></tr>',
        '<tr><td>ค่าแรงจุดฝังผนัง</td><td>500 – 900</td><td>600 – 1,200</td><td>▲▲</td></tr>'
            => '<tr><td>ค่าแรงจุดฝังผนัง</td><td>500 – 900</td><td>{{price_min:ELEC-LABOR-LIGHT-CONCEALED}} – {{price_max:ELEC-LABOR-OUTLET-OUTDOOR}}</td><td>▲▲</td></tr>',
        '<tr><td>จุดไฟแอร์ (รวมของ)</td><td>1,200 – 2,000</td><td>1,500 – 2,800</td><td>▲▲</td></tr>'
            => '<tr><td>จุดไฟแอร์ (รวมของ)</td><td>1,200 – 2,000</td><td>{{price:ELEC-MAT-AC}}</td><td>▲▲</td></tr>',
        '<tr><td>ตู้คอนซูมเมอร์พร้อม RCD</td><td>6,000 – 12,000</td><td>8,000 – 16,000</td><td>▲▲</td></tr>'
            => '<tr><td>ตู้คอนซูมเมอร์พร้อม RCD</td><td>6,000 – 12,000</td><td>{{price:ELEC-MAT-CU}}</td><td>▲▲</td></tr>',
    ];

    $missing = [];
    foreach ($replacements as $from => $to) {
        if (! str_contains($content, $from)) {
            $missing[] = mb_substr($from, 0, 80);
            continue;
        }
        $content = str_replace($from, $to, $content);
    }

    if ($missing !== []) {
        fwrite(STDERR, "Some replacements were not found:\n- ".implode("\n- ", $missing)."\n");
        exit(1);
    }

    // Fix awkward spacing around starting_at in lead ("และจุดไฟแอร์เริ่มต้น 2,500")
    $content = str_replace(
        'และจุดไฟแอร์{{price:ELEC-MAT-AC}} บาท',
        'และจุดไฟแอร์ {{price:ELEC-MAT-AC}} บาท',
        $content
    );

    $service->update([
        'content' => $content,
        'updated_at' => now(),
    ]);

    echo "Updated service #{$service->id} content with price shortcodes.\n";
    echo 'Shortcode count: '.substr_count($content, '{{price')."\n";
});
