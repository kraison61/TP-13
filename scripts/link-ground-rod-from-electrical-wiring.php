<?php

/**
 * Reverse-link electrical-wiring service page → ground-rod blog.
 */

use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$service = Service::where('slug', 'electrical-wiring')->firstOrFail();

if (str_contains($service->content, 'ground-rod-installation-home')) {
    echo "Already linked in service #{$service->id}\n";
    exit(0);
}

$old = 'มีระบบสายดินและ RCD ครบไหม</strong> — บางใบเสนอราคาถูกเพราะตัดหลักดินและเบรกเกอร์กันดูดออก อ่านเพิ่มว่าทำไมระบบนี้สำคัญที่บทความ<a href="/blogs/short-circuit-house-fire">ไฟฟ้าลัดวงจรเกิดจากอะไร</a>';
$new = 'มีระบบสายดินและ RCD ครบไหม</strong> — บางใบเสนอราคาถูกเพราะตัดหลักดินและเบรกเกอร์กันดูดออก อ่านคู่มือ<a href="/blogs/ground-rod-installation-home">ตอกแท่งกราวด์ในบ้าน</a> และว่าทำไมระบบนี้สำคัญที่บทความ<a href="/blogs/short-circuit-house-fire">ไฟฟ้าลัดวงจรเกิดจากอะไร</a>';

if (! str_contains($service->content, $old)) {
    fwrite(STDERR, "Anchor text not found in electrical-wiring content\n");
    exit(1);
}

$service->content = str_replace($old, $new, $service->content);
$service->save();

echo "Linked ground-rod blog from service #{$service->id}\n";
