@props(['service'])

@php
    $priceRows = $service->activePrices;
    $priceTypeLabels = [
        'fixed' => 'ราคาคงที่',
        'starting_at' => 'ราคาเริ่มต้น',
        'range' => 'ช่วงราคา',
        'call_to_ask' => 'สอบถาม',
        'variable' => 'ตามหน้างาน',
    ];
@endphp

<section id="price-table" class="bg-surface">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:py-24">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
                <span class="w-7 h-px bg-accent"></span> ตารางราคา
            </span>
            <h2 class="mt-4 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900 leading-tight">
                ราคา{{ $service->title }}
            </h2>
            <p class="mt-4 text-lg text-ink2 leading-relaxed">
                รายการราคาตามประเภทงาน — ราคาจริงประเมินตามหน้างานฟรี ไม่มีค่าใช้จ่าย
            </p>
        </div>

        <div class="mt-10 overflow-x-auto rounded-2xl border border-line bg-white">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="bg-navy-900 text-white text-[14px]">
                        <th class="px-6 py-4 font-semibold">รายการ</th>
                        <th class="px-6 py-4 font-semibold whitespace-nowrap">ราคา</th>
                        <th class="px-6 py-4 font-semibold whitespace-nowrap">หน่วย</th>
                        <th class="px-6 py-4 font-semibold whitespace-nowrap">ประเภทราคา</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line text-[15px]">
                    @forelse ($priceRows as $price)
                        <tr @class([
                            'transition hover:bg-surface',
                            'bg-hivis/10' => $loop->first,
                        ])>
                            <td class="px-6 py-4 font-semibold text-navy-900">
                                {{ $price->name }}
                                @if ($loop->first)
                                    <span class="ml-1 align-middle rounded-full bg-hivis/30 text-accent text-[11px] font-semibold px-2 py-0.5">ราคาต่ำสุด</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-mono font-semibold text-navy-900 tabular-nums whitespace-nowrap">
                                @if ($price->price !== null)
                                    {{ number_format((float) $price->price, 0) }}
                                    @if ($price->max_price)
                                        – {{ number_format((float) $price->max_price, 0) }}
                                    @endif
                                @else
                                    สอบถาม
                                @endif
                            </td>
                            <td class="px-6 py-4 text-ink2 whitespace-nowrap">
                                {{ $price->unit ? 'บาท/'.$price->unit : '—' }}
                            </td>
                            <td class="px-6 py-4 text-ink2 whitespace-nowrap">
                                {{ $priceTypeLabels[$price->price_type] ?? $price->price_type }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-muted">ยังไม่มีข้อมูลราคาสำหรับบริการนี้</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <p class="mt-4 text-[13px] text-muted">* ราคายังไม่รวมงานพิเศษเฉพาะหน้างาน เช่น ระบบฐานรากพิเศษ การรื้อถอน หรือวัสดุเกรดสูงตามที่ลูกค้าเลือก</p>
    </div>
</section>
