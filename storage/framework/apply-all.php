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

    foreach ($replacements as [$old, $new, $label, $expectedCount]) {
        $expectedCount ??= 1;
        $count = substr_count($content, $old);
        if ($count === 0) {
            throw new RuntimeException("{$slug}: MISSING {$label}");
        }
        if ($expectedCount === 1 && $count !== 1) {
            throw new RuntimeException("{$slug}: NOT UNIQUE {$label} count={$count}");
        }
        $pos = strpos($content, $old);
        $content = substr($content, 0, $pos).$new.substr($content, $pos + strlen($old));
    }

    $test = stripA($content);
    $plainBefore = stripA($before);
    foreach ($l2PlainExtras as $s) {
        if (! str_contains($test, $s)) {
            throw new RuntimeException("{$slug}: L2 plain missing: {$s}");
        }
        $test = str_replace($s, '', $test);
    }
    if ($test !== $plainBefore) {
        $max = min(strlen($test), strlen($plainBefore));
        for ($i = 0; $i < $max; $i++) {
            if ($test[$i] !== $plainBefore[$i]) {
                throw new RuntimeException("{$slug}: plain mismatch@{$i}: [".mb_substr($test, max(0, $i - 15), 40, 'UTF-8').'] vs ['.mb_substr($plainBefore, max(0, $i - 15), 40, 'UTF-8').']');
            }
        }
        throw new RuntimeException("{$slug}: plain length mismatch");
    }

    $slugs = Service::pluck('slug')->all();
    $countSvc = function (string $html) use ($slugs, $slug): array {
        preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>([^<]*)<\/a>/', $html, $m, PREG_SET_ORDER);
        $out = [];
        foreach ($m as $row) {
            $href = $row[1];
            if (! str_starts_with($href, '/') || str_starts_with($href, '//')) {
                continue;
            }
            $path = ltrim(parse_url($href, PHP_URL_PATH) ?: '', '/');
            if ($path !== '' && ! str_contains($path, '/') && in_array($path, $slugs, true) && $path !== $slug) {
                $out[] = [$href, $row[2]];
            }
        }

        return $out;
    };

    $serviceLinks = $countSvc($content);
    $delta = (strlen($content) - strlen($before)) / max(strlen($before), 1) * 100;
    if ($delta > 15) {
        throw new RuntimeException("{$slug}: delta {$delta}%");
    }
    if (count($serviceLinks) > $maxServiceLinks) {
        throw new RuntimeException("{$slug}: links ".count($serviceLinks)." > {$maxServiceLinks}");
    }

    $service->update(['content' => $content, 'updated_at' => now()]);
    echo 'OK '.$slug.' delta='.round($delta, 2).'% links='.count($serviceLinks)."\n";
    foreach ($serviceLinks as [$h, $t]) {
        echo "   {$h} | {$t}\n";
    }
}

// ---- LANDFILL ----
applyPage('landfill', [
    ['สามารถลงเสาเข็มได้เลยหรือไม่?', 'สามารถ<a href="/pile">ลงเสาเข็ม</a>ได้เลยหรือไม่?', 'pile', 1],
    ['เรามีทีมรถบรรทุก รถแม็คโคร และเครื่องจักรกลหนัก', 'เรามีทีม<a href="/truck">รถบรรทุก</a> <a href="/excavator">รถแม็คโคร</a> และเครื่องจักรกลหนัก', 'truck-excavator', 1],
    ['นิยมใช้ถมเพื่อปรับพื้นก่อนเทคอนกรีต', 'นิยมใช้ถมเพื่อปรับพื้นก่อน<a href="/pour-concrete">เทคอนกรีต</a>', 'pour', 1],
    [
        'หากถมสูงกว่าที่ดินข้างเคียง กฎหมายระบุชัดเจนว่าต้องจัดการระบายน้ำให้เพียงพอ เพื่อป้องกันความเสียหายต่อพื้นที่ติดกัน',
        'หากถมสูงกว่าที่ดินข้างเคียง กฎหมายระบุชัดเจนว่าต้องจัดการระบายน้ำให้เพียงพอ เพื่อป้องกันความเสียหายต่อพื้นที่ติดกัน และควรทำ <a href="/retaining-wall">สร้างกำแพงกันดิน</a> ควบคู่เพื่อกันดินไหลครับ',
        'rw',
        1,
    ],
], [
    ' และควรทำ สร้างกำแพงกันดิน ควบคู่เพื่อกันดินไหลครับ',
], 5);

echo "LANDFILL DONE\n";
