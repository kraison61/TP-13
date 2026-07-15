@extends('layouts.frontend')

@section('content')
<!-- ===== HERO ===== -->
<section class="relative overflow-hidden bg-gradient-to-b from-surface to-white">
  <div class="pointer-events-none absolute -top-24 right-0 h-[520px] w-[520px] rounded-full bg-accent/10 blur-3xl"></div>
  <div class="relative mx-auto max-w-7xl px-6 py-16 lg:py-24 grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
    <div>
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
        <span class="w-7 h-px bg-accent"></span> เกี่ยวกับเรา
      </span>
      <h1 class="mt-5 text-[clamp(2.2rem,4.2vw,3.6rem)] font-bold leading-[1.3] tracking-tight text-navy-900">
        {{ config('company.experience_years') }} ปีที่สร้างความ<span class="bg-gradient-to-t from-hivis/60 from-[28%] to-transparent to-[28%]">ไว้วางใจ</span><br/>บนทุกผืนดิน
      </h1>
      <p class="mt-5 text-lg leading-relaxed text-ink2 max-w-xl">
        ธีรพงษ์เซอร์วิสเริ่มต้นจากช่างคนเดียวที่เชื่อมั่นในความซื่อสัตย์และคุณภาพงาน — วันนี้รับเหมาก่อสร้างมาแล้ว {{ config('company.projects_completed') }} งาน ทั่วกรุงเทพฯ และปริมณฑล ไม่เคยทิ้งงานแม้แต่ครั้งเดียว
      </p>
      <div class="mt-8 flex flex-wrap gap-3">
        <a href="index.html#contact" class="inline-flex items-center gap-2 rounded-xl bg-accent px-6 py-3.5 font-semibold text-white shadow-lg shadow-navy-900/20 hover:bg-navy-900 transition">ขอใบเสนอราคาฟรี <i class="bi bi-arrow-right"></i></a>
        <a href="index.html#projects" class="inline-flex items-center gap-2 rounded-xl border border-navy-900 px-6 py-3.5 font-semibold text-navy-900 hover:bg-navy-900 hover:text-white transition">ดูผลงานก่อสร้าง</a>
      </div>
      <div class="mt-9 flex flex-wrap gap-x-8 gap-y-3 text-[15px] text-ink2">
        <span><i class="bi bi-check-circle-fill text-accent mr-1.5"></i> {{ config('company.experience_label') }} {{ config('company.experience_years') }} ปี</span>
        <span><i class="bi bi-check-circle-fill text-accent mr-1.5"></i> ใบอนุญาตชั้น ค ถูกต้อง</span>
        <span><i class="bi bi-check-circle-fill text-accent mr-1.5"></i> ทีมงาน {{ config('company.team_size') }} คน</span>
      </div>
    </div>
    <div class="relative">
      <div class="relative aspect-4/5 overflow-hidden rounded-2xl shadow-2xl shadow-navy-900/30">
        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=1200&q=80&auto=format&fit=crop" alt="ทีมช่างธีรพงษ์การช่าง" class="h-full w-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/60 via-transparent to-transparent"></div>
        <div class="absolute inset-x-5 bottom-5 flex items-center gap-4 rounded-xl bg-white/95 backdrop-blur p-4 shadow-xl">
          <span class="grid place-items-center w-11 h-11 rounded-lg bg-navy-900 text-white text-xl"><i class="bi bi-patch-check-fill"></i></span>
          <div>
            <div class="font-bold text-navy-900 text-[15px]">ก่อตั้งโดย {{ config('company.founder_name') }}</div>
            <div class="text-[13px] text-muted">ผู้รับเหมาก่อสร้าง · {{ config('company.experience_label') }} {{ config('company.experience_years') }} ปี</div>
          </div>
        </div>
      </div>
      <div class="absolute -left-4 top-8 hidden sm:flex items-center gap-3 rounded-xl bg-white p-3 pr-4 shadow-xl ring-1 ring-line">
        <span class="grid place-items-center w-10 h-10 rounded-lg bg-hivis/20 text-accent text-lg"><i class="bi bi-trophy-fill"></i></span>
        <div>
          <div class="font-mono font-bold text-navy-900 leading-none tabular-nums">{{ config('company.projects_completed') }}</div>
          <div class="text-[12px] text-muted mt-0.5">งานรับเหมาสำเร็จ</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== TRUST STRIP ===== -->
