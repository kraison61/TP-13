<?php

namespace Database\Seeders;

use App\Models\Finance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FinanceSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->existingPartners() as $partner) {
            Finance::query()->updateOrCreate(
                ['name' => $partner['name']],
                $partner
            );
        }

        foreach ($this->additionalPartners() as $partner) {
            if ($this->isDuplicate($partner['name'])) {
                continue;
            }

            Finance::query()->create($partner);
        }
    }

    private function isDuplicate(string $name): bool
    {
        $normalized = Str::lower(trim($name));

        return Finance::query()
            ->get(['name'])
            ->contains(fn (Finance $finance) => Str::lower($finance->name) === $normalized);
    }

    private function existingPartners(): array
    {
        return [
            [
                'name' => 'เงินเทอร์โบ',
                'type' => 'สินเชื่อส่วนบุคคล',
                'color' => '#C94A04',
                'rgba_color' => 'rgba(201,74,4,0.28)',
                'link' => 'https://atth.me/adv.php?rk=00edr70017n8',
                'img' => 'https://imp.accesstrade.in.th/img.php?rk=00edr70017n8',
                'icon' => 'bi-lightning-charge-fill',
                'max_amount' => '฿500,000',
                'rate' => 'เริ่มต้น 15% ต่อปี ดอกเบี้ยขั้นต่ำ (ลดต้นลดดอก)',
                'features' => ['กู้ง่ายไม่จุกจิก', 'รับรถอายุเยอะ', 'ไม่ต้องโอนเล่ม', 'อนุมัติ และรับเงินทันทีที่สาขา'],
                'sort_order' => 1,
            ],
            [
                'name' => 'car4cash',
                'type' => 'สินเชื่อทะเบียนรถ',
                'color' => '#1560C0',
                'rgba_color' => 'rgba(21,96,192,0.28)',
                'link' => 'https://atth.me/adv.php?rk=00hh920017n8',
                'img' => 'https://imp.accesstrade.in.th/img.php?rk=00hh920017n8',
                'icon' => 'bi-car-front-fill',
                'max_amount' => '140% ของราคากลางรถ',
                'rate' => 'เริ่มต้น 2.88% ต่อปี',
                'features' => ['ดอกเบี้ยถูก(โอนเล่ม)', 'ประเมินวงเงินสูง (100% ของราคากลางรถ)', 'บริการถึงที่', 'รู้ผลใน 3 ชม. / ได้เงินไวสุดใน 1 วัน'],
                'sort_order' => 2,
            ],
            [
                'name' => 'ttbDrive',
                'type' => 'สินเชื่อรถยนต์ TTB',
                'color' => '#0055A5',
                'rgba_color' => 'rgba(0,85,165,0.28)',
                'link' => 'https://atth.me/adv.php?rk=0023j30017n8',
                'img' => 'https://imp.accesstrade.in.th/img.php?rk=0023j30017n8',
                'icon' => 'bi-bank2',
                'max_amount' => '100% ของราคากลางรถ',
                'rate' => 'เริ่มต้น 3.18 ต่อปี',
                'features' => ['รถยังผ่อนอยู่กู้ได้', 'ให้วงเงินสูง 100-120 %', 'ลดดอกเบี้ยพิเศษ(รับเงินเดือนผ่านบัญชี ttb)', 'รู้ผลเบื้องต้น 30 นาที / ได้เงินใน 1 วัน'],
                'sort_order' => 3,
            ],
        ];
    }

    private function additionalPartners(): array
    {
        $samples = [
            ['name' => 'KTC Proud', 'type' => 'บัตรเครดิต', 'color' => '#008847', 'icon' => 'bi-credit-card-fill', 'max_amount' => 'ตามวงเงินอนุมัติ', 'rate' => 'ผ่อน 0% สูงสุด 10 เดือน (ตามแคมเปญ)'],
            ['name' => 'สินเชื่อทะเบียนรถยนต์ - KTC พี่เบิ้ม', 'type' => 'สินเชื่อทะเบียนรถ', 'color' => '#008847', 'icon' => 'bi-car-front-fill', 'max_amount' => '120% ของราคากลางรถ', 'rate' => 'เริ่มต้น 2.99% ต่อปี'],
            ['name' => 'ttb absolute', 'type' => 'สินเชื่อส่วนบุคคล', 'color' => '#0055A5', 'icon' => 'bi-bank2', 'max_amount' => '฿2,000,000', 'rate' => 'เริ่มต้น 7.99% ต่อปี'],
            ['name' => 'ttb so fast', 'type' => 'สินเชื่อส่วนบุคคล', 'color' => '#0055A5', 'icon' => 'bi-lightning-charge-fill', 'max_amount' => '฿500,000', 'rate' => 'อนุมัติไว รู้ผลภายใน 30 นาที'],
            ['name' => 'ttb so smart', 'type' => 'สินเชื่อส่วนบุคคล', 'color' => '#0055A5', 'icon' => 'bi-phone-fill', 'max_amount' => '฿1,000,000', 'rate' => 'สมัครผ่านแอป ttb touch ได้เลย'],
            ['name' => 'ttb so chill', 'type' => 'สินเชื่อส่วนบุคคล', 'color' => '#0055A5', 'icon' => 'bi-calendar-check-fill', 'max_amount' => '฿800,000', 'rate' => 'ผ่อนสบาย เริ่มต้น 9.99% ต่อปี'],
            ['name' => 'ttb Cash 2 Go', 'type' => 'สินเชื่อเงินสด', 'color' => '#0055A5', 'icon' => 'bi-cash-stack', 'max_amount' => '฿300,000', 'rate' => 'รับเงินสดทันทีหลังอนุมัติ'],
            ['name' => 'ttb Flash', 'type' => 'สินเชื่อด่วน', 'color' => '#0055A5', 'icon' => 'bi-stopwatch-fill', 'max_amount' => '฿200,000', 'rate' => 'อนุมัติเร็ว ได้เงินภายใน 1 วัน'],
            ['name' => 'Krungsri Platinum Credit Card', 'type' => 'บัตรเครดิต', 'color' => '#FFD100', 'icon' => 'bi-credit-card-2-front-fill', 'max_amount' => 'ตามวงเงินอนุมัติ', 'rate' => 'สะสมแต้มแลกของรางวัล'],
            ['name' => 'Krungsri NOW Platinum Credit Card', 'type' => 'บัตรเครดิต', 'color' => '#FFD100', 'icon' => 'bi-credit-card-2-front-fill', 'max_amount' => 'ตามวงเงินอนุมัติ', 'rate' => 'สิทธิพิเศษ dining & lifestyle'],
            ['name' => 'Krungsri JCB Platinum Credit Card', 'type' => 'บัตรเครดิต', 'color' => '#004B87', 'icon' => 'bi-credit-card-fill', 'max_amount' => 'ตามวงเงินอนุมัติ', 'rate' => 'สิทธิพิเศษ JCB ทั่วโลก'],
            ['name' => 'UOB TMRW', 'type' => 'บัตรเครดิต', 'color' => '#003087', 'icon' => 'bi-credit-card-fill', 'max_amount' => 'ตามวงเงินอนุมัติ', 'rate' => 'สะสม UPOINT แลกรางวัล'],
            ['name' => 'สินเชื่อบ้านรีไฟแนนซ์ Refinance (LH BANK)', 'type' => 'สินเชื่อบ้าน', 'color' => '#004B8D', 'icon' => 'bi-house-fill', 'max_amount' => 'ตามมูลค่าประเมินบ้าน', 'rate' => 'เริ่มต้น 3.50% ต่อปี (MRR)'],
            ['name' => 'สินเชื่อส่วนบุคคลรวมหนี้ Happy Cash Balance Transfer (LH BANK)', 'type' => 'สินเชื่อรวมหนี้', 'color' => '#004B8D', 'icon' => 'bi-arrow-left-right', 'max_amount' => '฿1,500,000', 'rate' => 'รวมหนี้บัตรเครดิต/สินเชื่อเดิม'],
            ['name' => 'Krungsri First Choice', 'type' => 'สินเชื่อส่วนบุคคล', 'color' => '#FFD100', 'icon' => 'bi-star-fill', 'max_amount' => '฿1,000,000', 'rate' => 'เริ่มต้น 12% ต่อปี'],
            ['name' => 'LINEBK Affiliate', 'type' => 'สินเชื่อดิจิทัล', 'color' => '#06C755', 'icon' => 'bi-line', 'max_amount' => '฿500,000', 'rate' => 'สมัครผ่าน LINE BK ได้เลย'],
            ['name' => 'ศรีสวัสดิ์ เงินสดทันใจ', 'type' => 'สินเชื่อเงินสด', 'color' => '#F97316', 'icon' => 'bi-cash-coin', 'max_amount' => '฿500,000', 'rate' => 'อนุมัติไว ได้เงินทันที'],
            ['name' => 'สินเชื่อส่วนบุคคล Happy Cash (LH BANK)', 'type' => 'สินเชื่อส่วนบุคคล', 'color' => '#004B8D', 'icon' => 'bi-person-check-fill', 'max_amount' => '฿1,000,000', 'rate' => 'เริ่มต้น 8.99% ต่อปี'],
            ['name' => 'สินเชื่อบ้านเพิ่มเงิน Happy Home for Cash (LH BANK)', 'type' => 'สินเชื่อบ้าน', 'color' => '#004B8D', 'icon' => 'bi-house-door-fill', 'max_amount' => 'ตามมูลค่าประเมินบ้าน', 'rate' => 'เพิ่มเงินจากหลักประกันบ้านที่มีอยู่'],
            ['name' => 'Thanachart Cash Your Car', 'type' => 'สินเชื่อทะเบียนรถ', 'color' => '#0066CC', 'icon' => 'bi-car-front-fill', 'max_amount' => '100% ของราคากลางรถ', 'rate' => 'เริ่มต้น 3.25% ต่อปี'],
        ];

        return collect($samples)
            ->values()
            ->map(function (array $sample, int $index) {
                $hex = ltrim($sample['color'], '#');
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                $label = rawurlencode($sample['name']);

                return [
                    'name' => $sample['name'],
                    'type' => $sample['type'],
                    'color' => $sample['color'],
                    'rgba_color' => "rgba({$r},{$g},{$b},0.28)",
                    'link' => '#',
                    'img' => "https://placehold.co/600x120/{$hex}/ffffff?text={$label}",
                    'icon' => $sample['icon'],
                    'max_amount' => $sample['max_amount'],
                    'rate' => $sample['rate'],
                    'features' => [
                        'สมัครออนไลน์ได้',
                        'เงื่อนไขเป็นไปตามที่สถาบันการเงินกำหนด',
                        'อนุมัติตามคุณสมบัติผู้กู้',
                        'ข้อมูลตัวอย่าง — อัปเดตลิงก์ Affiliate ภายหลัง',
                    ],
                    'sort_order' => $index + 4,
                    'is_active' => true,
                ];
            })
            ->all();
    }
}
