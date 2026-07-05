@props(['projects', 'filterLabels'])
<section id="projects" class="bg-surface">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> ผลงานที่ผ่านมา</span>
            <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ผลงานก่อสร้างจริง — ลูกค้าจริง พื้นที่จริง</h2>
            <p class="mt-4 text-lg text-ink2">เลือกหมวดเพื่อกรองผลงานตามประเภทงาน</p>
        </div>

        <div class="mt-8 flex flex-wrap gap-2.5" id="filters">
            @foreach($filterLabels as $key => $label)
            <button data-filter="{{ $key }}"
                class="rounded-full border px-4 py-2.5 text-[15px] font-medium transition
                       {{ $key === 'all' ? 'border-navy-900 bg-navy-900 text-white' : 'border-line bg-transparent text-ink2 hover:border-navy-900 hover:text-navy-900' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>

        <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($projects as $p)
            <a href="#" data-cat="{{ $p['cat'] }}"
               class="group relative block aspect-4/3 overflow-hidden rounded-2xl ring-1 ring-line">
                <img src="https://images.unsplash.com/photo-{{ $p['img'] }}?w=900&q=80&auto=format&fit=crop"
                     alt="{{ $p['title'] }}" class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-navy-950/85 via-navy-950/15 to-transparent"></div>
                <div class="absolute inset-0 p-5 flex flex-col justify-end text-white">
                    <span class="self-start rounded-full bg-white/20 backdrop-blur px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide">{{ $p['tag'] }}</span>
                    <h3 class="mt-2.5 text-lg font-bold">{{ $p['title'] }}</h3>
                    <p class="text-[13px] text-white/75">{{ $p['meta'] }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>