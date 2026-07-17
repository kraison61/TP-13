<section id="finance" class="bg-surface font-sans antialiased [text-wrap:pretty]">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 py-12 lg:py-16">

    <div class="mb-5 flex items-end justify-between gap-4">
      <div>
        <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.16em] text-xs uppercase">
          <span class="w-6 h-px bg-accent"></span> สินเชื่อพันธมิตร
        </span>
        <h2 class="mt-3 text-2xl lg:text-3xl font-bold tracking-tight text-navy-900 leading-tight">
          ทุนไม่พร้อม? เริ่มก่อน ผ่อนทีหลัง — เลือกพันธมิตรที่ใช่
        </h2>
      </div>
      @if($partners->count() > 1)
      <div id="finNav" class="flex shrink-0 gap-2">
        <button type="button" id="finPrev" aria-label="สไลด์ก่อนหน้า"
                class="grid size-10 place-items-center rounded-full border border-line text-navy-900 transition hover:border-navy-900 hover:bg-navy-900 hover:text-white disabled:pointer-events-none disabled:opacity-40 sm:size-11">
          <i class="bi bi-arrow-left"></i>
        </button>
        <button type="button" id="finNext" aria-label="สไลด์ถัดไป"
                class="grid size-10 place-items-center rounded-full border border-line text-navy-900 transition hover:border-navy-900 hover:bg-navy-900 hover:text-white disabled:pointer-events-none disabled:opacity-40 sm:size-11">
          <i class="bi bi-arrow-right"></i>
        </button>
      </div>
      @endif
    </div>

    @if($partners->isEmpty())
      <p class="py-12 text-center text-muted">ยังไม่มีพันธมิตรสินเชื่อในขณะนี้</p>
    @else
      <div id="finViewport" class="@container overflow-hidden">
        <div id="finTrack" class="flex gap-4 transition-transform duration-500 ease-out will-change-transform">
          @foreach($partners as $partner)
          <div class="fin-slide w-[100cqw] shrink-0 @md:w-[calc((100cqw-1rem)/2)] @lg:w-[calc((100cqw-2rem)/3)]">
            <div class="relative flex h-full flex-col overflow-hidden rounded-xl bg-navy-900 text-white">
              <div class="h-1 shrink-0" style="background:{{ $partner->color }}"></div>
              <div class="pointer-events-none absolute -right-10 -top-10 size-40 rounded-full opacity-10" style="background:{{ $partner->color }};filter:blur(40px)"></div>

              <div class="relative px-4 pt-4">
                <a href="{{ $partner->link }}" target="_blank" rel="noopener" class="block overflow-hidden rounded-lg transition hover:opacity-90">
                  <img src="{{ $partner->img }}" alt="{{ $partner->name }}" class="block min-h-16 w-full object-cover" />
                </a>
              </div>

              <div class="flex flex-1 flex-col gap-3 p-4 pt-3">
                <div class="flex items-center gap-2.5">
                  <span class="grid size-9 shrink-0 place-items-center rounded-lg text-lg text-navy-900" style="background:#ffc83a">
                    <i class="bi {{ $partner->icon }}"></i>
                  </span>
                  <div class="min-w-0">
                    <div class="truncate text-sm font-bold leading-tight text-white">{{ $partner->name }}</div>
                    <div class="mt-0.5 text-[11px] text-white/50">{{ $partner->type }}</div>
                  </div>
                </div>

                <div>
                  <div class="mb-1 text-[10px] font-semibold uppercase tracking-widest text-white/40">วงเงินกู้สูงสุด</div>
                  <div class="text-2xl font-bold tabular-nums text-white">{{ $partner->max_amount }}</div>
                  <div class="mt-1.5 inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[11px] font-semibold" style="background:{{ $partner->rgba_color }};color:#ffc83a">
                    <i class="bi bi-percent"></i> {{ $partner->rate }}
                  </div>
                </div>

                <ul class="flex flex-1 flex-col gap-1.5 text-[13px]">
                  @foreach($partner->features as $feature)
                  <li class="flex items-start gap-2 text-white/75">
                    <i class="bi bi-check-circle-fill mt-0.5 shrink-0 text-[13px]" style="color:#ffc83a"></i>
                    <span>{{ $feature }}</span>
                  </li>
                  @endforeach
                </ul>

                <a href="{{ $partner->link }}" target="_blank" rel="noopener"
                   class="mt-auto inline-flex items-center justify-center gap-2 rounded-lg py-2.5 text-sm font-semibold text-white transition hover:opacity-90"
                   style="background:{{ $partner->color }}">
                  สมัครเลย <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

    @endif

    <p class="mt-4 text-[13px] text-muted">
      * อัตราดอกเบี้ย วงเงิน และเงื่อนไขเป็นไปตามที่สถาบันการเงินกำหนด · {{ config('company.name') }} เป็นตัวแทน Affiliate ไม่ใช่ผู้ให้สินเชื่อโดยตรง · การอนุมัติขึ้นอยู่กับคุณสมบัติผู้กู้
    </p>

  </div>
</section>