<div class="border-y border-line bg-white">
  <div class="mx-auto max-w-7xl px-6 py-7 flex flex-wrap items-center justify-between gap-4">
    <span class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">ใบรับรองและมาตรฐาน</span>
    <div class="flex flex-wrap gap-2.5">
      <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[15px] text-ink2"><i class="bi bi-shield-check text-accent"></i> มอก. 109-2552</span>
      <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[15px] text-ink2"><i class="bi bi-award-fill text-accent"></i> ใบอนุญาตชั้น ค</span>
      <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[15px] text-ink2"><i class="bi bi-people-fill text-accent"></i> สมาชิก ส.อ.ท.</span>
      <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[15px] text-ink2"><i class="bi bi-cone-striped text-accent"></i> จป. วิชาชีพ</span>
      <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[15px] text-ink2"><i class="bi bi-bank2 text-accent"></i> ขึ้นทะเบียนภาครัฐ</span>
    </div>
  </div>
</div>

<!-- ===== STATS ===== -->
<section class="bg-navy-900 text-white">
  <div class="mx-auto max-w-7xl px-6 py-20 lg:py-24">
    <div class="grid lg:grid-cols-12 gap-8 items-end mb-14">
      <div class="lg:col-span-7">
        <span class="inline-flex items-center gap-2 text-hivis font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-hivis"></span> ตัวเลขที่ภูมิใจ</span>
        <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight leading-tight">ตัวเลขที่สะท้อน<br/>ความมุ่งมั่นทุกวัน</h2>
      </div>
      <p class="lg:col-span-5 text-lg text-white/60 leading-relaxed">ตลอด {{ config('company.experience_years') }} ปี เราไม่เคยทิ้งงาน ไม่เคยบิดสัญญา และไม่เคยส่งงานที่ต่ำกว่ามาตรฐาน — ตัวเลขเหล่านี้คือหลักฐาน</p>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-px bg-white/10 rounded-2xl overflow-hidden">
      <div class="bg-navy-900 p-7">
        <div class="font-mono text-5xl font-bold tracking-tight tabular-nums">{{ config('company.experience_years') }}<span class="text-2xl text-hivis ml-1">ปี</span></div>
        <div class="mt-2 text-white/55">{{ config('company.experience_label') }}</div>
      </div>
      <div class="bg-navy-900 p-7">
        <div class="font-mono text-5xl font-bold tracking-tight tabular-nums">{{ config('company.projects_completed') }}<span class="text-2xl text-hivis ml-1">งาน</span></div>
        <div class="mt-2 text-white/55">รับเหมาก่อสร้างที่ส่งมอบเรียบร้อย</div>
      </div>
      <div class="bg-navy-900 p-7">
        <div class="font-mono text-5xl font-bold tracking-tight tabular-nums">{{ config('company.team_size') }}</div>
        <div class="mt-2 text-white/55">ทีมช่างประจำและวิศวกร</div>
      </div>
      <div class="bg-navy-900 p-7">
        <div class="font-mono text-5xl font-bold tracking-tight tabular-nums">98<span class="text-2xl text-hivis ml-1">%</span></div>
        <div class="mt-2 text-white/55">ลูกค้าแนะนำต่อเพื่อนและครอบครัว</div>
      </div>
    </div>
  </div>
</section>

