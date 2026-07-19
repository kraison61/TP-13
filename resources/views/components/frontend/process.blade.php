@props(['steps'])
<section id="process" class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28">
    <div class="grid lg:grid-cols-12 gap-8 items-end mb-14">
        <div class="lg:col-span-7">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> ขั้นตอนการทำงาน</span>
            <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">โปร่งใส ตรวจสอบได้ ทุกขั้นตอน</h2>
        </div>
        <p class="lg:col-span-5 text-lg text-ink2 leading-relaxed">ลูกค้าทราบงบประมาณ ระยะเวลา และทีมงานก่อนเริ่มงานจริงเสมอ — ไม่มีค่าใช้จ่ายแอบแฝง</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($steps as $step)
        <div class="rounded-2xl border border-line bg-white p-6 hover:shadow-xl hover:shadow-navy-900/5 transition">
            <span class="grid place-items-center w-12 h-12 rounded-xl bg-navy-900 text-white text-xl mb-5"><x-icon:name="$step['icon']" /></span>
            <div class="font-mono text-xs font-bold tracking-[0.15em] text-accent">{{ $step['label'] }}</div>
            <h3 class="mt-2 text-lg font-bold text-navy-900">{{ $step['title'] }}</h3>
            <p class="mt-1.5 text-[15px] text-ink2 leading-relaxed">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>