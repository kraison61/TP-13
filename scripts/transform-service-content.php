<?php

use App\Models\Service;
use App\Support\ServiceContentTransformer;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$dryRun = in_array('--dry-run', $argv, true);
$importMissing = ! in_array('--skip-import', $argv, true);

if ($importMissing) {
    importMissingFromSql();
}

$services = Service::query()->orderBy('id')->get();

echo "Transforming {$services->count()} service(s)...\n";

$updated = 0;
foreach ($services as $service) {
    $original = $service->content ?? '';
    $transformed = ServiceContentTransformer::transform($original);

    if ($original === $transformed) {
        echo "  [skip] #{$service->id} {$service->title}\n";
        continue;
    }

    echo "  [update] #{$service->id} {$service->title} (".strlen($original).' -> '.strlen($transformed)." bytes)\n";

    if (! $dryRun) {
        $service->content = $transformed;
        $service->save();
    }

    $updated++;
}

echo $dryRun ? "Dry run complete ({$updated} would update).\n" : "Done. Updated {$updated} service(s).\n";

function importMissingFromSql(): void
{
    $sqlPath = base_path('example/theeraphong.sql');
    if (! is_file($sqlPath)) {
        echo "SQL dump not found, skipping import.\n";

        return;
    }

    $text = file_get_contents($sqlPath);
    $services = extract_services_from_sql($text);

    $slugMap = [
        'pipe' => 1,
    ];

    foreach (Service::query()->get() as $service) {
        if (strlen(trim($service->content ?? '')) > 500) {
            continue;
        }

        $legacyId = $slugMap[$service->slug] ?? null;
        if (! $legacyId || ! isset($services[$legacyId])) {
            continue;
        }

        $src = $services[$legacyId];
        if ($src['content'] === '') {
            continue;
        }

        echo "  [import] #{$service->id} {$service->title} from SQL id={$legacyId}\n";
        $service->content = $src['content'];
        $service->save();
    }
}

/** @return array<int, array{title: string, h1: string, content: string}> */
function extract_services_from_sql(string $text): array
{
    $cols = [
        'id', 'service_category_id', 'title', 'description', 'h1', 'top_1', 'top_2',
        'content_1', 'content_2', 'img_1', 'img_2', 'created_at', 'updated_at',
        'top_alt', 'bottom_alt', 'rating_value', 'review_count', 'schema_type', 'is_active',
    ];

    $services = [];
    $needle = 'INSERT INTO `services`';
    $pos = 0;

    while (($start = strpos($text, $needle, $pos)) !== false) {
        $valuesIdx = strpos($text, 'VALUES', $start);
        $semi = strpos($text, ";\n", $valuesIdx);
        if ($semi === false) {
            $semi = strpos($text, ';', $valuesIdx);
        }

        $block = substr($text, $valuesIdx + 6, $semi - $valuesIdx - 6);
        $rows = parse_sql_values_php($block);

        foreach ($rows as $row) {
            if (count($row) < count($cols)) {
                continue;
            }

            $data = array_combine($cols, $row);
            $sid = (int) $data['id'];
            $c1 = $data['content_1'] ?? '';
            $c2 = $data['content_2'] ?? '';
            $services[$sid] = [
                'title' => $data['title'],
                'h1' => trim($data['h1'] ?? ''),
                'content' => $c1.$c2,
            ];
        }

        $pos = $semi + 1;
    }

    return $services;
}

/** @return list<list<string|null>> */
function parse_sql_values_php(string $valuesStr): array
{
    $rows = [];
    $i = 0;
    $n = strlen($valuesStr);

    while ($i < $n) {
        while ($i < $n && str_contains(" \t\r\n,", $valuesStr[$i])) {
            $i++;
        }
        if ($i >= $n) {
            break;
        }
        if ($valuesStr[$i] !== '(') {
            $i++;
            continue;
        }

        $i++;
        $fields = [];
        while ($i < $n) {
            while ($i < $n && str_contains(" \t\r\n", $valuesStr[$i])) {
                $i++;
            }
            if ($i >= $n) {
                break;
            }
            if ($valuesStr[$i] === ')') {
                $i++;
                $rows[] = $fields;
                break;
            }
            if ($valuesStr[$i] === ',') {
                $i++;
                continue;
            }
            if (strtoupper(substr($valuesStr, $i, 4)) === 'NULL') {
                $fields[] = null;
                $i += 4;
                continue;
            }
            if ($valuesStr[$i] === "'") {
                $i++;
                $buf = '';
                while ($i < $n) {
                    $c = $valuesStr[$i];
                    if ($c === "'") {
                        if ($i + 1 < $n && $valuesStr[$i + 1] === "'") {
                            $buf .= "'";
                            $i += 2;
                            continue;
                        }
                        $i++;
                        break;
                    }
                    if ($c === '\\' && $i + 1 < $n) {
                        $nxt = $valuesStr[$i + 1];
                        $buf .= match ($nxt) {
                            'n' => "\n",
                            'r' => "\r",
                            't' => "\t",
                            '\\' => '\\',
                            "'" => "'",
                            default => $nxt,
                        };
                        $i += 2;
                        continue;
                    }
                    $buf .= $c;
                    $i++;
                }
                $fields[] = $buf;
                continue;
            }

            $start = $i;
            while ($i < $n && ! str_contains(',)', $valuesStr[$i])) {
                $i++;
            }
            $fields[] = trim(substr($valuesStr, $start, $i - $start));
        }
    }

    return $rows;
}