<!-- ===== OUR STORY ===== -->
<section class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
  <div class="grid lg:grid-cols-12 gap-12 lg:gap-20 items-start">
    <div class="lg:col-span-5 lg:sticky lg:top-28">
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
        <span class="w-7 h-px bg-accent"></span> เรื่องราวของเรา
      </span>
      <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">จากช่างคนเดียว สู่ทีม {{ config('company.team_size') }} ชีวิต</h2>
      <p class="mt-5 text-[16px] text-ink2 leading-relaxed">{{ config('company.founder_name') }} เริ่มต้นรับงานก่อสร้างด้วยทุนไม่มาก แต่มีสิ่งเดียวที่ไม่ยอมลดทอน — มาตรฐานและความซื่อสัตย์กับลูกค้า</p>
      <p class="mt-4 text-[16px] text-ink2 leading-relaxed">จากปากต่อปาก งานก็โตขึ้น ทีมงานก็ขยายใหญ่ขึ้น จนถึงวันนี้ที่เรามีวิศวกร ช่างระดับอาวุโส และทีม Back-office ที่พร้อมดูแลทุกโครงการตั้งแต่ต้นจนจบ</p>
      <div class="mt-8 flex items-center gap-4 p-5 rounded-2xl bg-surface border border-line">
        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80&auto=format&fit=crop&face" alt="{{ config('company.founder_name') }}" class="w-14 h-14 rounded-xl object-cover shrink-0" />
        <div>
          <div class="font-bold text-navy-900">{{ config('company.founder_name') }}</div>
          <div class="text-[14px] text-muted mt-0.5">{{ config('company.founder_title') }} {{ config('company.name') }}</div>
          <div class="text-[13px] text-ink2 mt-1">"สร้างให้ดีเหมือนสร้างบ้านตัวเอง"</div>
        </div>
      </div>
    </div>

    <!-- Timeline -->
    <div class="lg:col-span-7">
      <div class="relative pl-8 border-l-2 border-line space-y-0">

        <div class="relative pb-10">
          <span class="absolute -left-[calc(1rem+1px)] top-1 w-8 h-8 rounded-full bg-navy-900 text-white grid place-items-center text-sm font-bold ring-4 ring-white">1</span>
          <div class="ml-6">
            <div class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-3">พ.ศ. 2549</div>
            <h3 class="text-xl font-bold text-navy-900">ก่อตั้งกิจการ — ช่างคนเดียว</h3>
            <p class="mt-2 text-[15px] text-ink2 leading-relaxed">{{ config('company.founder_name') }} เริ่มรับงานก่อสร้างอิสระในย่านนนทบุรี รับงานรั้ว ลาน และงานถนนขนาดเล็ก ด้วยทีมช่างที่ไว้ใจได้</p>
          </div>
        </div>

        <div class="relative pb-10">
          <span class="absolute -left-[calc(1rem+1px)] top-1 w-8 h-8 rounded-full bg-navy-900 text-white grid place-items-center text-sm font-bold ring-4 ring-white">2</span>
          <div class="ml-6">
            <div class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-3">พ.ศ. 2554</div>
            <h3 class="text-xl font-bold text-navy-900">จดทะเบียนห้างหุ้นส่วน — ขยายทีมงาน</h3>
            <p class="mt-2 text-[15px] text-ink2 leading-relaxed">จดทะเบียนในนาม "หจก. ธีรพงษ์การช่าง" รับใบอนุญาตรับเหมาก่อสร้างชั้น ค เพิ่มทีมงานเป็น 12 คน เริ่มรับงานกำแพงกันดินและโครงการขนาดกลาง</p>
          </div>
        </div>

        <div class="relative pb-10">
          <span class="absolute -left-[calc(1rem+1px)] top-1 w-8 h-8 rounded-full bg-navy-900 text-white grid place-items-center text-sm font-bold ring-4 ring-white">3</span>
          <div class="ml-6">
            <div class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-3">พ.ศ. 2558</div>
            <h3 class="text-xl font-bold text-navy-900">100 โครงการแรก — ขึ้นทะเบียนภาครัฐ</h3>
            <p class="mt-2 text-[15px] text-ink2 leading-relaxed">ส่งมอบโครงการครบ 100 แห่ง ขึ้นทะเบียนผู้รับเหมาภาครัฐ เริ่มรับงานโครงการหมู่บ้านและนิคมอุตสาหกรรม ลงทุนเครื่องจักรหนักเพิ่มเติม</p>
          </div>
        </div>

        <div class="relative pb-10">
          <span class="absolute -left-[calc(1rem+1px)] top-1 w-8 h-8 rounded-full bg-accent text-white grid place-items-center text-sm font-bold ring-4 ring-white"><i class="bi bi-star-fill text-xs"></i></span>
          <div class="ml-6">
            <div class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-3">พ.ศ. 2562</div>
            <h3 class="text-xl font-bold text-navy-900">เปิดพอร์ทัลลูกค้าออนไลน์</h3>
            <p class="mt-2 text-[15px] text-ink2 leading-relaxed">นำระบบ CRM และพอร์ทัลติดตามงานออนไลน์มาใช้เป็นเจ้าแรกในกลุ่มรับเหมาขนาดกลาง ลูกค้าเห็นรูปหน้างานรายวันและ Daily Report ผ่านมือถือได้เลย</p>
          </div>
        </div>

        <div class="relative">
          <span class="absolute -left-[calc(1rem+1px)] top-1 w-8 h-8 rounded-full bg-hivis text-navy-900 grid place-items-center text-sm font-bold ring-4 ring-white"><i class="bi bi-flag-fill text-xs"></i></span>
          <div class="ml-6">
            <div class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-3">ปัจจุบัน · 2569</div>
            <h3 class="text-xl font-bold text-navy-900">รับเหมา {{ config('company.projects_completed') }} งาน · ไม่ทิ้งงาน</h3>
            <p class="mt-2 text-[15px] text-ink2 leading-relaxed">วันนี้เรามีทีมช่างและวิศวกร {{ config('company.team_size') }} คน พร้อมดูแลทุกโครงการตั้งแต่สำรวจหน้างานจนส่งมอบพร้อมใบรับประกัน</p>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- ===== CORE VALUES ===== -->
