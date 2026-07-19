<section {{ $attributes->class('bg-surface') }}>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="min-w-0 flex-1">
                <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> เสียงจากลูกค้าจริง</span>
                <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ลูกค้ากว่า 100 บ้านพูดเป็นเสียงเดียวกัน</h2>
            </div>
            @if (is_array($testimonials) && count($testimonials) > 1)
            <div id="testiNav" class="flex shrink-0 gap-2">
                <button type="button" id="testiPrev" aria-label="รีวิวก่อนหน้า"
                        class="grid size-10 place-items-center rounded-full border border-line text-navy-900 text-xl transition hover:border-navy-900 hover:bg-navy-900 hover:text-white disabled:pointer-events-none disabled:opacity-40 sm:size-11"><x-icon name="arrow-left" />
                </button>
                <button type="button" id="testiNext" aria-label="รีวิวถัดไป"
                        class="grid size-10 place-items-center rounded-full border border-line text-navy-900 text-xl transition hover:border-navy-900 hover:bg-navy-900 hover:text-white disabled:pointer-events-none disabled:opacity-40 sm:size-11"><x-icon name="arrow-right" />
                </button>
            </div>
            @endif
        </div>

        @if (empty($testimonials) || !is_array($testimonials))
            <p class="mt-12 text-center text-muted py-12">ยังไม่มีรีวิวจากลูกค้า</p>
        @else
            <script type="application/json" id="testiData">@json($testimonials, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)</script>
            <div id="testiViewport" class="@container mt-12 w-full max-w-full overflow-hidden">
                <div id="testiTrack" class="flex gap-5 transition-transform duration-500 ease-out will-change-transform" aria-busy="true"></div>
            </div>
        @endif
    </div>
</section>
