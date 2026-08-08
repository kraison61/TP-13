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
            throw new RuntimeException("{$slug}: NOT UNIQUE {$label} count={$count}");
        }
        $pos = strpos($content, $old);
        $content = substr($content, 0, $pos).$new.substr($content, $pos + strlen($old));
    }

    $test = stripA($content);
    $plainBefore = stripA($before);
    foreach ($l2PlainExtras as $s) {
        if (! str_contains($test, $s)) {
            throw new RuntimeException("{$slug}: L2 missing: {$s}");
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
        throw new RuntimeException("{$slug}: too many links ".count($serviceLinks));
    }

    $service->update(['content' => $content, 'updated_at' => now()]);
    echo 'OK '.$slug.' +'.round($delta, 2).'% n='.count($serviceLinks)."\n";
    foreach ($serviceLinks as [$h, $t]) {
        echo "  {$h} | {$t}\n";
    }
}

// ===== PILE =====
$pileLeadEnd = 'โดยอัตราต่อเมตรขึ้นอยู่กับขนาดเสา — เสาเข็มไอ 15 เมตรละ 70 บาท, ไอ 18 เมตรละ 80 บาท, ไอ 22 เมตรละ 100 บาท, ไอ 26 เมตรละ';
// need full end of lead - fetch
$pile = Service::where('slug', 'pile')->value('content');
if (preg_match('/<div class="lead">\s*<p>(.*?)<\/p>\s*<\/div>/su', $pile, $m)) {
    echo "PILE LEAD END: ".mb_substr($m[1], -80, null, 'UTF-8')."\n";
}

$pipe = Service::where('slug', 'pipe')->value('content');
if (preg_match('/<div class="lead">\s*<p>(.*?)<\/p>\s*<\/div>/su', $pipe, $m)) {
    echo "PIPE LEAD: ".mb_substr(strip_tags($m[1]), 0, 120, 'UTF-8')."\n";
    echo "PIPE LEAD END: ".mb_substr($m[1], -100, null, 'UTF-8')."\n";
}

foreach (['pour-concrete', 'footing', 'clearforest', 'landjustment', 'shipment', 'building-demolish'] as $slug) {
    $c = Service::where('slug', $slug)->value('content');
    if (preg_match('/<div class="lead">\s*<p>(.*?)<\/p>\s*<\/div>/su', $c, $m)) {
        echo strtoupper($slug)." LEAD END: [".mb_substr(trim(strip_tags($m[1])), -70, null, 'UTF-8')."]\n";
    } else {
        // first p
        if (preg_match('/<p[^>]*>(.*?)<\/p>/su', $c, $m)) {
            echo strtoupper($slug)." FIRST P END: [".mb_substr(trim(strip_tags($m[1])), -70, null, 'UTF-8')."]\n";
        }
    }
}
