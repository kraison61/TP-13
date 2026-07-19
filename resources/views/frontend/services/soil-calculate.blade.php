@extends('layouts.frontend')

@section('content')
<x-frontend.page-hero
    :current="$hero['current'] ?? null"
    :eyebrow="$hero['eyebrow'] ?? ''"
    :title="$hero['title'] ?? ''"
    :description="$hero['description'] ?? ''"
/>

{{-- ============ CALCULATOR ============ --}}
<section class="bg-surface" id="soil-calc">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-12 lg:py-16 grid lg:grid-cols-[1fr_420px] gap-8 items-start">

        {{-- FORM CARD --}}
        <div class="rounded-2xl bg-white border border-line shadow-sm p-7 lg:p-9">
            <div class="flex items-center gap-3 mb-7">
                <span class="grid place-items-center w-11 h-11 rounded-xl bg-navy-900 text-white text-xl"><x-icon name="calculator" /></span>
                <div>
                    <div class="font-bold text-navy-900 text-lg leading-tight">กรอกข้อมูลที่ดิน</div>
                    <div class="text-[13px] text-muted">ระบบคำนวณแบบ real-time ทุกการพิมพ์</div>
                </div>
            </div>

            <div class="mb-6">
                <div class="text-[12px] font-semibold uppercase tracking-[0.12em] text-muted mb-2.5">ตัวอย่างด่วน</div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" data-soil-preset="1" class="rounded-full border border-line px-3.5 py-1.5 text-[13px] font-medium text-ink2 hover:border-accent hover:text-accent transition">1 งาน · สูง 1 ม.</button>
                    <button type="button" data-soil-preset="2" class="rounded-full border border-line px-3.5 py-1.5 text-[13px] font-medium text-ink2 hover:border-accent hover:text-accent transition">1 ไร่ · สูง 1 ม.</button>
                    <button type="button" data-soil-preset="3" class="rounded-full border border-line px-3.5 py-1.5 text-[13px] font-medium text-ink2 hover:border-accent hover:text-accent transition">2 ไร่ · สูง 1.5 ม.</button>
                    <button type="button" data-soil-reset class="rounded-full border border-line px-3.5 py-1.5 text-[13px] font-medium text-muted hover:border-red-300 hover:text-red-500 transition"><x-icon name="x-circle" class="mr-1 inline-block" />ล้าง</button>
                </div>
            </div>

            <div class="border-t border-line/70 pt-6 space-y-6">

                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-3">
                        <x-icon name="bounding-box" class="mr-1.5 text-accent inline-block" /> ขนาดที่ดิน
                        <span class="font-normal text-muted ml-2 text-[12px]">กรอกอย่างน้อย 1 ช่อง</span>
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <div class="relative">
                                <input id="soil-rai" type="number" min="0" step="any" placeholder="0" class="w-full rounded-xl border border-line px-4 py-3 pr-14 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition font-mono tabular-nums text-right text-navy-900 font-semibold" />
                                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[13px] text-muted font-medium pointer-events-none">ไร่</span>
                            </div>
                            <div class="mt-1 text-[11px] text-muted text-center">1 ไร่ = 1,600 ตร.ม.</div>
                        </div>
                        <div>
                            <div class="relative">
                                <input id="soil-ngan" type="number" min="0" step="any" placeholder="0" class="w-full rounded-xl border border-line px-4 py-3 pr-14 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition font-mono tabular-nums text-right text-navy-900 font-semibold" />
                                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[13px] text-muted font-medium pointer-events-none">งาน</span>
                            </div>
                            <div class="mt-1 text-[11px] text-muted text-center">1 งาน = 400 ตร.ม.</div>
                        </div>
                        <div>
                            <div class="relative">
                                <input id="soil-wa" type="number" min="0" step="any" placeholder="0" class="w-full rounded-xl border border-line px-4 py-3 pr-12 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition font-mono tabular-nums text-right text-navy-900 font-semibold" />
                                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[13px] text-muted font-medium pointer-events-none">วา</span>
                            </div>
                            <div class="mt-1 text-[11px] text-muted text-center">1 วา = 4 ตร.ม.</div>
                        </div>
                    </div>
                    <div class="mt-2.5 flex items-center gap-2 rounded-lg bg-surface px-3.5 py-2">
                        <x-icon name="rulers" class="text-accent shrink-0" />
                        <span class="text-[13px] text-ink2">พื้นที่รวม: <strong id="soil-area-fmt" class="font-mono tabular-nums text-navy-900">0.00</strong> ตร.ม.</span>
                    </div>
                </div>

                <div>
                    <label for="soil-height" class="block text-sm font-semibold text-navy-900 mb-2">
                        <x-icon name="arrow-up-circle" class="mr-1.5 text-accent inline-block" /> ความสูงที่ต้องการถม
                    </label>
                    <div class="relative max-w-xs">
                        <input id="soil-height" type="number" min="0" step="0.1" placeholder="0.00" class="w-full rounded-xl border border-line px-4 py-3 pr-16 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition font-mono tabular-nums text-right text-navy-900 font-semibold text-lg" />
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[14px] text-muted font-medium pointer-events-none">เมตร</span>
                    </div>
                    <p class="mt-1.5 text-[13px] text-muted">วัดจากระดับดินเดิมถึงระดับที่ต้องการ</p>
                </div>

                <div>
                    <div class="block text-sm font-semibold text-navy-900 mb-1">
                        <x-icon name="arrow-down-circle" class="mr-1.5 text-accent inline-block" /> เผื่อดินยุบตัว
                    </div>
                    <p class="text-[13px] text-muted mb-3">ดินถมจะทรุดตัวลงหลังบดอัด ควรสั่งดินเพิ่มกว่าปริมาณจริง</p>
                    <div class="grid grid-cols-3 gap-2.5" role="radiogroup" aria-label="เผื่อดินยุบตัว">
                        <label data-soil-buffer="0" class="soil-buffer-opt flex flex-col items-center gap-1.5 rounded-xl border-2 p-3 cursor-pointer transition border-line bg-white text-muted">
                            <input type="radio" name="soil-buffer" value="0" class="sr-only" />
                            <span class="font-mono font-bold text-xl">0%</span>
                            <span class="text-[11px] text-center leading-tight">ไม่เผื่อ</span>
                        </label>
                        <label data-soil-buffer="0.2" class="soil-buffer-opt flex flex-col items-center gap-1.5 rounded-xl border-2 p-3 cursor-pointer transition border-accent bg-accent/5 text-accent">
                            <input type="radio" name="soil-buffer" value="0.2" checked class="sr-only" />
                            <span class="font-mono font-bold text-xl">20%</span>
                            <span class="text-[11px] text-center leading-tight">แนะนำ</span>
                        </label>
                        <label data-soil-buffer="0.3" class="soil-buffer-opt flex flex-col items-center gap-1.5 rounded-xl border-2 p-3 cursor-pointer transition border-line bg-white text-muted">
                            <input type="radio" name="soil-buffer" value="0.3" class="sr-only" />
                            <span class="font-mono font-bold text-xl">30%</span>
                            <span class="text-[11px] text-center leading-tight">ดินทราย</span>
                        </label>
                    </div>
                </div>

            </div>
        </div>

        {{-- RESULT CARD --}}
        <div class="space-y-4 lg:sticky lg:top-24">

            <div id="soil-result-volume" class="rounded-2xl bg-navy-900 text-white p-7 relative overflow-hidden result-fade">
                <div class="pointer-events-none absolute -right-8 -top-8 w-40 h-40 rounded-full bg-hivis/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -left-4 bottom-0 w-32 h-32 rounded-full bg-white/5 blur-xl"></div>
                <div class="relative">
                    <div class="text-white/60 text-[13px] font-semibold uppercase tracking-[0.15em] mb-1">ปริมาณดินที่ต้องสั่ง</div>
                    <div class="flex items-end gap-3 mt-1">
                        <span id="soil-volume-fmt" class="font-mono font-bold tabular-nums leading-none text-[clamp(2.8rem,6vw,4rem)]">0.00</span>
                        <span class="text-white/55 text-lg mb-1">คิว</span>
                    </div>
                    <div id="soil-buffer-note" class="mt-1 text-[13px] text-white/50">(ลูกบาศก์เมตร) (รวมเผื่อดินยุบตัว 20%)</div>

                    <div class="mt-5 pt-5 border-t border-white/10 grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-white/8 p-3.5">
                            <div class="text-[11px] text-white/50 uppercase tracking-wide mb-1">พื้นที่</div>
                            <div id="soil-area-fmt-card" class="font-mono font-bold tabular-nums text-xl">0.00</div>
                            <div class="text-[12px] text-white/50">ตร.ม.</div>
                        </div>
                        <div class="rounded-xl bg-white/8 p-3.5">
                            <div class="text-[11px] text-white/50 uppercase tracking-wide mb-1">ดินจริง (ก่อนเผื่อ)</div>
                            <div id="soil-raw-vol-fmt" class="font-mono font-bold tabular-nums text-xl">0.00</div>
                            <div class="text-[12px] text-white/50">คิว</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white border border-line p-6">
                <div class="flex items-center gap-2 mb-4">
                    <x-icon name="truck" class="text-accent shrink-0" />
                    <span class="font-semibold text-navy-900">จำนวนรถดั๊มพ์โดยประมาณ</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-surface p-4 text-center">
                        <div id="soil-trucks6-fmt" class="font-mono font-bold text-3xl tabular-nums text-navy-900">0</div>
                        <div class="text-[12px] text-muted mt-1">คัน (รถ 6 ล้อ)</div>
                        <div class="text-[11px] text-muted/70">≈ 6 คิว/คัน</div>
                    </div>
                    <div class="rounded-xl bg-surface p-4 text-center">
                        <div id="soil-trucks10-fmt" class="font-mono font-bold text-3xl tabular-nums text-navy-900">0</div>
                        <div class="text-[12px] text-muted mt-1">คัน (รถ 10 ล้อ)</div>
                        <div class="text-[11px] text-muted/70">≈ 12 คิว/คัน</div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white border border-line p-6">
                <div class="flex items-center gap-2 mb-1">
                    <x-icon name="cash-coin" class="text-accent shrink-0" />
                    <span class="font-semibold text-navy-900">ราคาโดยประมาณ</span>
                </div>
                <p class="text-[12px] text-muted mb-4">รวมค่าดิน + ค่าขนส่ง + ค่าบดอัด · อ้างอิงตลาด กทม. ปริมณฑล</p>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center">
                        <span class="text-[14px] text-ink2">ค่าดินถม <span class="text-muted">(150–220 บ./คิว)</span></span>
                        <span class="font-mono font-semibold text-navy-900 tabular-nums text-[15px]"><span id="soil-soil-low">0</span>–<span id="soil-soil-high">0</span></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[14px] text-ink2">ค่าแรง + เครื่องจักร</span>
                        <span class="font-mono font-semibold text-navy-900 tabular-nums text-[15px]"><span id="soil-labor-low">0</span>–<span id="soil-labor-high">0</span></span>
                    </div>
                    <div class="border-t border-dashed border-line pt-2.5 flex justify-between items-end">
                        <span class="font-semibold text-navy-900">รวมโดยประมาณ</span>
                        <div class="text-right">
                            <div id="soil-cost-low" class="font-mono font-bold text-xl text-accent tabular-nums">0</div>
                            <div class="text-[12px] text-muted">ถึง <span id="soil-cost-high">0</span> บาท</div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 rounded-xl bg-hivis/10 border border-hivis/30 p-3.5 flex items-start gap-3">
                    <span class="grid place-items-center w-8 h-8 rounded-lg bg-hivis text-navy-900 text-sm shrink-0 mt-0.5"><x-icon name="tag-fill" /></span>
                    <div>
                        <div class="font-semibold text-navy-900 text-[14px]">{{ config('company.brand') }}: เริ่มต้น <span id="soil-tp-cost">0</span> บาท</div>
                        <div class="text-[12px] text-ink2 mt-0.5">ราคา 220 บ./คิว รวมบดอัด ตรวจสอบได้</div>
                    </div>
                </div>
                <p class="text-[11px] text-muted mt-3">* ราคาจริงขึ้นอยู่กับระยะทาง ประเภทดิน และสภาพหน้างาน</p>
            </div>

            <a href="/#contact" class="flex items-center justify-center gap-2 rounded-2xl bg-accent text-white font-semibold py-4 px-6 hover:bg-navy-900 transition text-[15px] shadow-lg shadow-navy-900/20">
                ขอใบเสนอราคาฟรี — ไม่มีค่าใช้จ่าย <x-icon name="arrow-right" />
            </a>
        </div>

    </div>
