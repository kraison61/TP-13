<section id="finance" class="bg-surface font-sans antialiased [text-wrap:pretty]">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 py-12 lg:py-16">

    <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
      <div class="min-w-0 flex-1">
        <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.16em] text-xs uppercase">
          <span class="w-6 h-px bg-accent"></span> สินเชื่อพันธมิตร
        </span>
        <h2 class="mt-3 lg:text-3xl font-bold tracking-tight text-navy-900 leading-tight [text-wrap:balance]">
          ทุนไม่พร้อม? เริ่มก่อน ผ่อนทีหลัง — เลือกพันธมิตรที่ใช่
        </h2>
      </div>
      @if ($partners->count() > 1)
      <div id="finNav" class="flex shrink-0 gap-2">
        <button type="button" id="finPrev" aria-label="สไลด์ก่อนหน้า"
                class="grid size-10 place-items-center rounded-full border border-line text-navy-900 text-xl transition hover:border-navy-900 hover:bg-navy-900 hover:text-white disabled:pointer-events-none disabled:opacity-40 sm:size-11"><x-icon name="arrow-left" />
        </button>
        <button type="button" id="finNext" aria-label="สไลด์ถัดไป"
                class="grid size-10 place-items-center rounded-full border border-line text-navy-900 text-xl transition hover:border-navy-900 hover:bg-navy-900 hover:text-white disabled:pointer-events-none disabled:opacity-40 sm:size-11"><x-icon name="arrow-right" />
        </button>
      </div>
      @endif
    </div>

    @if ($partners->isEmpty())
      <p class="py-12 text-center text-muted">ยังไม่มีพันธมิตรสินเชื่อในขณะนี้</p>
    @else
      <script type="application/json" id="finPartnersData">@json($partnersPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)</script>
      <div id="finViewport" class="@container w-full max-w-full overflow-hidden">
        <div id="finTrack" class="flex gap-4 transition-transform duration-500 ease-out will-change-transform" aria-busy="true"></div>
      </div>
    @endif

    <p class="mt-4 text-[13px] text-muted">
      * อัตราดอกเบี้ย วงเงิน และเงื่อนไขเป็นไปตามที่สถาบันการเงินกำหนด · {{ config('company.name') }} เป็นตัวแทน Affiliate ไม่ใช่ผู้ให้สินเชื่อโดยตรง · การอนุมัติขึ้นอยู่กับคุณสมบัติผู้กู้
    </p>

  </div>
</section>
