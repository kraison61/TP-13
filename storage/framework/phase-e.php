<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Service;

$services = Service::orderBy('slug')->get(['slug', 'content', 'updated_at']);
$slugs = $services->pluck('slug')->all();

$inbound = array_fill_keys($slugs, 0);
$outbound = array_fill_keys($slugs, 0);
$anchors = [];
$bad = [];
$lengths = [];

foreach ($services as $s) {
    $lengths[$s->slug] = strlen($s->content);
    preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>([^<]*)<\/a>/', $s->content, $m, PREG_SET_ORDER);
    foreach ($m as $row) {
        $href = $row[1];
        $anchor = $row[2];
        if (! str_starts_with($href, '/') || str_starts_with($href, '//')) {
            continue;
        }
        $path = ltrim(parse_url($href, PHP_URL_PATH) ?: '', '/');
        if ($path === '' || str_contains($path, '/')) {
            continue;
        }
        if (! in_array($path, $slugs, true)) {
            $bad[] = "{$s->slug} → {$href}";
            continue;
        }
        if ($path === $s->slug) {
            continue;
        }
        $inbound[$path]++;
        $outbound[$s->slug]++;
        $anchors[$anchor] = ($anchors[$anchor] ?? 0) + 1;
    }
}

echo "=== 1. INBOUND / OUTBOUND ===\n";
printf("%-32s %4s %4s\n", 'slug', 'in', 'out');
foreach ($slugs as $slug) {
    printf("%-32s %4d %4d\n", $slug, $inbound[$slug], $outbound[$slug]);
}

echo "\n=== 2. BAD HREF ===\n";
echo empty($bad) ? "none\n" : implode("\n", $bad)."\n";

echo "\n=== 3. ANCHORS > 2 ===\n";
$over = false;
foreach ($anchors as $a => $n) {
    if ($n > 2) {
        echo "{$n}x {$a}\n";
        $over = true;
    }
}
echo $over ? '' : "none\n";

echo "\n=== 4. INBOUND < 2 ===\n";
foreach ($inbound as $slug => $n) {
    if ($n < 2) {
        echo "{$n}  {$slug}\n";
    }
}

echo "\n=== 5. CONTENT LENGTH ===\n";
foreach ($lengths as $slug => $len) {
    echo "{$slug}\t{$len}\n";
}

echo "\n=== ANCHORS = 2 (at cap) ===\n";
foreach ($anchors as $a => $n) {
    if ($n === 2) {
        echo "2x {$a}\n";
    }
}

echo "\nTOTAL service-service links: ".array_sum($inbound)."\n";
echo "ORPHANS: ";
$orphans = [];
foreach ($inbound as $slug => $n) {
    if ($n === 0) {
        $orphans[] = $slug;
    }
}
echo (empty($orphans) ? 'none' : implode(', ', $orphans))."\n";