<section class="bg-surface border-t border-line">
  <div class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
    <div class="max-w-2xl mb-12">
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> ค่านิยมองค์กร</span>
      <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">สิ่งที่ทำให้เราเป็นเรา ทุกวันทุกโครงการ</h2>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <div class="rounded-2xl border border-line bg-white p-7 hover:border-navy-900 hover:-translate-y-1 hover:shadow-2xl hover:shadow-navy-900/10 transition">
        <span class="grid place-items-center w-14 h-14 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><i class="bi bi-shield-fill-check"></i></span>
        <h3 class="text-xl font-bold text-navy-900">คุณภาพไม่ต่อรอง</h3>
        <p class="mt-2 text-[15px] text-ink2 leading-relaxed">ใช้วัสดุมาตรฐาน มอก. ทุกชิ้น ควบคุมคุณภาพโดยวิศวกรตั้งแต่ฐานรากจนเสร็จสมบูรณ์ ไม่มีการลดมาตรฐานเพื่อลดต้นทุน</p>
      </div>
      <div class="rounded-2xl border border-line bg-white p-7 hover:border-navy-900 hover:-translate-y-1 hover:shadow-2xl hover:shadow-navy-900/10 transition">
        <span class="grid place-items-center w-14 h-14 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><i class="bi bi-eye-fill"></i></span>
        <h3 class="text-xl font-bold text-navy-900">โปร่งใสทุกขั้นตอน</h3>
        <p class="mt-2 text-[15px] text-ink2 leading-relaxed">ราคา BOQ และไทม์ไลน์ชัดเจนก่อนเซ็นสัญญา ลูกค้าติดตามงานได้ผ่านพอร์ทัลออนไลน์ ไม่มีค่าใช้จ่ายแอบแฝง</p>
      </div>
      <div class="rounded-2xl border border-line bg-white p-7 hover:border-navy-900 hover:-translate-y-1 hover:shadow-2xl hover:shadow-navy-900/10 transition">
        <span class="grid place-items-center w-14 h-14 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><i class="bi bi-clock-history"></i></span>
        <h3 class="text-xl font-bold text-navy-900">ตรงเวลาเสมอ</h3>
        <p class="mt-2 text-[15px] text-ink2 leading-relaxed">เราเคารพเวลาของลูกค้า ทุกโครงการมีแผนงานรายสัปดาห์ หากมีเหตุล่าช้าแจ้งทันทีพร้อมแผนแก้ไข ไม่ปล่อยให้ลูกค้างง</p>
      </div>
      <div class="rounded-2xl border border-line bg-white p-7 hover:border-navy-900 hover:-translate-y-1 hover:shadow-2xl hover:shadow-navy-900/10 transition">
        <span class="grid place-items-center w-14 h-14 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><i class="bi bi-heart-fill"></i></span>
        <h3 class="text-xl font-bold text-navy-900">ดูแลหลังส่งมอบ</h3>
        <p class="mt-2 text-[15px] text-ink2 leading-relaxed">รับประกันงาน 2 ปีเต็ม พร้อมทีม After-Sales ที่รับแจ้งซ่อมได้ทันที ลูกค้าไม่ถูกทิ้งหลังจ่ายเงินครบ</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== TEAM ===== -->
