@props(['services'])

<section id="services" class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28">
    <div class="max-w-2xl">
        <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> บริการของเรา</span>
        <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">งานก่อสร้างที่บ้านคุณต้องการ ครบจบในที่เดียว</h2>
        <p class="mt-4 text-lg text-ink2 leading-relaxed">ทีมงานเฉพาะทางสำหรับงานก่อสร้างนอกตัวบ้าน รับงานตั้งแต่ 5 ตร.ม. ถึงโครงการขนาดใหญ่ ในกรุงเทพฯ และปริมณฑล</p>
    </div>

    <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($services as $s)
        <a href="{{ route('frontend.services.show', $s->slug) }}"
           class="group flex flex-col rounded-2xl border border-line bg-white overflow-hidden hover:border-navy-900 hover:-translate-y-1 hover:shadow-2xl hover:shadow-navy-900/10 transition">
            <div class="relative aspect-4/3 overflow-hidden bg-surface">
                @if ($s->img_1)
                    <img src="{{ Storage::disk('s3')->url($s->img_1) }}?width=400&format=webp&fit=cover"
                         alt="{{ $s->title }}" loading="lazy"
                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                @else
                    <span class="grid place-items-center h-full w-full bg-accent/8 text-accent text-4xl">
                        <i class="bi {{ $s->icon_name }}"></i>
                    </span>
                @endif
            </div>
            <div class="flex flex-col flex-1 p-7">
                <h3 class="text-xl font-bold text-navy-900">{{ $s->title }}</h3>
                <div class="mt-5 pt-4 border-t border-dashed border-line flex flex-wrap gap-x-5 gap-y-1 text-[13px] text-muted">
                    @if ($s->activePrice)
                    <span>เริ่มต้น <b class="text-navy-900 font-semibold">{{ number_format((float) $s->activePrice->price) }}.-/{{ $s->activePrice->unit }}</b></span>
                    @endif
                    @if ($s->dur)
                    <span>ระยะงาน <b class="text-navy-900 font-semibold">{{ $s->dur }}</b></span>
                    @endif
                </div>
                <span class="mt-4 inline-flex items-center gap-1.5 text-accent font-semibold text-[15px]">ดูรายละเอียดบริการ <i class="bi bi-arrow-right group-hover:translate-x-1 transition"></i></span>
            </div>
        </a>
        @endforeach
    </div>
</section>
