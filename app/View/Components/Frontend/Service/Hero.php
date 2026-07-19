<?php

namespace App\View\Components\Frontend\Service;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hero extends Component
{
    public array $badges;

    public function __construct(
        public ?string $current = null,
        public string $eyebrow = 'บริการของเรา',
        public string $title = 'งานก่อสร้างนอกตัวบ้าน<br/>ครบจบในที่เดียว',
        public ?string $description = null,
        ?array $badges = null,
    ) {
        $this->description = $description ?? 'ทีมช่างเฉพาะทาง ' . config('company.team_size') . ' คน รับงานตั้งแต่โปรเจกต์เล็ก 5 ตร.ม. ถึงโครงการขนาดใหญ่ — ในเขตกรุงเทพฯ และปริมณฑล พร้อมรับประกันงาน 2 ปี';
        $this->badges = $badges ?? [
            ['icon' => 'bi-clock', 'text' => 'สำรวจหน้างานฟรี ภายใน 3 วัน'],
            ['icon' => 'bi-shield-check', 'text' => 'รับประกันงาน 2 ปีเต็ม'],
            ['icon' => 'bi-file-earmark-text', 'text' => 'BOQ ละเอียดทุกรายการ'],
            ['icon' => 'bi-award', 'text' => 'ใบอนุญาตก่อสร้าง ระดับ ค'],
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.service.hero');
    }
}