</section>

{{-- ============ สาระน่ารู้ ============ --}}
<section class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28">
    <div class="max-w-2xl mb-12">
        <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> สาระน่ารู้</span>
        <h2 class="mt-4 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900 leading-tight">รู้ก่อนถมดิน ประหยัดกว่า ปลอดภัยกว่า</h2>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="rounded-2xl border border-line bg-white p-6 hover:shadow-xl hover:shadow-navy-900/5 hover:-translate-y-1 transition">
            <span class="grid place-items-center w-12 h-12 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><x-icon name="calculator" /></span>
            <h3 class="font-bold text-navy-900 text-lg">สูตรคำนวณดินถม</h3>
            <p class="mt-2 text-[14px] text-ink2 leading-relaxed">พื้นที่ (ตร.ม.) × ความสูง (ม.) = ปริมาณดิน (คิว) จากนั้นบวกเพิ่ม 20–30% สำหรับดินที่ยุบหลังบดอัด</p>
            <div class="mt-4 rounded-lg bg-surface px-3 py-2.5 font-mono text-[12px] text-accent leading-relaxed">
                1 ไร่ × 1 ม. = <strong>1,600 คิว</strong><br />
                + เผื่อ 20% = <strong>1,920 คิว</strong>
            </div>
        </div>
        <div class="rounded-2xl border border-line bg-white p-6 hover:shadow-xl hover:shadow-navy-900/5 hover:-translate-y-1 transition">
            <span class="grid place-items-center w-12 h-12 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><x-icon name="layers" /></span>
            <h3 class="font-bold text-navy-900 text-lg">ประเภทดินที่ใช้ถม</h3>
            <p class="mt-2 text-[14px] text-ink2 leading-relaxed">ดินลูกรัง และดินเหนียวปนทรายเหมาะที่สุด บดอัดแน่น ไม่ทรุดง่าย ต่างจากดินทราย/ดินเลนที่ยุบตัวสูงถึง 30%</p>
        </div>
        <div class="rounded-2xl border border-line bg-white p-6 hover:shadow-xl hover:shadow-navy-900/5 hover:-translate-y-1 transition">
            <span class="grid place-items-center w-12 h-12 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><x-icon name="shield-check" /></span>
            <h3 class="font-bold text-navy-900 text-lg">ถมดินให้ไม่ทรุด</h3>
            <p class="mt-2 text-[14px] text-ink2 leading-relaxed">ถมเป็นชั้น ชั้นละ 20–30 ซม. บดอัดด้วยรถแบคโฮหรือแทมเปอร์ทุกชั้น หลีกเลี่ยงการถมครั้งเดียวหนาเกิน 50 ซม.</p>
        </div>
        <div class="rounded-2xl border border-line bg-white p-6 hover:shadow-xl hover:shadow-navy-900/5 hover:-translate-y-1 transition">
            <span class="grid place-items-center w-12 h-12 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><x-icon name="file-earmark-text" /></span>
            <h3 class="font-bold text-navy-900 text-lg">ขออนุญาตถมดิน</h3>
            <p class="mt-2 text-[14px] text-ink2 leading-relaxed">ในเขต กทม. ถมสูงกว่า 0.50 ม. จากระดับถนนต้องแจ้ง อบต./เขต ก่อน พร้อมแนบแบบแปลนและหนังสือยินยอมข้างเคียง</p>
        </div>
    </div>
