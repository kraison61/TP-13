@extends('layouts.frontend')

@section('content')

{{-- ============ SERVICE HERO ============ --}}
<section class="relative overflow-hidden bg-gradient-to-b from-surface to-white">
    <div class="pointer-events-none absolute -top-24 right-0 h-[480px] w-[480px] rounded-full bg-accent/10 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 py-16 lg:py-20 grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <div>
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
                <span class="w-7 h-px bg-accent"></span>
                {{ $service->category?->name ?? 'บริการของเรา' }}
            </span>
            <div class="mt-5 flex items-center gap-4">
                <span class="grid place-items-center w-16 h-16 rounded-2xl bg-accent/8 text-accent text-3xl shrink-0">
                    <i class="bi {{ $service->icon_name }}"></i>
                </span>
                <h1 class="text-[clamp(1.9rem,3.6vw,3rem)] font-bold leading-[1.2] tracking-tight text-navy-900">
                    {{ $service->h1 ?: $service->title }}
                </h1>
            </div>
            @if ($service->description)
                <p class="mt-5 text-lg leading-relaxed text-ink2 max-w-xl">{{ $service->plain_description }}</p>
            @endif

            <div class="mt-7 flex flex-wrap gap-x-8 gap-y-3 text-[15px] text-ink2">
                @if ($service->activePrice)
                    <span>
                        <i class="bi bi-cash-coin text-accent mr-1.5"></i>
                        เริ่มต้น {{ number_format((float) $service->activePrice->price, 0) }} / {{ $service->activePrice->unit }}
                    </span>
                @endif
                @if ($service->dur)
                    <span>
                        <i class="bi bi-calendar-check text-accent mr-1.5"></i>
                        ระยะงาน {{ $service->dur }} วัน
                    </span>
                @endif
                <span><i class="bi bi-patch-check-fill text-accent mr-1.5"></i> รับประกัน 2 ปี</span>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="/#contact" class="inline-flex items-center gap-2 rounded-xl bg-accent px-6 py-3.5 font-semibold text-white shadow-lg shadow-navy-900/20 hover:bg-navy-900 transition">
                    ขอใบเสนอราคาฟรี <i class="bi bi-arrow-right"></i>
                </a>
                <a href="tel:{{ config('company.phone') }}" class="inline-flex items-center gap-2 rounded-xl border border-navy-900 px-6 py-3.5 font-semibold text-navy-900 hover:bg-navy-900 hover:text-white transition">
                    <i class="bi bi-telephone-fill"></i> โทรปรึกษาช่าง
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="relative aspect-4/5 overflow-hidden rounded-2xl shadow-2xl shadow-navy-900/30">
                @if ($service->img_1)
                    <img src="{{ Storage::disk('s3')->url($service->img_1) }}?width=900&format=webp&fit=cover"
                         alt="{{ $service->title }}" class="h-full w-full object-cover" />
                @else
                    <img src="https://images.unsplash.com/photo-1517089596392-fb9a9033e05b?w=900&q=80&auto=format&fit=crop"
                         alt="{{ $service->title }}" class="h-full w-full object-cover" />
                @endif
                <div class="absolute inset-x-5 bottom-5 flex items-center gap-4 rounded-xl bg-white/95 backdrop-blur p-4 shadow-xl">
                    <span class="grid place-items-center w-11 h-11 rounded-lg bg-navy-900 text-white text-xl">
                        <i class="bi bi-patch-check-fill"></i>
                    </span>
                    <div>
                        <div class="font-bold text-navy-900 text-[15px]">รับประกันงาน 2 ปีเต็ม</div>
                        <div class="text-[13px] text-muted">คำนวณโครงสร้างโดยวิศวกร · ใบ กว. ถูกต้อง</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-frontend.trust />

