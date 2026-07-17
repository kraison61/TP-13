<section {{ $attributes->class('bg-surface') }}>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28">
        <div class="flex items-end justify-between gap-4">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> เสียงจากลูกค้าจริง</span>
                <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ลูกค้ากว่า 100 บ้านพูดเป็นเสียงเดียวกัน</h2>
            </div>
            @if (is_array($testimonials) && count($testimonials) > 1)
            <div id="testiNav" class="flex shrink-0 gap-2">
                <button type="button" id="testiPrev" aria-label="รีวิวก่อนหน้า"
                        class="grid size-10 place-items-center rounded-full border border-line text-navy-900 transition hover:border-navy-900 hover:bg-navy-900 hover:text-white disabled:pointer-events-none disabled:opacity-40 sm:size-11">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <button type="button" id="testiNext" aria-label="รีวิวถัดไป"
                        class="grid size-10 place-items-center rounded-full border border-line text-navy-900 transition hover:border-navy-900 hover:bg-navy-900 hover:text-white disabled:pointer-events-none disabled:opacity-40 sm:size-11">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
            @endif
        </div>

        @if (empty($testimonials) || !is_array($testimonials))
            <p class="mt-12 text-center text-muted py-12">ยังไม่มีรีวิวจากลูกค้า</p>
        @else
            <div id="testiViewport" class="@container mt-12 overflow-hidden">
                <div id="testiTrack" class="flex gap-5 transition-transform duration-500 ease-out will-change-transform">
                    @foreach($testimonials as $t)
                    <figure class="testi-slide w-[100cqw] shrink-0 @md:w-[calc((100cqw-1.25rem)/2)] @lg:w-[calc((100cqw-2.5rem)/3)] rounded-2xl bg-white ring-1 ring-line p-7 flex flex-col">
                        <div class="text-hivis text-[15px] mb-4">
                            @for($s = 0; $s < ($t['rating'] ?? 5); $s++)<i class="bi bi-star-fill"></i>@endfor
                        </div>
                        <blockquote class="text-ink leading-relaxed flex-1 line-clamp-4">{{ $t['quote'] }}</blockquote>
                        <figcaption class="mt-5 flex items-center gap-3">
                            <span class="grid place-items-center w-10 h-10 rounded-full bg-surface text-navy-900 font-bold">{{ $t['i'] }}</span>
                            <span class="min-w-0">
                                <span class="block font-semibold text-navy-900 text-[15px] truncate">{{ $t['name'] }}</span>
                                <span class="block text-[13px] text-muted truncate">{{ $t['project'] }}</span>
                            </span>
                        </figcaption>
                    </figure>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
