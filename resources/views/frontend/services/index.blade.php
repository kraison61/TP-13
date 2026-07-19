@extends('layouts.frontend')

@section('content')
<x-frontend.page-hero
    :current="$hero['current'] ?? null"
    :eyebrow="$hero['eyebrow'] ?? ''"
    :title="$hero['title'] ?? ''"
    :description="$hero['description'] ?? ''"
    :badges="$hero['badges'] ?? []"
/>

{{-- ============ MAIN CONTENT ============ --}}
    <main class="mx-auto max-w-7xl px-4 sm:px-6 py-16 lg:py-24 space-y-24">

        @foreach ($services as $service)
            <section id="{{ $service->slug }}" class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-start">

                <div class="lg:col-span-5 {{ $loop->odd ? 'order-1 lg:order-2' : 'order-1' }}">
                    <a href="{{ route('frontend.services.show', $service->slug) }}"
                       class="group relative block aspect-4/5 rounded-2xl overflow-hidden shadow-2xl shadow-navy-900/20">
                        @if ($service->img_1)
                            <img src="{{ Storage::disk('s3')->url($service->img_1) }}?width=450&format=webp&fit=cover" alt="{{ $service->title }}" loading="lazy" width="450" height="338" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                        @else
                            <img src="https://images.unsplash.com/photo-1517089596392-fb9a9033e05b?w=900&q=80&auto=format&fit=crop" alt="{{ $service->title }}" loading="lazy" width="450" height="338" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                        @endif
                        <div class="pointer-events-none absolute top-4 left-4 grid place-items-center w-14 h-14 rounded-xl bg-navy-900 text-white text-2xl shadow-lg"><x-icon :name="$service->icon_name" />
                        </div>
                    </a>
                </div>

                <div class="lg:col-span-7 {{ $loop->odd ? 'order-2 lg:order-1' : 'order-2' }}">
                    <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
                        <span class="w-7 h-px bg-accent"></span> บริการ {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <h2 class="mt-3 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900">{{ $service->title }}</h2>
                    <p class="mt-3 text-[17px] text-ink2 leading-relaxed">{!! $service->description !!}</p>

                    <div class="mt-7 grid sm:grid-cols-2 gap-3">
                        <div class="rounded-xl bg-surface p-5">
                            <div class="text-[12px] font-semibold uppercase tracking-[0.15em] text-muted mb-1">ราคาเริ่มต้น</div>
                            <div class="font-mono font-bold text-navy-900">
                                @if ($service->activePrice)
                                    {{ number_format((float) $service->activePrice->price, 0) }}
                                    <span class="text-base font-sans font-medium text-ink2">/ {{ $service->activePrice->unit }}</span>
                                @elseif ($service->prices->first())
                                    {{ number_format((float) $service->prices->first()->price, 0) }}
                                    <span class="text-base font-sans font-medium text-ink2">/ {{ $service->prices->first()->unit }}</span>
                                @else
                                    <span class="text-base font-sans font-medium text-ink2">สอบถาม</span>
                                @endif
                            </div>
                        </div>
                        <div class="rounded-xl bg-surface p-5">
                            <div class="text-[12px] font-semibold uppercase tracking-[0.15em] text-muted mb-1">ระยะเวลางาน</div>
                            <div class="font-mono font-bold text-navy-900">
                                {{ $service->dur }} <span class="text-base font-sans font-medium text-ink2">วันทำการ</span>
                            </div>
                        </div>
                    </div>

                    @if ($service->scopes->isNotEmpty())
                        <h3 class="mt-7 text-lg font-bold text-navy-900">ขอบเขตและประเภทงาน</h3>
                        <div class="mt-4 grid sm:grid-cols-2 gap-y-3 gap-x-6 text-[15px] text-ink2">
                            @foreach ($service->scopes as $scope)
                                <span><x-icon name="check-circle-fill" class="text-accent mr-2 inline-block" />{{ $scope->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="/#contact" class="inline-flex items-center gap-2 rounded-xl bg-accent px-6 py-3.5 font-semibold text-white hover:bg-navy-900 transition">ขอใบเสนอราคา <x-icon name="arrow-right" /></a>
                        <a href="{{ route('frontend.services.show', $service->slug) }}" class="inline-flex items-center gap-2 rounded-xl border border-navy-900 px-6 py-3.5 font-semibold text-navy-900 hover:bg-navy-900 hover:text-white transition">ดูรายละเอียดงานบริการ <x-icon name="arrow-right" /></a>
                        <a href="tel:0812345678" class="inline-flex items-center gap-2 rounded-xl border border-line px-6 py-3.5 font-semibold text-navy-900 hover:border-navy-900 transition"><x-icon name="telephone" /> โทรปรึกษาฟรี</a>
                    </div>
                </div>
            </section>

            @if (!$loop->last)
                <div class="border-t border-line"></div>
            @endif
        @endforeach

    </main>
    <x-frontend.service.compare-table :columns="$compareColumns" />
@endsection