<section class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
  <div class="max-w-2xl mb-12">
    <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> ทีมงานของเรา</span>
    <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ทีมมืออาชีพที่ดูแลทุกโครงการของคุณ</h2>
    <p class="mt-4 text-lg text-ink2 leading-relaxed">วิศวกร ช่างอาวุโส และทีมงานที่ผ่านการฝึกอบรมมาตรฐาน — ทุกคนมีประสบการณ์ตรงในงานก่อสร้างโครงสร้างคอนกรีต</p>
  </div>

  <!-- Featured: Founder -->
  <div class="rounded-2xl border border-line bg-white overflow-hidden mb-8">
    <div class="grid lg:grid-cols-5 gap-0">
      <div class="lg:col-span-2 relative aspect-4/3 lg:aspect-auto overflow-hidden">
        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=900&q=80&auto=format&fit=crop" alt="{{ config('company.founder_name') }}" class="absolute inset-0 w-full h-full object-cover" />
      </div>
      <div class="lg:col-span-3 p-8 lg:p-10 flex flex-col justify-center">
        <span class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-4 self-start">{{ config('company.founder_title') }}</span>
        <h3 class="text-3xl font-bold text-navy-900">{{ config('company.founder_name') }}</h3>
        <div class="mt-1 text-muted font-medium">{{ config('company.founder_title') }} {{ config('company.name') }} · รับเหมาก่อสร้าง {{ config('company.projects_completed') }} งาน</div>
        <p class="mt-5 text-[16px] text-ink2 leading-relaxed max-w-xl">"ผมเริ่มต้นจากความเชื่อว่างานก่อสร้างที่ดีต้องสร้างความเชื่อมั่น ไม่ใช่แค่โครงสร้าง — {{ config('company.projects_completed') }} งานที่ผ่านมายืนยันว่าความซื่อสัตย์คือสิ่งที่ทำให้ธุรกิจยั่งยืน"</p>
        <div class="mt-6 flex flex-wrap gap-2.5">
          <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[14px] text-ink2"><i class="bi bi-mortarboard-fill text-accent"></i> วศ.บ. วิศวกรรมโยธา จุฬาฯ</span>
          <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[14px] text-ink2"><i class="bi bi-card-checklist text-accent"></i> ใบ กว. เลขที่ 12345</span>
          <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[14px] text-ink2"><i class="bi bi-buildings-fill text-accent"></i> {{ config('company.projects_completed') }} งาน</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Team grid -->
  <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <div class="rounded-2xl border border-line bg-white overflow-hidden hover:-translate-y-1 hover:shadow-xl hover:shadow-navy-900/10 transition">
      <div class="aspect-square overflow-hidden bg-surface">
        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=600&q=80&auto=format&fit=crop" alt="วิศวกรโครงสร้าง" class="w-full h-full object-cover" />
      </div>
      <div class="p-5">
        <div class="font-bold text-navy-900">นายสมชาย ดีงาม</div>
        <div class="text-[13px] text-muted mt-0.5">วิศวกรโครงสร้างอาวุโส</div>
        <div class="mt-3 flex flex-wrap gap-1.5">
          <span class="text-[12px] rounded-full bg-surface px-2.5 py-1 text-ink2">ฐานราก</span>
          <span class="text-[12px] rounded-full bg-surface px-2.5 py-1 text-ink2">กำแพงกันดิน</span>
        </div>
      </div>
    </div>
    <div class="rounded-2xl border border-line bg-white overflow-hidden hover:-translate-y-1 hover:shadow-xl hover:shadow-navy-900/10 transition">
      <div class="aspect-square overflow-hidden bg-surface">
        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&q=80&auto=format&fit=crop" alt="หัวหน้าช่าง" class="w-full h-full object-cover" />
      </div>
      <div class="p-5">
        <div class="font-bold text-navy-900">นายวีรชาติ สุขใส</div>
        <div class="text-[13px] text-muted mt-0.5">หัวหน้าช่างก่อสร้าง</div>
        <div class="mt-3 flex flex-wrap gap-1.5">
          <span class="text-[12px] rounded-full bg-surface px-2.5 py-1 text-ink2">รั้วบ้าน</span>
          <span class="text-[12px] rounded-full bg-surface px-2.5 py-1 text-ink2">ถนน</span>
        </div>
      </div>
    </div>
    <div class="rounded-2xl border border-line bg-white overflow-hidden hover:-translate-y-1 hover:shadow-xl hover:shadow-navy-900/10 transition">
      <div class="aspect-square overflow-hidden bg-surface">
        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=600&q=80&auto=format&fit=crop" alt="ผู้จัดการโครงการ" class="w-full h-full object-cover" />
      </div>
      <div class="p-5">
        <div class="font-bold text-navy-900">นางสาวกนกวรรณ ทองดี</div>
        <div class="text-[13px] text-muted mt-0.5">ผู้จัดการโครงการ</div>
        <div class="mt-3 flex flex-wrap gap-1.5">
          <span class="text-[12px] rounded-full bg-surface px-2.5 py-1 text-ink2">PM</span>
          <span class="text-[12px] rounded-full bg-surface px-2.5 py-1 text-ink2">Client Relations</span>
        </div>
      </div>
    </div>
    <div class="rounded-2xl border border-line bg-white overflow-hidden hover:-translate-y-1 hover:shadow-xl hover:shadow-navy-900/10 transition">
      <div class="aspect-square overflow-hidden bg-surface">
        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=600&q=80&auto=format&fit=crop" alt="ช่างเทคนิคอาวุโส" class="w-full h-full object-cover" />
      </div>
      <div class="p-5">
        <div class="font-bold text-navy-900">นายมานพ ชำนาญ</div>
        <div class="text-[13px] text-muted mt-0.5">ช่างเทคนิคอาวุโส</div>
        <div class="mt-3 flex flex-wrap gap-1.5">
          <span class="text-[12px] rounded-full bg-surface px-2.5 py-1 text-ink2">ลานคอนกรีต</span>
          <span class="text-[12px] rounded-full bg-surface px-2.5 py-1 text-ink2">ระบายน้ำ</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CERTIFICATIONS ===== -->
