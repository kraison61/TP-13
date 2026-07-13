@props(['reference'])
@php
    $voucherConfig = config('vouchers');
    $voucherTiers = $voucherConfig['tiers'];
@endphp
<section id="contact" class="bg-navy-900 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28 grid lg:grid-cols-12 gap-12">
        <div class="lg:col-span-5">
            <span class="inline-flex items-center gap-2 text-hivis font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-hivis"></span> ขอใบเสนอราคา</span>
            <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight leading-tight">จบปัญหาทิ้งงาน คุมงบได้เป๊ะ ไม่บานปลาย</h2>
            <p class="mt-4 text-lg text-white/60 leading-relaxed">วิศวกรคุมงานเอง พร้อมแจกแจงราคาทุกรายการโปร่งใส กรอกข้อมูลเพื่อรับการประเมินหน้างานฟรีภายใน 24 ชม. พร้อมสิทธิ์ E-Voucher สำหรับลูกค้าเว็บไซต์</p>

            <div class="mt-8 rounded-2xl border border-hivis/40 bg-gradient-to-br from-hivis/15 to-transparent p-6">
                <p class="inline-flex items-center gap-1.5 text-xs font-semibold tracking-widest uppercase text-hivis">
                    <i class="bi bi-gift-fill"></i> {{ $voucherConfig['banner']['badge'] }}
                </p>
                <p class="mt-3 text-lg font-bold leading-snug">
                    {{ $voucherConfig['banner']['headline'] }}
                </p>
                <p class="mt-2 text-sm text-white/60">
                    {{ $voucherConfig['banner']['subline'] }}
                </p>
            </div>

            <ul class="mt-8 space-y-4 text-white/85">
            <li class="flex gap-3.5">
        <i class="bi bi-telephone-fill text-hivis text-xl"></i>
        <div>
            <div class="text-[13px] text-white/50">โทรเลย</div>
            <a href="tel:{{ config('company.phone') }}"
               class="font-mono tabular-nums text-xl font-semibold hover:text-hivis transition">
                {{ config('company.phone_formatted') }}
            </a>
        </div>
    </li>
    <li class="flex gap-3.5">
        <i class="bi bi-line text-hivis text-xl"></i>
        <div>
            <div class="text-[13px] text-white/50">LINE</div>
            <a href="{{ config('company.line') }}"
               target="_blank"
               rel="noopener noreferrer"
               class="font-medium hover:text-hivis transition">
                {{ config('company.phone') }}
            </a>
        </div>
    </li>
    <li class="flex gap-3.5">
        <i class="bi bi-envelope-fill text-hivis text-xl"></i>
        <div>
            <div class="text-[13px] text-white/50">อีเมล</div>
            <a href="mailto:{{ config('company.email') }}"
               class="font-medium hover:text-hivis transition">
                {{ config('company.email') }}
            </a>
        </div>
    </li>
                <li class="flex gap-3.5"><i class="bi bi-geo-alt-fill text-hivis text-xl"></i><div><div class="text-[13px] text-white/50">สำนักงาน</div><div class="font-medium">{{config('company.address')}}</div></div></li>
                <li class="flex gap-3.5"><i class="bi bi-clock-fill text-hivis text-xl"></i><div><div class="text-[13px] text-white/50">เวลาทำการ</div><div class="font-medium">{{config('company.open_hours')}}</div></div></li>
            </ul>
        </div>

        <div class="lg:col-span-7">
            <form id="quoteForm"
                  action="{{ route('quote.store') }}"
                  method="POST"
                  data-voucher-tiers='@json($voucherTiers)'
                  data-voucher-default='@json($voucherConfig['default'])'
                  class="rounded-2xl bg-white p-6 sm:p-8 lg:p-10 text-ink shadow-2xl shadow-navy-950/40 grid sm:grid-cols-2 gap-6">
                @csrf
                <div class="sm:col-span-2 rounded-2xl border border-hivis/50 bg-gradient-to-br from-hivis/10 via-hivis/[0.03] to-transparent p-5 sm:p-6">
                    <label class="block text-sm font-bold text-navy-900 mb-2">
                        รหัส E-Voucher ของคุณ <span class="font-medium text-ink2">(จากเว็บไซต์)</span>
                    </label>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 rounded-xl border border-hivis bg-white px-4 py-3.5 shadow-sm">
                        <span class="font-mono tabular-nums text-lg sm:text-xl lg:text-2xl font-bold text-navy-900 tracking-wide min-w-0 truncate">{{ $reference }}</span>
                        <button type="button"
                                id="copyRefBtn"
                                data-copy="{{ $reference }}"
                                data-save-url="{{ route('voucher.copy') }}"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-hivis px-3.5 py-2 text-sm font-semibold text-navy-900 hover:bg-hivis/80 active:scale-95 transition shrink-0">
                            <i class="bi bi-clipboard" id="copyRefIcon"></i>
                            <span id="copyRefLabel">คัดลอก</span>
                        </button>
                    </div>
                    <input type="hidden" name="reference" value="{{ $reference }}">
                    <input type="hidden" name="requested_discount" id="requestedDiscount" value="">

                    <div id="voucherCard" class="mt-4 flex items-start gap-3.5 rounded-xl bg-white/70 px-4 py-4 transition-all duration-300">
                        <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-full bg-hivis text-navy-900 text-lg">
                            <!-- <i class="bi bi-ticket-perforated-fill"></i> -->
                             <i class="bi bi-gift-fill"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p id="voucherAmount" class="text-xl font-bold text-navy-900 tabular-nums leading-tight">{{ $voucherConfig['default']['amount_label'] }}</p>
                            <p id="voucherMessage" class="mt-1 text-sm text-ink2 leading-relaxed">{{ $voucherConfig['default']['message'] }}</p>
                            <p id="voucherTerms" class="mt-2 text-xs text-muted hidden"></p>
                            <button type="button"
                                    id="voucherTermsBtn"
                                    class="mt-2 inline-flex items-center gap-1 text-xs text-accent font-medium hover:underline">
                                <i class="bi bi-asterisk"></i> ดูเงื่อนไข E-Voucher
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 flex items-start gap-2 text-sm text-ink2 leading-relaxed">
                        <i class="bi bi-shield-check text-accent mt-0.5 shrink-0"></i>
                        <span>
                            แจ้งรหัส E-Voucher นี้ทาง LINE เพื่อยืนยันสิทธิ์ส่วนลด
                            และเพื่อเป็นการรับประกันว่าท่านติดต่อจากทีมงานเว็บไซต์อย่างเป็นทางการ (ป้องกันมิจฉาชีพ)
                        </span>
                    </div>

                    <a href="{{ config('company.line') }}" target="_blank" rel="noopener noreferrer"
                       class="mt-4 flex items-center justify-center gap-2.5 rounded-xl bg-[#06C755] px-6 py-4 text-lg font-bold text-white shadow-lg shadow-[#06C755]/30 hover:brightness-95 hover:-translate-y-0.5 active:scale-[0.99] transition">
                        <i class="bi bi-line text-2xl"></i>
                        แอด LINE ยืนยันสิทธิ์ E-Voucher
                    </a>
                </div>
                <div class="sm:col-span-1">
                    <label class="block text-sm font-medium text-navy-900 mb-1.5">ชื่อ–นามสกุล <span class="text-red-500">*</span></label>
                    <input name="name" required placeholder="กรุณากรอกชื่อ-นามสกุล"
                           class="w-full rounded-xl border border-line px-4 py-3 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition">
                </div>
                <div class="sm:col-span-1">
                    <label class="block text-sm font-medium text-navy-900 mb-1.5">เบอร์โทรศัพท์/ไลน์ <span class="text-red-500">*</span></label>
                    <input name="phone" required pattern="[0-9\-\s]{9,}" placeholder="08X-XXX-XXXX"
                           class="w-full rounded-xl border border-line px-4 py-3 font-mono tabular-nums outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition">
                </div>
                <div class="sm:col-span-1">
                    <label class="block text-sm font-medium text-navy-900 mb-1.5">ประเภทงาน <span class="text-red-500">*</span></label>
                    <select name="service" required
                            class="w-full rounded-xl border border-line px-4 py-3 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition bg-white">
                        <option value="">เลือกประเภทงาน...</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->title }}">{{ $service->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-1">
                    <label class="block text-sm font-medium text-navy-900 mb-1.5">งบประมาณคร่าวๆ <span class="text-red-500">*</span></label>
                    <select name="budget" id="budgetSelect" required
                            class="w-full rounded-xl border border-line px-4 py-3 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition bg-white">
                        <option value="" disabled selected>โปรดระบุงบประมาณ</option>
                        @foreach ($voucherTiers as $tier)
                            <option value="{{ $tier['budget'] }}">{{ $tier['budget'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-navy-900 mb-1.5">รายละเอียดงาน</label>
                    <textarea name="detail" rows="4" placeholder="เช่น ขนาดพื้นที่, ความสูง, ระยะเวลาที่ต้องการ ฯลฯ"
                              class="w-full rounded-xl border border-line px-4 py-3 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition"></textarea>
                </div>
                <label class="sm:col-span-2 flex items-center gap-2.5 text-sm text-ink2">
                    <input type="checkbox" required class="size-4 rounded border-line text-accent focus:ring-accent/30">
                    ยอมรับ <a href="{{ route('privacy') }}" class="text-accent font-medium">นโยบายความเป็นส่วนตัว</a>
                </label>
                <div class="sm:col-span-2 flex flex-wrap items-center gap-4">
                    <button type="submit" id="quoteSubmitBtn" class="inline-flex items-center gap-2 rounded-xl bg-accent px-7 py-3.5 font-semibold text-white hover:bg-navy-900 transition disabled:opacity-60 disabled:cursor-not-allowed">
                    เช็คสิทธิ์และนัดประเมินหน้างานฟรี <i class="bi bi-arrow-right"></i>
                    </button>
                    <span class="text-sm text-muted">บริการสำรวจหน้างานฟรีสำหรับ กทม. และปริมณฑล (ต่างจังหวัดสามารถส่งรูปประเมินเบื้องต้นได้ฟรีผ่าน LINE)</span>
                </div>
                <div id="quoteError" class="sm:col-span-2 hidden flex items-start gap-2 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-[15px]">
                    <i class="bi bi-exclamation-triangle-fill mt-0.5 shrink-0"></i>
                    <span id="quoteErrorText"></span>
                </div>
                <div id="quoteOK" class="sm:col-span-2 hidden flex items-start gap-2 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-[15px]">
                    <i class="bi bi-check-circle-fill mt-0.5 shrink-0"></i>
                    <span>
                        <span id="quoteOKText">ส่งคำขอเรียบร้อย!</span>
                        รหัสอ้างอิงของคุณคือ
                        <strong id="quoteRef" class="font-mono">{{ $reference }}</strong>
                        — ทีมงานจะติดต่อกลับเร็วที่สุด ขอบคุณที่ไว้วางใจครับ
                    </span>
                </div>
            </form>
        </div>
    </div>

    {{-- E-Voucher terms modal --}}
    <div id="voucherTermsModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
        <div id="voucherTermsBackdrop" class="absolute inset-0 bg-navy-950/70 backdrop-blur-sm"></div>
        <div class="relative flex min-h-full items-center justify-center p-4">
            <div role="dialog" aria-modal="true" aria-labelledby="voucherTermsTitle"
                 class="w-full max-w-md rounded-2xl bg-white p-6 text-ink shadow-2xl">
                <div class="flex items-start justify-between gap-4">
                    <h3 id="voucherTermsTitle" class="text-lg font-bold text-navy-900">เงื่อนไข E-Voucher</h3>
                    <button type="button" id="voucherTermsClose" class="text-muted hover:text-ink transition" aria-label="ปิด">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
                <p class="mt-4 text-sm text-ink2 leading-relaxed">{{ $voucherConfig['terms'] }}</p>
                <button type="button" id="voucherTermsCloseBtn"
                        class="mt-6 w-full rounded-xl bg-navy-900 px-4 py-3 text-sm font-semibold text-white hover:bg-navy-800 transition">
                    รับทราบ
                </button>
            </div>
        </div>
    </div>
</section>
