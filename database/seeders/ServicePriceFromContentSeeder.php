<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServicePrice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Sync price rows found in service page content tables into service_prices.
 * Dedupes by service + normalized name, or same price+unit with near-identical name.
 */
class ServicePriceFromContentSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $services = Service::query()->where('is_active', true)->get()->keyBy('slug');

        foreach ($this->catalog() as $slug => $rows) {
            $service = $services->get($slug);
            if (! $service) {
                $this->command?->warn("Skip missing service: {$slug}");

                continue;
            }

            foreach ($rows as $row) {
                $this->upsert($service->id, $row, $now);
            }
        }

        $this->normalizeUnits();
        $this->deactivateObviousDuplicates();

        $this->command?->info('Service prices synced from content.');
    }

    /**
     * Curated prices extracted from HTML price tables / explicit price lists in content.
     *
     * @return array<string, list<array<string, mixed>>>
     */
    private function catalog(): array
    {
        return [
            'demolish' => [
                [
                    'name' => 'บ้านไม้ 1 ชั้น (พื้นที่ 100 ตร.ม.)',
                    'price' => 40000,
                    'max_price' => 60000,
                    'unit' => 'หลัง',
                    'price_type' => 'range',
                    'sku' => 'DMW-1F-100',
                    'sort_order' => 10,
                ],
                [
                    'name' => 'บ้านไม้ 2 ชั้น (พื้นที่ 150 ตร.ม.)',
                    'price' => 70000,
                    'max_price' => 120000,
                    'unit' => 'หลัง',
                    'price_type' => 'range',
                    'sku' => 'DMW-2F-150',
                    'sort_order' => 20,
                ],
                [
                    'name' => 'รื้อถอนบ้านไม้พร้อมขายไม้เก่า',
                    'price' => null,
                    'max_price' => null,
                    'unit' => null,
                    'price_type' => 'call_to_ask',
                    'sku' => 'DMW-SALVAGE',
                    'sort_order' => 30,
                ],
            ],
            'truck' => [
                [
                    'name' => 'รถ 6 ล้อ รายวัน',
                    'price' => 2500,
                    'max_price' => null,
                    'unit' => 'วัน',
                    'price_type' => 'starting_at',
                    'sku' => 'TR6-DAY',
                    'sort_order' => 10,
                    'aliases' => ['ราคาเริ่มต้น'],
                ],
                [
                    'name' => 'รถ 6 ล้อ รายเดือน',
                    'price' => 55000,
                    'max_price' => null,
                    'unit' => 'เดือน',
                    'price_type' => 'starting_at',
                    'sku' => 'TR6-MONTH',
                    'sort_order' => 20,
                ],
                [
                    'name' => 'รถ 6 ล้อ อย่างเดียว (ขนเศษวัสดุ)',
                    'price' => 500,
                    'max_price' => null,
                    'unit' => 'เที่ยว',
                    'price_type' => 'starting_at',
                    'sku' => 'TR6-TRIP',
                    'sort_order' => 30,
                ],
                [
                    'name' => 'รถ 6 ล้อ พร้อมแบคโฮ (ขนเศษวัสดุ)',
                    'price' => 800,
                    'max_price' => null,
                    'unit' => 'เที่ยว',
                    'price_type' => 'starting_at',
                    'sku' => 'TR6-TRIP-EX',
                    'sort_order' => 40,
                ],
            ],
            'cctv-installation' => [
                [
                    'name' => 'Starter – 2 ตัว',
                    'price' => 10000,
                    'max_price' => 15000,
                    'unit' => 'ชุด',
                    'price_type' => 'range',
                    'sku' => 'cctv-2',
                    'sort_order' => 10,
                    'aliases' => ['ติดตั้งกล้องวงจรปิด-2 ตัว'],
                    'description' => 'กล้อง HD 2MP + DVR + HDD 1TB + เดินสาย + ตั้งค่าแอป',
                ],
                [
                    'name' => 'Home – 4 ตัว',
                    'price' => 15000,
                    'max_price' => 25000,
                    'unit' => 'ชุด',
                    'price_type' => 'range',
                    'sku' => 'cctv-4',
                    'sort_order' => 20,
                    'description' => 'กล้อง Full HD 2–4MP + DVR + HDD 2TB + เดินสาย + ตั้งค่าแอป',
                ],
                [
                    'name' => 'Shop – 8 ตัว',
                    'price' => 30000,
                    'max_price' => 50000,
                    'unit' => 'ชุด',
                    'price_type' => 'range',
                    'sku' => 'cctv-8',
                    'sort_order' => 30,
                    'description' => 'กล้อง Full HD + NVR/DVR + HDD 4TB + เดินสายซ่อนในฝ้า',
                ],
                [
                    'name' => 'Factory – 16 ตัวขึ้นไป',
                    'price' => 80000,
                    'max_price' => null,
                    'unit' => 'ชุด',
                    'price_type' => 'starting_at',
                    'sku' => 'cctv-16',
                    'sort_order' => 40,
                    'description' => 'กล้องกันน้ำ/กันฝุ่น IP67 + NVR + HDD 8TB + ระบบ LAN',
                ],
            ],
            'steel' => [
                [
                    'name' => 'ต่อเติมหลังคาบ้าน / กันสาด (พาด 3–4 ม.) เหมารวมวัสดุ',
                    'price' => 1000,
                    'max_price' => 1600,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'roof-steel-3-4',
                    'sort_order' => 10,
                    'aliases' => ['ต่อเติมหลังคาบ้าน / กันสาด (พาด 3–4 ม.)'],
                ],
                [
                    'name' => 'โรงจอดรถบ้าน (พาด 5–6 ม.) เหมารวมวัสดุ',
                    'price' => 1200,
                    'max_price' => 2000,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'roof-steel-5-6',
                    'sort_order' => 20,
                    'aliases' => ['โรงจอดรถบ้าน (พาด 5–6 ม.)'],
                ],
                [
                    'name' => 'หลังคาคลุมลานอเนกประสงค์ (พาด 8–12 ม.) เหมารวมวัสดุ',
                    'price' => 1800,
                    'max_price' => 3000,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'roof-steel-8-12',
                    'sort_order' => 30,
                    'aliases' => ['หลังคาคลุมลานอเนกประสงค์ (พาด 8–12 ม.)'],
                ],
                [
                    'name' => 'โกดัง/โรงงาน สูง 4–6 ม. เหมารวมวัสดุ',
                    'price' => 2500,
                    'max_price' => 4000,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'fact-steel-4-6',
                    'sort_order' => 40,
                    'aliases' => ['โกดัง/โรงงาน สูง 4–6 ม.'],
                ],
                [
                    'name' => 'โกดัง/โรงงาน สูง 8-10 ม. เหมารวมวัสดุ',
                    'price' => 4000,
                    'max_price' => 5500,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'fact-steel-8-10',
                    'sort_order' => 50,
                    'aliases' => ['โกดัง/โรงงาน สูง 8-10 ม.'],
                ],
                [
                    'name' => 'ต่อเติมหลังคาบ้าน / กันสาด (พาด 3–4 ม.) ค่าแรงอย่างเดียว',
                    'price' => 250,
                    'max_price' => 450,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'roof-labor-3-4',
                    'sort_order' => 60,
                ],
                [
                    'name' => 'โรงจอดรถบ้าน (พาด 5–6 ม.) ค่าแรงอย่างเดียว',
                    'price' => 300,
                    'max_price' => 550,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'roof-labor-5-6',
                    'sort_order' => 70,
                ],
                [
                    'name' => 'หลังคาคลุมลานอเนกประสงค์ (พาด 8–12 ม.) ค่าแรงอย่างเดียว',
                    'price' => 400,
                    'max_price' => 650,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'roof-labor-8-12',
                    'sort_order' => 80,
                ],
                [
                    'name' => 'โกดัง/โรงงาน สูง 4–6 ม. ค่าแรงอย่างเดียว',
                    'price' => 400,
                    'max_price' => 600,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'fact-labor-4-6',
                    'sort_order' => 90,
                ],
                [
                    'name' => 'โกดัง/โรงงาน สูง 8-10 ม. ค่าแรงอย่างเดียว',
                    'price' => 500,
                    'max_price' => 700,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'fact-labor-8-10',
                    'sort_order' => 100,
                ],
                [
                    'name' => 'โครงถัก 12 ม. รวมต่อตัว',
                    'price' => 15000,
                    'max_price' => 28000,
                    'unit' => 'ตัว',
                    'price_type' => 'range',
                    'sku' => 'truss-12m',
                    'sort_order' => 110,
                ],
            ],
            'footing' => [
                [
                    'name' => 'เทฟุตติ้งต่อหลุม',
                    'price' => 2500,
                    'max_price' => 4500,
                    'unit' => 'หลุม',
                    'price_type' => 'range',
                    'sku' => 'FT-HOLE',
                    'sort_order' => 10,
                    'aliases' => ['ราคาเริ่มต้น'],
                ],
                [
                    'name' => 'ขุดหลุมเทฟุตติ้ง',
                    'price' => 4000,
                    'max_price' => 7000,
                    'unit' => 'จุด',
                    'price_type' => 'range',
                    'sku' => 'FT-DIG',
                    'sort_order' => 20,
                ],
                [
                    'name' => 'เทฟุตติ้งแบบชุด',
                    'price' => 6000,
                    'max_price' => null,
                    'unit' => 'ชุด',
                    'price_type' => 'starting_at',
                    'sku' => 'FT-SET',
                    'sort_order' => 30,
                ],
            ],
            'garden-plot' => [
                [
                    'name' => 'ขุดร่องสวนประมาณ 2 ไร่',
                    'price' => 20000,
                    'max_price' => 35000,
                    'unit' => 'งาน',
                    'price_type' => 'range',
                    'sku' => 'GP-2RAI',
                    'sort_order' => 10,
                ],
            ],
            'pour-concrete' => [
                [
                    'name' => 'ปูนเทพื้น (คิวละ)',
                    'price' => 1800,
                    'max_price' => 2300,
                    'unit' => 'คิว',
                    'price_type' => 'range',
                    'sku' => 'PC-CUY',
                    'sort_order' => 10,
                ],
                [
                    'name' => 'เทพื้นคอนกรีตหนา 10 ซม. (รวมค่าแรงและวัสดุ)',
                    'price' => 300,
                    'max_price' => 450,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'PC-10CM',
                    'sort_order' => 20,
                ],
                [
                    'name' => 'ปูนปรับระดับพื้น',
                    'price' => 250,
                    'max_price' => null,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'starting_at',
                    'sku' => 'PC-LEVEL',
                    'sort_order' => 30,
                ],
                [
                    'name' => 'ค่าแรงเทพื้นคอนกรีต',
                    'price' => 150,
                    'max_price' => 250,
                    'unit' => 'ตร.ม.',
                    'price_type' => 'range',
                    'sku' => 'PC-LABOR',
                    'sort_order' => 40,
                ],
            ],
            'fence' => [
                [
                    'name' => 'รั้วเหล็กดัดลายซับซ้อน',
                    'price' => 800,
                    'max_price' => 2500,
                    'unit' => 'เมตร',
                    'price_type' => 'range',
                    'sku' => 'F-STEEL-ORNA',
                    'sort_order' => 5,
                ],
            ],
            'dam' => [
                [
                    'name' => 'เขื่อนกันดิน สูง 1.5 เมตร',
                    'price' => 3500,
                    'max_price' => 5500,
                    'unit' => 'เมตร',
                    'price_type' => 'range',
                    'sku' => 'DM-H-1-5',
                    'sort_order' => 5,
                ],
                [
                    'name' => 'เขื่อนกันดิน สูง 2 เมตร',
                    'price' => 4500,
                    'max_price' => 7000,
                    'unit' => 'เมตร',
                    'price_type' => 'range',
                    'sku' => 'DM-H-2-0',
                    'sort_order' => 6,
                ],
                [
                    'name' => 'เขื่อนกันดิน สูง 3 เมตร',
                    'price' => 6500,
                    'max_price' => null,
                    'unit' => 'เมตร',
                    'price_type' => 'starting_at',
                    'sku' => 'DM-H-3-0',
                    'sort_order' => 7,
                ],
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $row
     */
    private function upsert(int $serviceId, array $row, Carbon $now): void
    {
        $name = trim((string) $row['name']);
        $unit = $this->normalizeUnit($row['unit'] ?? null);
        $sku = $row['sku'] ?? null;
        $aliases = $row['aliases'] ?? [];
        unset($row['aliases']);

        $existing = ServicePrice::query()
            ->where('service_id', $serviceId)
            ->get()
            ->first(function (ServicePrice $price) use ($name, $unit, $sku, $aliases, $row) {
                if ($sku && $price->sku && $this->norm($price->sku) === $this->norm($sku)) {
                    return true;
                }

                $priceName = $this->norm($price->name);
                if ($priceName === $this->norm($name)) {
                    return true;
                }

                foreach ($aliases as $alias) {
                    if ($priceName === $this->norm($alias)
                        && $this->normalizeUnit($price->unit) === $unit
                        && $this->sameMoney($price->price, $row['price'] ?? null)) {
                        return true;
                    }
                }

                return false;
            });

        $payload = [
            'name' => $name,
            'description' => $row['description'] ?? ($existing?->description),
            'price_type' => $row['price_type'],
            'price' => $row['price'],
            'max_price' => $row['price_type'] === 'range' ? ($row['max_price'] ?? null) : null,
            'unit' => $unit,
            'sku' => $sku ?: ($existing?->sku),
            'sort_order' => $row['sort_order'] ?? ($existing?->sort_order ?? 0),
            'is_active' => true,
            'updated_at' => $now,
        ];

        if ($row['price_type'] === 'call_to_ask') {
            $payload['price'] = null;
            $payload['max_price'] = null;
        }

        if ($existing) {
            $existing->update($payload);
            $this->command?->line("  updated: [{$serviceId}] {$name}");

            return;
        }

        // Skip insert if an active row already has identical price+unit+type (avoid near-dupes)
        if ($payload['price'] !== null) {
            $dupe = ServicePrice::query()
                ->where('service_id', $serviceId)
                ->where('is_active', true)
                ->where('unit', $unit)
                ->where('price', $payload['price'])
                ->where(function ($q) use ($payload) {
                    if ($payload['max_price'] === null) {
                        $q->whereNull('max_price');
                    } else {
                        $q->where('max_price', $payload['max_price']);
                    }
                })
                ->first();

            if ($dupe) {
                $this->command?->line("  skip duplicate money: [{$serviceId}] {$name} ≈ {$dupe->name}");

                return;
            }
        }

        ServicePrice::query()->create(array_merge($payload, [
            'service_id' => $serviceId,
            'price_currency' => 'THB',
            'availability' => 'https://schema.org/InStock',
            'created_at' => $now,
        ]));

        $this->command?->line("  created: [{$serviceId}] {$name}");
    }

    private function normalizeUnits(): void
    {
        ServicePrice::query()
            ->where('unit', 'ม.')
            ->update(['unit' => 'เมตร']);
    }

    private function deactivateObviousDuplicates(): void
    {
        // Generic "ราคาเริ่มต้น" that duplicates a more specific row at same price+unit
        $generics = ServicePrice::query()
            ->where('is_active', true)
            ->where('name', 'ราคาเริ่มต้น')
            ->get();

        foreach ($generics as $generic) {
            $sibling = ServicePrice::query()
                ->where('service_id', $generic->service_id)
                ->where('id', '!=', $generic->id)
                ->where('is_active', true)
                ->where('name', '!=', 'ราคาเริ่มต้น')
                ->where('unit', $this->normalizeUnit($generic->unit))
                ->where('price', $generic->price)
                ->first();

            if ($sibling) {
                $generic->update(['is_active' => false]);
                $this->command?->line("  deactivated duplicate starter #{$generic->id} (kept #{$sibling->id} {$sibling->name})");
            }
        }

        // Misleading high "ราคาเริ่มต้น" when a lower active price exists for the SAME unit
        $highStarters = ServicePrice::query()
            ->where('is_active', true)
            ->where('name', 'ราคาเริ่มต้น')
            ->get();

        foreach ($highStarters as $starter) {
            if ($starter->price === null) {
                continue;
            }

            $unit = $this->normalizeUnit($starter->unit);
            $lower = ServicePrice::query()
                ->where('service_id', $starter->service_id)
                ->where('id', '!=', $starter->id)
                ->where('is_active', true)
                ->whereNotNull('price')
                ->where('unit', $unit)
                ->where('price', '<', $starter->price)
                ->exists();

            if ($lower) {
                $starter->update(['is_active' => false]);
                $this->command?->line("  deactivated high starter #{$starter->id} (lower prices exist for unit {$unit})");
            }
        }
    }

    private function normalizeUnit(?string $unit): ?string
    {
        if ($unit === null || $unit === '') {
            return null;
        }

        $unit = trim($unit);
        $unit = preg_replace('/^บาท\s*\/\s*/u', '', $unit) ?: $unit;

        return match ($unit) {
            'ม.', 'ม' => 'เมตร',
            default => $unit,
        };
    }

    private function norm(string $value): string
    {
        $value = mb_strtolower(trim($value));
        $value = preg_replace('/\s+/u', '', $value) ?? $value;

        return $value;
    }

    private function sameMoney(mixed $a, mixed $b): bool
    {
        if ($a === null && $b === null) {
            return true;
        }

        if ($a === null || $b === null) {
            return false;
        }

        return abs((float) $a - (float) $b) < 0.01;
    }
}
