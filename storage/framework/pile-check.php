<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$c = App\Models\Service::where('slug', 'pile')->value('content');
foreach ([
    'ต่อเติมบ้าน กำแพงกันดิน อาคาร 1–2 ชั้น',
    'ต้องรื้อรั้ว หรือยกเครื่องข้ามบ้าน',
    'งานเบา ฐานรากเล็ก แผ่นพื้น',
] as $s) {
    echo (str_contains($c, $s) ? 'YES' : 'NO')." | {$s}\n";
}

// find a good paragraph end for L2
$p = mb_strpos($c, 'ทำไมต้องเลือก', 0, 'UTF-8');
echo "\n".mb_substr($c, 0, 400, 'UTF-8')."\n";
