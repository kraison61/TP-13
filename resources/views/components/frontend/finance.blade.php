<section id="finance" class="bg-surface font-sans antialiased [text-wrap:pretty]">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 py-12 lg:py-16">

  <div class="mb-6">
    <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.16em] text-xs uppercase">
      <span class="w-6 h-px bg-accent"></span> สินเชื่อพันธมิตร Affiliate
    </span>
    <h2 class="mt-3 text-2xl lg:text-3xl font-bold tracking-tight text-navy-900 leading-tight">
      ทุนไม่พร้อม? เริ่มก่อน ผ่อนทีหลัง — เลือกพันธมิตรที่ใช่
    </h2>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    @foreach($partners as $partner)
    <div class="relative overflow-hidden rounded-2xl bg-navy-900 text-white flex flex-col">
      <div style="height:5px;background:{{ $partner->color }};flex-shrink:0"></div>
      <div class="pointer-events-none absolute -right-12 -top-12 h-48 w-48 rounded-full opacity-10" style="background:{{ $partner->color }};filter:blur(40px)"></div>

      <div class="relative px-5 pt-5">
        <a href="{{ $partner->link }}" target="_blank" rel="noopener" class="block overflow-hidden rounded-xl hover:opacity-90 transition">
          <img src="{{ $partner->img }}" border="0" class="w-full block" style="min-height:80px;object-fit:cover;" />
        </a>
      </div>

      <div class="flex flex-col flex-1 p-5 pt-4 gap-4">
        <div class="flex items-center gap-3">
          <span class="grid place-items-center w-11 h-11 rounded-xl shrink-0 text-navy-900 text-xl" style="background:#ffc83a">
            <i class="bi {{ $partner->icon }}"></i>
          </span>
          <div>
            <div class="font-bold text-base text-white leading-tight">{{ $partner->name }}</div>
            <div class="text-white/50 text-xs mt-0.5">{{ $partner->type }}</div>
          </div>
        </div>

        <div>
          <div class="text-white/40 text-[11px] font-semibold uppercase tracking-widest mb-1">วงเงินกู้สูงสุด</div>
          <div class="text-3xl font-bold tabular-nums text-white">{{ $partner->max_amount }}</div>
          <div class="mt-2 inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold" style="background:{{ $partner->rgba_color }};color:#ffc83a">
            <i class="bi bi-percent"></i> {{ $partner->rate }}
          </div>
        </div>

        <ul class="flex flex-col gap-2 text-sm flex-1">
          @foreach($partner->features as $feature)
          <li class="flex items-center gap-2 text-white/75">
            <i class="bi bi-check-circle-fill shrink-0" style="color:#ffc83a"></i>{{ $feature }}
          </li>
          @endforeach
        </ul>

        <a href="{{ $partner->link }}" target="_blank" rel="noopener"
           class="mt-auto inline-flex items-center justify-center gap-2 rounded-xl py-3 font-semibold text-white hover:opacity-90 transition"
           style="background:{{ $partner->color }}">
          สมัครเลย <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
    @endforeach

  </div>

  <p class="mt-4 text-[13px] text-muted">
    * อัตราดอกเบี้ย วงเงิน และเงื่อนไขเป็นไปตามที่สถาบันการเงินกำหนด · ธีรพงษ์การช่างเป็นตัวแทน Affiliate ไม่ใช่ผู้ให้สินเชื่อโดยตรง · การอนุมัติขึ้นอยู่กับคุณสมบัติผู้กู้
  </p>

  </div>
</section>