<section class="bg-navy-900 text-white">
  <div class="mx-auto max-w-7xl px-6 py-20 lg:py-24">
    <div class="grid lg:grid-cols-12 gap-12 items-center">
      <div class="lg:col-span-5">
        <span class="inline-flex items-center gap-2 text-hivis font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-hivis"></span> ใบรับรองและมาตรฐาน</span>
        <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight leading-tight">ทุกใบอนุญาต ทุกมาตรฐาน ครบถ้วน</h2>
        <p class="mt-5 text-lg text-white/60 leading-relaxed">เราดำเนินธุรกิจอย่างถูกต้องและโปร่งใสมาตลอด {{ config('company.experience_years') }} ปี — ลูกค้าสามารถตรวจสอบใบอนุญาตและเลขทะเบียนได้ทุกรายการ</p>
        <a href="index.html#contact" class="mt-7 inline-flex items-center gap-2 rounded-xl bg-hivis px-7 py-3.5 font-semibold text-navy-900 hover:bg-white transition">ขอดูเอกสารต้นฉบับ <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="lg:col-span-7 grid sm:grid-cols-2 gap-4">
        <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-6 hover:bg-white/10 transition">
          <span class="grid place-items-center w-12 h-12 rounded-xl bg-hivis/15 text-hivis text-2xl mb-4"><i class="bi bi-award-fill"></i></span>
          <div class="font-bold text-white">ใบอนุญาตรับเหมาก่อสร้าง ชั้น ค</div>
          <div class="mt-1 text-[14px] text-white/55">กรมโยธาธิการและผังเมือง · เลขที่ xxxxxx</div>
        </div>
        <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-6 hover:bg-white/10 transition">
          <span class="grid place-items-center w-12 h-12 rounded-xl bg-hivis/15 text-hivis text-2xl mb-4"><i class="bi bi-shield-fill-check"></i></span>
          <div class="font-bold text-white">มาตรฐาน มอก. 109-2552</div>
          <div class="mt-1 text-[14px] text-white/55">สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</div>
        </div>
        <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-6 hover:bg-white/10 transition">
          <span class="grid place-items-center w-12 h-12 rounded-xl bg-hivis/15 text-hivis text-2xl mb-4"><i class="bi bi-cone-striped"></i></span>
          <div class="font-bold text-white">เจ้าหน้าที่ความปลอดภัย จป. วิชาชีพ</div>
          <div class="mt-1 text-[14px] text-white/55">กรมสวัสดิการและคุ้มครองแรงงาน</div>
        </div>
        <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-6 hover:bg-white/10 transition">
          <span class="grid place-items-center w-12 h-12 rounded-xl bg-hivis/15 text-hivis text-2xl mb-4"><i class="bi bi-bank2"></i></span>
          <div class="font-bold text-white">ขึ้นทะเบียนผู้รับเหมาภาครัฐ</div>
          <div class="mt-1 text-[14px] text-white/55">กรมบัญชีกลาง · เลขทะเบียน xxxxxx</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== WHY US (TESTIMONIALS STRIP) ===== -->