</section>

{{-- ============ หน่วยการวัด ============ --}}
<section class="bg-navy-900 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-16 lg:py-20">
        <div class="text-center mb-10">
            <span class="inline-flex items-center gap-2 text-hivis font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-hivis"></span> ตารางอ้างอิง</span>
            <h2 class="mt-3 text-2xl lg:text-3xl font-bold tracking-tight">หน่วยที่ดิน &amp; หน่วยดินถม</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-px bg-white/10 rounded-2xl overflow-hidden">
            <div class="bg-navy-900 p-7">
                <div class="font-mono text-4xl font-bold tabular-nums">1<span class="text-xl text-hivis ml-1.5">ไร่</span></div>
                <div class="mt-2 text-white/50 text-[14px]">= 4 งาน</div>
                <div class="mt-0.5 text-white/50 text-[14px]">= 400 ตารางวา</div>
                <div class="mt-0.5 text-white/50 text-[14px]">= 1,600 ตร.ม.</div>
            </div>
            <div class="bg-navy-900 p-7">
                <div class="font-mono text-4xl font-bold tabular-nums">1<span class="text-xl text-hivis ml-1.5">งาน</span></div>
                <div class="mt-2 text-white/50 text-[14px]">= 100 ตารางวา</div>
                <div class="mt-0.5 text-white/50 text-[14px]">= 400 ตร.ม.</div>
                <div class="mt-0.5 text-white/50 text-[14px]">= ¼ ไร่</div>
            </div>
            <div class="bg-navy-900 p-7">
                <div class="font-mono text-4xl font-bold tabular-nums">1<span class="text-xl text-hivis ml-1.5">วา</span></div>
                <div class="mt-2 text-white/50 text-[14px]">= 4 ตร.ม.</div>
                <div class="mt-0.5 text-white/50 text-[14px]">= 2 × 2 เมตร</div>
                <div class="mt-0.5 text-white/50 text-[14px]">= 0.01 งาน</div>
            </div>
            <div class="bg-navy-900 p-7">
                <div class="font-mono text-4xl font-bold tabular-nums">1<span class="text-xl text-hivis ml-1.5">คิว</span></div>
                <div class="mt-2 text-white/50 text-[14px]">= 1 ม³</div>
                <div class="mt-0.5 text-white/50 text-[14px]">= ≈ 1.5–1.8 ตัน</div>
                <div class="mt-0.5 text-white/50 text-[14px]">= ⅙ รถ 6 ล้อ</div>
            </div>
        </div>
    </div>
