@props(['testimonials', 'testiTabs'])
<section class="bg-surface">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
        <div class="text-center max-w-2xl mx-auto">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> เสียงจากลูกค้าจริง</span>
            <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ลูกค้ากว่า 400 บ้านพูดเป็นเสียงเดียวกัน</h2>
        </div>

        <div class="mt-8 flex justify-center gap-2" id="testTabs">
            @foreach($testiTabs as $i => $label)
            <button data-tab="{{ $i }}"
                class="rounded-full px-5 py-2.5 text-[15px] font-medium transition
                       {{ $i === 0 ? 'bg-navy-900 text-white' : 'bg-white border border-line text-ink2 hover:border-navy-900' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>

        @foreach($testimonials as $panelIdx => $panel)
        <div data-panel="{{ $panelIdx }}" class="mt-10 grid md:grid-cols-3 gap-5 {{ $panelIdx !== 0 ? 'hidden' : '' }}">
            @foreach($panel as $t)
            <figure class="rounded-2xl bg-white ring-1 ring-line p-7 flex flex-col">
                <div class="text-hivis text-[15px] mb-4">
                    @for($s = 0; $s < 5; $s++)<i class="bi bi-star-fill"></i>@endfor
                </div>
                <blockquote class="text-ink leading-relaxed flex-1">{{ $t['quote'] }}</blockquote>
                <figcaption class="mt-5 flex items-center gap-3">
                    <span class="grid place-items-center w-10 h-10 rounded-full bg-surface text-navy-900 font-bold">{{ $t['i'] }}</span>
                    <span>
                        <span class="block font-semibold text-navy-900 text-[15px]">{{ $t['name'] }}</span>
                        <span class="block text-[13px] text-muted">{{ $t['project'] }}</span>
                    </span>
                </figcaption>
            </figure>
            @endforeach
        </div>
        @endforeach
    </div>
</section>