<section class="bg-surface border-t border-line">
  <div class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
    <div class="text-center max-w-2xl mx-auto mb-12">
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> เสียงจากลูกค้าจริง</span>
      <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ลูกค้ากว่า 400 บ้านพูดเป็นเสียงเดียวกัน</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-5">
      <figure class="rounded-2xl bg-white ring-1 ring-line p-7 flex flex-col">
        <div class="text-hivis text-[15px] mb-4"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
        <blockquote class="text-ink leading-relaxed flex-1">"ทีมงานเป็นมืออาชีพมาก สื่อสารตรงไปตรงมา ราคาที่เสนอตรงตามที่จ่ายจริง รั้วโมเดิร์นที่ทำให้สวยมากค่ะ"</blockquote>
        <figcaption class="mt-5 flex items-center gap-3">
          <span class="grid place-items-center w-10 h-10 rounded-full bg-surface text-navy-900 font-bold">ก</span>
          <span><span class="block font-semibold text-navy-900 text-[15px]">คุณกชกร เลิศมงคล</span><span class="block text-[13px] text-muted">รั้วบ้านโมเดิร์น · ราชพฤกษ์</span></span>
        </figcaption>
      </figure>
      <figure class="rounded-2xl bg-white ring-1 ring-line p-7 flex flex-col">
        <div class="text-hivis text-[15px] mb-4"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
        <blockquote class="text-ink leading-relaxed flex-1">"กำแพงกันดินสูง 2.5 ม. ทำเสร็จก่อนกำหนด 3 วัน วิศวกรเข้ามาตรวจหน้างานทุกสัปดาห์ ราคายุติธรรมครับ"</blockquote>
        <figcaption class="mt-5 flex items-center gap-3">
          <span class="grid place-items-center w-10 h-10 rounded-full bg-surface text-navy-900 font-bold">ส</span>
          <span><span class="block font-semibold text-navy-900 text-[15px]">คุณสมชาย ภักดี</span><span class="block text-[13px] text-muted">กำแพงกันดิน · บางใหญ่</span></span>
        </figcaption>
      </figure>
      <figure class="rounded-2xl bg-white ring-1 ring-line p-7 flex flex-col">
        <div class="text-hivis text-[15px] mb-4"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
        <blockquote class="text-ink leading-relaxed flex-1">"ลานคอนกรีตขัดมันสวยตามแบบ ใช้จอดรถมา 2 ปี ไม่มีร้าวเลย คุ้มมาก แนะนำต่อให้เพื่อนบ้านแล้วค่ะ"</blockquote>
        <figcaption class="mt-5 flex items-center gap-3">
          <span class="grid place-items-center w-10 h-10 rounded-full bg-surface text-navy-900 font-bold">ป</span>
          <span><span class="block font-semibold text-navy-900 text-[15px]">คุณปรียา วงศ์เจริญ</span><span class="block text-[13px] text-muted">ลานจอดรถ · นนทบุรี</span></span>
        </figcaption>
      </figure>
    </div>
  </div>
</section>
@endsection