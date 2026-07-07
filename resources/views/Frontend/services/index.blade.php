@extends('layouts.frontend')

@section('content')
<x-frontend.service.hero />
<x-frontend.service.quick-jump />
    <main class="mx-auto max-w-7xl px-6 py-16 lg:py-24 space-y-24">

        @foreach ($services as $service)
            <section id="{{ $service->slug }}" class="scroll-mt-36 grid lg:grid-cols-12 gap-10 lg:gap-16 items-start">

                <div class="lg:col-span-5 {{ $loop->odd ? 'order-1 lg:order-2' : 'order-1' }}">
                    <div class="relative aspect-4/5 rounded-2xl overflow-hidden shadow-2xl shadow-navy-900/20">
                        <img src="{{ Storage::disk('s3')->url($service->img_1) }}?width=450&format=webp&fit=cover" alt="{{ $service->title }}" loading="lazy" class="h-full w-full object-cover" />
                        <!-- <img src="https://images.unsplash.com/photo-1517089596392-fb9a9033e05b?w=900&q=80&auto=format&fit=crop" alt="{{ $service->title }}" loading="lazy" class="h-full w-full object-cover" /> -->
                        <div class="absolute top-4 left-4 grid place-items-center w-14 h-14 rounded-xl bg-navy-900 text-white text-2xl shadow-lg">
                            <i class="bi {{ $service->icon_name }}"></i>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 {{ $loop->odd ? 'order-2 lg:order-1' : 'order-2' }}">
                    <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
                        <span class="w-7 h-px bg-accent"></span> บริการ {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <h2 class="mt-3 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900">{{ $service->title }}</h2>
                    <p class="mt-3 text-[17px] text-ink2 leading-relaxed">{{ $service->description }}</p>

                    <div class="mt-7 grid sm:grid-cols-2 gap-3">
                        <div class="rounded-xl bg-surface p-5">
                            <div class="text-[12px] font-semibold uppercase tracking-[0.15em] text-muted mb-1">ราคาเริ่มต้น</div>
                            <div class="font-mono text-2xl font-bold text-navy-900">
                                {{ $service->prices->first()->price }} <span class="text-base font-sans font-medium text-ink2">/ {{ $service->prices->first()->unit }}</span>
                            </div>
                        </div>
                        <div class="rounded-xl bg-surface p-5">
                            <div class="text-[12px] font-semibold uppercase tracking-[0.15em] text-muted mb-1">ระยะเวลางาน</div>
                            <div class="font-mono text-2xl font-bold text-navy-900">
                                {{ $service->dur }} <span class="text-base font-sans font-medium text-ink2">วันทำการ</span>
                            </div>
                        </div>
                    </div>

                    @if (!empty($service->features))
                        <div class="mt-7 grid sm:grid-cols-2 gap-y-3 gap-x-6 text-[15px] text-ink2">
                            @foreach ($service->features as $feature)
                                <span><i class="bi bi-check-circle-fill text-accent mr-2"></i>{{ $feature }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="/#contact" class="inline-flex items-center gap-2 rounded-xl bg-accent px-6 py-3.5 font-semibold text-white hover:bg-navy-900 transition">ขอใบเสนอราคา <i class="bi bi-arrow-right"></i></a>
                        <a href="tel:0812345678" class="inline-flex items-center gap-2 rounded-xl border border-navy-900 px-6 py-3.5 font-semibold text-navy-900 hover:bg-navy-900 hover:text-white transition"><i class="bi bi-telephone"></i> โทรปรึกษาฟรี</a>
                    </div>
                </div>
            </section>

            @if (!$loop->last)
                <div class="border-t border-line"></div>
            @endif
        @endforeach

    </main>
    <x-frontend.service.compare-table />
@endsection