@props(['services'])

<section id="services" class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
    <div class="max-w-2xl">
        <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> บริการของเรา</span>
        <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">งานก่อสร้างที่บ้านคุณต้องการ ครบจบในที่เดียว</h2>
        <p class="mt-4 text-lg text-ink2 leading-relaxed">ทีมงานเฉพาะทางสำหรับงานก่อสร้างนอกตัวบ้าน รับงานตั้งแต่ 5 ตร.ม. ถึงโครงการขนาดใหญ่ ในกรุงเทพฯ และปริมณฑล</p>
    </div>

    <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($services as $s)
        <a href="{{ route('services', ['service' => $s->slug]) }}#{{ $s->slug }}"
           class="group flex flex-col rounded-2xl border border-line bg-white p-7 hover:border-navy-900 hover:-translate-y-1 hover:shadow-2xl hover:shadow-navy-900/10 transition">
            <span class="grid place-items-center w-14 h-14 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><i class="bi {{ $s->icon_name }}"></i></span>
            <h3 class="text-xl font-bold text-navy-900">{{ $s->title }}</h3>
            <p class="mt-2 text-[15px] text-ink2 leading-relaxed flex-1">{{ $s->description }}</p>
            <div class="mt-5 pt-4 border-t border-dashed border-line flex gap-5 text-[13px] text-muted">
                @if ($s->activePrice)
                <span>เริ่มต้น <b class="text-navy-900 font-semibold">{{ number_format((float) $s->activePrice->price) }}.-/{{ $s->activePrice->unit }}</b></span>
                @endif
                @if ($s->dur)
                <span>ระยะงาน <b class="text-navy-900 font-semibold">{{ $s->dur }}</b></span>
                @endif
            </div>
            <span class="mt-4 inline-flex items-center gap-1.5 text-accent font-semibold text-[15px]">ดูรายละเอียดบริการ <i class="bi bi-arrow-right group-hover:translate-x-1 transition"></i></span>
        </a>
        @endforeach
    </div>
</section>