</section>

{{-- ============ FAQ ============ --}}
<section id="faq" class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28">
    <div class="grid lg:grid-cols-12 gap-10 lg:gap-16">
        <div class="lg:col-span-4">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> FAQ</span>
            <h2 class="mt-4 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900 leading-tight">คำถามที่พบบ่อยเรื่องถมดิน</h2>
            <p class="mt-4 text-[15px] text-ink2 leading-relaxed">
                มีคำถามเพิ่มเติม? โทร
                <a href="tel:{{ config('company.phone') }}" class="font-mono tabular-nums text-accent font-semibold">{{ config('company.phone_formatted') }}</a>
                ทีมงานยินดีให้คำปรึกษาฟรี
            </p>
            <a href="/#contact" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-accent px-5 py-3 font-semibold text-white hover:bg-navy-900 transition text-[15px]">
                ขอคำปรึกษาฟรี <x-icon name="arrow-right" />
            </a>
        </div>
        <div class="lg:col-span-8 space-y-3" id="faqListCalc">
            <details class="group rounded-2xl border border-line bg-white px-5 [&_summary::-webkit-details-marker]:hidden" open>
                <summary class="flex cursor-pointer items-center justify-between gap-4 py-4 font-semibold text-navy-900">
                    ถมดินต้องขออนุญาตหรือเปล่า?
                    <x-icon name="plus-lg" class="text-accent transition group-open:rotate-45 shrink-0" />
                </summary>
                <p class="pb-5 -mt-1 text-[15px] text-ink2 leading-relaxed">ในเขตเทศบาลและ กทม. ถ้าถมสูงกว่าระดับถนนสาธารณะมากกว่า 50 ซม. ต้องยื่นขออนุญาตจากเจ้าพนักงานท้องถิ่น พร้อมแนบหนังสือยินยอมเจ้าของที่ดินข้างเคียง ถ้าถมต่ำกว่า 50 ซม. มักไม่ต้องขออนุญาต แต่ควรแจ้งเพื่อนบ้านก่อน</p>
            </details>
            <details class="group rounded-2xl border border-line bg-white px-5 [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-4 py-4 font-semibold text-navy-900">
                    ราคาดินถมต่อคิวอยู่ที่เท่าไหร่?
                    <x-icon name="plus-lg" class="text-accent transition group-open:rotate-45 shrink-0" />
                </summary>
                <p class="pb-5 -mt-1 text-[15px] text-ink2 leading-relaxed">ราคาตลาดในเขต กทม. ปริมณฑล ดินลูกรังอยู่ที่ <strong class="text-navy-900">150–220 บาท/คิว</strong> ค่าขนส่งและบดอัดรวมอยู่ที่ 50–100 บาท/คิว รวมทั้งหมดประมาณ 200–320 บาท/คิว ขึ้นอยู่กับระยะทาง ปริมาณ และสภาพหน้างาน</p>
            </details>
            <details class="group rounded-2xl border border-line bg-white px-5 [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-4 py-4 font-semibold text-navy-900">
                    ทำไมต้องเผื่อดินยุบตัว?
                    <x-icon name="plus-lg" class="text-accent transition group-open:rotate-45 shrink-0" />
                </summary>
                <p class="pb-5 -mt-1 text-ink2 text-[15px] leading-relaxed">ดินที่ขนมาใหม่มีความฟูและมีช่องอากาศสูง เมื่อบดอัดและแช่น้ำฝนจะยุบตัวลง 15–30% ขึ้นกับประเภทดิน ดินลูกรังยุบประมาณ 15–20% ดินทรายยุบ 20–30% การเผื่อไว้ตั้งแต่ต้นทำให้ระดับสุดท้ายถูกต้องและประหยัดกว่าการสั่งเพิ่มภายหลัง</p>
            </details>
            <details class="group rounded-2xl border border-line bg-white px-5 [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-4 py-4 font-semibold text-navy-900">
                    ถมดินเองดีกว่าจ้างมืออาชีพไหม?
                    <x-icon name="plus-lg" class="text-accent transition group-open:rotate-45 shrink-0" />
                </summary>
                <p class="pb-5 -mt-1 text-ink2 text-[15px] leading-relaxed">ถมดินเองประหยัดค่าแรงได้ แต่มักขาดเครื่องบดอัดที่มีประสิทธิภาพ ทำให้ดินไม่แน่น ส่งผลให้บ้าน ถนน หรือโครงสร้างที่ทำทีหลังทรุดตัว การจ้างมืออาชีพที่มีเครื่องมือครบมักคุ้มกว่าในระยะยาว โดยเฉพาะงานที่ต้องสร้างโครงสร้างถาวรบนพื้นที่นั้น</p>
            </details>
            <details class="group rounded-2xl border border-line bg-white px-5 [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-4 py-4 font-semibold text-navy-900">
                    ถมดินใกล้กำแพงข้างเคียงได้ไหม?
                    <x-icon name="plus-lg" class="text-accent transition group-open:rotate-45 shrink-0" />
                </summary>
                <p class="pb-5 -mt-1 text-ink2 text-[15px] leading-relaxed">ได้ แต่ต้องระวังแรงดันดินด้านข้างที่จะดันกำแพงหรือรั้วข้างเคียง หากถมสูงมากกว่า 1 เมตรควรวางแผนทำ <strong class="text-navy-900">กำแพงกันดิน</strong> หรือเสริมฐานรากรองรับ การไม่จัดการแรงดันดินเป็นสาเหตุหลักของกำแพงพัง ซึ่งอาจสร้างความเสียหายให้ทรัพย์สินข้างเคียง</p>
            </details>
        </div>
    </div>
