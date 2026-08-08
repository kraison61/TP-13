<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Service;

function stripA(string $html): string
{
    return preg_replace('/<\/?a\b[^>]*>/', '', $html);
}

$slug = 'electrical-wiring';
$service = Service::where('slug', $slug)->firstOrFail();
$before = $service->content;
$old = 'สวนน้ำตกใช้ไฟปั๊มจากงานนี้คู่กับ <a href="/artificial-waterfall-garden">รับทำสวนน้ำตก</a>';
$new = 'สวนน้ำตกใช้ไฟปั๊มจากงานนี้คู่กับ <a href="/artificial-waterfall-garden">รับทำสวนน้ำตก</a> และจุดไฟปั๊มถังบำบัดคู่กับ <a href="/waste">ติดตั้งถังบำบัด</a>';
if (substr_count($before, $old) !== 1) {
    throw new RuntimeException('missing');
}
$content = str_replace($old, $new, $before);
$extra = ' และจุดไฟปั๊มถังบำบัดคู่กับ ติดตั้งถังบำบัด';
$test = stripA($content);
$plainBefore = stripA($before);
if (! str_contains($test, $extra)) {
    throw new RuntimeException('l2');
}
$test = str_replace($extra, '', $test);
if ($test !== $plainBefore) {
    throw new RuntimeException('mismatch');
}
$service->update(['content' => $content, 'updated_at' => now()]);
echo "OK waste inbound from electrical\n";