{{-- ============ OVERVIEW + SCOPE ============ --}}
<section class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-24">
    <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">
        <div class="lg:col-span-7">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
                <span class="w-7 h-px bg-accent"></span> รายละเอียดบริการ
            </span>
            <h2 class="mt-4 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900 leading-tight">
                {{ $service->h1 ?: $service->title }}
            </h2>

            @if ($service->content)
                <div class="service-content mt-5 text-[17px] text-ink2 leading-relaxed">
                    {!! $service->rendered_content !!}
                </div>
            @elseif ($service->description)
                <div class="service-content mt-5 text-[17px] text-ink2 leading-relaxed">
                    {!! $service->rendered_description !!}
                </div>
            @endif

            @if ($service->scopes->isNotEmpty())
                <h3 class="mt-10 text-xl font-bold text-navy-900">งานนี้รวมอะไรบ้าง</h3>
                <ul class="mt-4 grid sm:grid-cols-2 gap-x-6 gap-y-3 text-[15px] text-ink2">
                    @foreach ($service->scopes as $scope)
                        <li class="flex items-start gap-2.5">
                            <i class="bi bi-check-circle-fill text-accent mt-1 shrink-0"></i>
                            <span>{{ $scope->name }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <aside class="lg:col-span-5">
            <div class="lg:sticky lg:top-[76px] rounded-2xl border border-line bg-surface p-7">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <div class="text-[13px] text-muted">ราคาเริ่มต้น</div>
                        <div class="font-mono text-3xl font-bold text-navy-900 tracking-tight tabular-nums">
                            @if ($service->activePrice)
                                {{ number_format((float) $service->activePrice->price, 0) }}
                                <span class="text-base font-sans font-medium text-ink2">/ {{ $service->activePrice->unit }}</span>
                            @else
                                สอบถาม
                            @endif
                        </div>
                    </div>
                    <span class="rounded-full bg-hivis/20 text-accent text-[13px] font-semibold px-3 py-1.5">ประเมินฟรี</span>
                </div>
                <p class="mt-2 text-[14px] text-muted">* ราคาจริงขึ้นกับหน้างาน ขนาด และวัสดุที่เลือก ทีมงานสำรวจและตีราคาให้ฟรี</p>

                @if ($service->dur)
                    <div class="mt-4 flex items-center gap-2.5 rounded-xl bg-navy-900/5 px-3.5 py-2.5 text-[13px] text-navy-900">
                        <i class="bi bi-calendar-check text-accent text-base shrink-0"></i>
                        <span>ระยะเวลางานโดยประมาณ <b class="font-semibold">{{ $service->dur }} วันทำการ</b></span>
                    </div>
                @endif

                <a href="/#contact" class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-accent px-6 py-3.5 font-semibold text-white hover:bg-navy-900 transition">
                    ขอใบเสนอราคางานนี้ <i class="bi bi-arrow-right"></i>
                </a>
                <a href="tel:{{ config('company.phone') }}" class="mt-2.5 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-line bg-white px-6 py-3 font-semibold text-navy-900 hover:border-navy-900 transition">
                    <i class="bi bi-telephone-fill text-accent"></i> {{ config('company.phone_formatted') }}
                </a>
                <a href="{{ route('frontend.services.index') }}#{{ $service->slug }}" class="mt-2.5 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-line bg-white px-6 py-3 font-semibold text-navy-900 hover:border-navy-900 transition">
                    <i class="bi bi-arrow-left"></i> กลับหน้าบริการ
                </a>
            </div>
        </aside>
    </div>
</section>

{{-- ============ PRICING TABLE ============ --}}
<x-frontend.service.price-table :service="$service" />

{{-- ============ PROCESS ============ --}}
<section class="bg-surface">
    <x-frontend.process :steps="$steps" />
</section>

{{-- ============ RELATED PROJECTS ============ --}}
@if ($portfolios->isNotEmpty())
    <section class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-10">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
                    <span class="w-7 h-px bg-accent"></span> ผลงานที่เกี่ยวข้อง
                </span>
                <h2 class="mt-4 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900 leading-tight">
                    ตัวอย่างงาน{{ $service->title }}ที่เราทำมา
                </h2>
            </div>
            <a href="{{ route('home') }}#projects" class="inline-flex items-center gap-1.5 text-accent font-semibold text-[15px] hover:gap-2.5 transition-all">
                ดูผลงานทั้งหมด <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($portfolios as $portfolio)
                <a href="{{ route('home') }}#projects"
                   class="group relative block aspect-4/3 overflow-hidden rounded-2xl ring-1 ring-line">
                    <img src="{{ $portfolio->cover_image ?: 'https://images.unsplash.com/photo-1517089596392-fb9a9033e05b?w=900&q=80&auto=format&fit=crop' }}"
                         alt="{{ $portfolio->title }}"
                         loading="lazy"
                         class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-950/85 via-navy-950/15 to-transparent"></div>
                    <div class="absolute inset-0 p-5 flex flex-col justify-end text-white">
                        <span class="self-start rounded-full bg-white/20 backdrop-blur px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide">
                            {{ $service->title }}
                        </span>
                        <h3 class="mt-2.5 text-lg font-bold">{{ $portfolio->title }}</h3>
                        @if ($portfolio->meta)
                            <p class="text-[13px] text-white/75">{{ $portfolio->meta }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endif

{{-- ============ SERVICE FAQ ============ --}}
@if ($service->faqs->isNotEmpty())
    <section class="bg-surface">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-24">
            <div class="grid lg:grid-cols-12 gap-10 lg:gap-16">
                <div class="lg:col-span-5">
                    <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
                        <span class="w-7 h-px bg-accent"></span> คำถามที่พบบ่อย
                    </span>
                    <h2 class="mt-4 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900 leading-tight">เรื่องที่ลูกค้ามักถามก่อนเริ่มงาน</h2>
                    <p class="mt-4 text-lg text-ink2 leading-relaxed">
                        ไม่พบคำตอบที่ต้องการ? โทร
                        <a href="tel:{{ config('company.phone') }}" class="font-mono tabular-nums text-accent font-semibold">{{ config('company.phone_formatted') }}</a>
                        ทีมงานพร้อมตอบทุกวัน {{ config('company.open_hours') }}
                    </p>
                </div>
                <div class="lg:col-span-7 space-y-3">
                    @foreach ($service->faqs as $faq)
                        <details @class([
                            'group rounded-2xl border border-line bg-white px-5 [&_summary::-webkit-details-marker]:hidden',
                        ]) @if($loop->first) open @endif>
                            <summary class="flex cursor-pointer items-center justify-between gap-4 py-4 font-semibold text-navy-900">
                                {{ $faq->question }}
                                <i class="bi bi-plus-lg text-accent transition group-open:rotate-45"></i>
                            </summary>
                            <p class="pb-5 -mt-1 text-[15px] text-ink2 leading-relaxed">{{ $faq->answer }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

{{-- ============ OTHER SERVICES ============ --}}
@if ($otherServices->isNotEmpty())
    <section class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-24">
        <div class="max-w-2xl mb-10">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
                <span class="w-7 h-px bg-accent"></span> บริการอื่น ๆ
            </span>
            <h2 class="mt-4 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900 leading-tight">เราดูแลงานนอกตัวบ้านครบทุกประเภท</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($otherServices as $other)
                <a href="{{ route('frontend.services.show', $other->slug) }}"
                   class="group flex flex-col rounded-2xl border border-line bg-white p-7 hover:border-navy-900 hover:-translate-y-1 hover:shadow-2xl hover:shadow-navy-900/10 transition">
                    <span class="grid place-items-center w-14 h-14 rounded-xl bg-accent/8 text-accent text-2xl mb-5">
                        <i class="bi {{ $other->icon_name }}"></i>
                    </span>
                    <h3 class="text-xl font-bold text-navy-900">{{ $other->title }}</h3>
                    @if ($other->description)
                        <p class="mt-2 text-[15px] text-ink2 leading-relaxed flex-1">{{ $other->description }}</p>
                    @endif
                    <div class="mt-5 pt-4 border-t border-dashed border-line flex flex-wrap gap-x-5 gap-y-1 text-[13px] text-muted">
                        @if ($other->activePrice)
                            <span>เริ่มต้น <b class="text-navy-900 font-semibold">{{ number_format((float) $other->activePrice->price, 0) }} / {{ $other->activePrice->unit }}</b></span>
                        @endif
                        @if ($other->dur)
                            <span>ระยะงาน <b class="text-navy-900 font-semibold">{{ $other->dur }} วัน</b></span>
                        @endif
                    </div>
                    <span class="mt-4 inline-flex items-center gap-1.5 text-accent font-semibold text-[15px]">
                        ดูรายละเอียดบริการ <i class="bi bi-arrow-right group-hover:translate-x-1 transition"></i>
                    </span>
                </a>
            @endforeach
        </div>
    </section>
@endif

@if (! empty($serviceSchemaLd['@graph']))
<script type="application/ld+json">
{!! json_encode($serviceSchemaLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endif

@endsection