</section>

{{-- ============ CTA ============ --}}
<section class="bg-surface border-t border-line">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-16 lg:py-20 flex flex-col lg:flex-row items-center justify-between gap-8">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold tracking-tight text-navy-900">ได้ตัวเลขแล้ว — ขอราคาจริงจากทีมช่างได้เลย</h2>
            <p class="mt-3 text-[15px] text-ink2 leading-relaxed max-w-xl">เราสำรวจหน้างานฟรี ไม่มีค่าใช้จ่าย และเสนอราคาจริงพร้อมรายละเอียดวัสดุทุกชิ้น ภายใน 5–7 วันทำการ</p>
            <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-[14px] text-ink2">
                <span><x-icon name="check-circle-fill" class="text-accent mr-1.5 inline-block" /> สำรวจหน้างานฟรี</span>
                <span><x-icon name="check-circle-fill" class="text-accent mr-1.5 inline-block" /> ไม่มีค่าแอบแฝง</span>
                <span><x-icon name="check-circle-fill" class="text-accent mr-1.5 inline-block" /> รับประกันงาน 2 ปี</span>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 shrink-0">
            <a href="/#contact" class="inline-flex items-center gap-2 rounded-xl bg-accent px-7 py-4 font-semibold text-white hover:bg-navy-900 transition shadow-lg shadow-navy-900/20 whitespace-nowrap">
                ขอใบเสนอราคาฟรี <x-icon name="arrow-right" />
            </a>
            <a href="tel:{{ config('company.phone') }}" class="inline-flex items-center gap-2 rounded-xl border border-navy-900 px-7 py-4 font-semibold text-navy-900 hover:bg-navy-900 hover:text-white transition whitespace-nowrap">
                <x-icon name="telephone-fill" class="shrink-0" /> {{ config('company.phone_formatted') }}
            </a>
        </div>
    </div>
</section>
@endsection
