@extends('layouts.frontend')

@section('content')
<main class="mx-auto max-w-7xl px-6 py-16 lg:py-24">
    <nav class="flex items-center gap-2 text-[13px] text-muted mb-8">
        <a href="{{ route('home') }}" class="hover:text-navy-900 transition">หน้าแรก</a>
        <i class="bi bi-chevron-right text-[10px]"></i>
        <a href="{{ route('frontend.services.index') }}" class="hover:text-navy-900 transition">บริการทั้งหมด</a>
        <i class="bi bi-chevron-right text-[10px]"></i>
        <span class="text-navy-900 font-medium">{{ $service->title }}</span>
    </nav>

    <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-start">
        <div class="lg:col-span-8">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
                <span class="w-7 h-px bg-accent"></span> รายละเอียดบริการ
            </span>
            <h1 class="mt-3 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900">{{ $service->h1 ?: $service->title }}</h1>
            @if ($service->description)
                <p class="mt-4 text-[17px] text-ink2 leading-relaxed">{{ $service->description }}</p>
            @endif

            @if ($service->content)
                <div class="mt-10 prose prose-zinc max-w-none text-ink2 leading-relaxed service-content">
                    {!! $service->content !!}
                </div>
            @endif
        </div>

        <aside class="lg:col-span-4">
            <div class="lg:sticky lg:top-[88px] rounded-2xl border border-line bg-surface p-7">
                <div class="grid place-items-center w-14 h-14 rounded-xl bg-navy-900 text-white text-2xl mb-5">
                    <i class="bi {{ $service->icon_name }}"></i>
                </div>
                <h2 class="text-xl font-bold text-navy-900">{{ $service->title }}</h2>

                @if ($service->activePrice)
                    <div class="mt-5 rounded-xl bg-white p-5 border border-line">
                        <div class="text-[12px] font-semibold uppercase tracking-[0.15em] text-muted mb-1">ราคาเริ่มต้น</div>
                        <div class="font-mono text-2xl font-bold text-navy-900">
                            {{ number_format((float) $service->activePrice->price, 0) }}
                            <span class="text-base font-sans font-medium text-ink2">/ {{ $service->activePrice->unit }}</span>
                        </div>
                    </div>
                @endif

                @if ($service->dur)
                    <div class="mt-3 rounded-xl bg-white p-5 border border-line">
                        <div class="text-[12px] font-semibold uppercase tracking-[0.15em] text-muted mb-1">ระยะเวลางาน</div>
                        <div class="font-mono text-2xl font-bold text-navy-900">
                            {{ $service->dur }} <span class="text-base font-sans font-medium text-ink2">วันทำการ</span>
                        </div>
                    </div>
                @endif

                @if ($service->scopes->isNotEmpty())
                    <h3 class="mt-6 text-sm font-bold text-navy-900">ขอบเขตและประเภทงาน</h3>
                    <ul class="mt-3 space-y-2 text-[14px] text-ink2">
                        @foreach ($service->scopes as $scope)
                            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-accent shrink-0 mt-0.5"></i>{{ $scope->name }}</li>
                        @endforeach
                    </ul>
                @endif

                <a href="/#contact" class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-accent px-6 py-3.5 font-semibold text-white hover:bg-navy-900 transition">ขอใบเสนอราคา <i class="bi bi-arrow-right"></i></a>
                <a href="{{ route('frontend.services.index') }}#{{ $service->slug }}" class="mt-2.5 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-line bg-white px-6 py-3 font-semibold text-navy-900 hover:border-navy-900 transition"><i class="bi bi-arrow-left"></i> กลับหน้าบริการ</a>
            </div>
        </aside>
    </div>
</main>
@endsection
