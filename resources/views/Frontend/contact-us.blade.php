@extends('layouts.frontend')

@section('content')

<section class="relative overflow-hidden bg-gradient-to-b from-surface to-white">
  <div class="pointer-events-none absolute -top-24 right-0 h-[520px] w-[520px] rounded-full bg-accent/10 blur-3xl"></div>
  <div class="relative mx-auto max-w-7xl px-6 py-16 lg:py-24 grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
    <div>
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
        <span class="w-7 h-px bg-accent"></span> เกี่ยวกับเรา
      </span>
      <h1 class="mt-5 text-[clamp(2rem,4vw,3.3rem)] font-bold leading-[1.3] tracking-tight text-navy-900">
        จากเด็กอัดจารบีข้างรถแบคโฮ<br/>สู่ผู้รับเหมาที่<span class="bg-gradient-to-t from-hivis/60 from-[28%] to-transparent to-[28%]">ไม่เคยทิ้งงาน</span>แม้แต่ครั้งเดียว
      </h1>
      <p class="mt-5 text-lg leading-relaxed text-ink2 max-w-xl">
        กลัวจ้างแล้วโดนทิ้ง? เริ่มจากตัวเลขนี้ — <strong class="text-navy-900">ทิ้งงาน 0 งาน</strong> รับเหมาก่อสร้างมาแล้ว {{ config('company.projects_completed') }} งาน ราคาประเมินตามหน้างานจริง 100% ไม่มีค่าแอบแฝง
      </p>

      {{-- หมัดน็อก: สถิติความภาคภูมิใจ — อยู่ Hero ทันที ไม่ต้องเลื่อน --}}
      <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3">
        <div class="rounded-xl bg-navy-900 px-3 py-4 text-center shadow-lg shadow-navy-900/20">
          <div class="font-mono text-3xl sm:text-4xl font-bold tabular-nums text-hivis leading-none">0</div>
          <div class="mt-1.5 text-[11px] sm:text-xs text-white/60 leading-snug">งานที่เคยทิ้ง<br class="sm:hidden"/> <span class="hidden sm:inline">· </span>ตลอด {{ config('company.experience_years') }} ปี</div>
        </div>
        <div class="rounded-xl bg-navy-900 px-3 py-4 text-center shadow-lg shadow-navy-900/20">
          <div class="font-mono text-3xl sm:text-4xl font-bold tabular-nums text-hivis leading-none">100<span class="text-xl">%</span></div>
          <div class="mt-1.5 text-[11px] sm:text-xs text-white/60 leading-snug">ประเมินราคา<br class="sm:hidden"/> <span class="hidden sm:inline">· </span>ตามจริง</div>
        </div>
        <div class="rounded-xl bg-navy-900 px-3 py-4 text-center shadow-lg shadow-navy-900/20">
          <div class="font-mono text-3xl sm:text-4xl font-bold tabular-nums text-hivis leading-none">{{ config('company.projects_completed') }}</div>
          <div class="mt-1.5 text-[11px] sm:text-xs text-white/60 leading-snug">งานรับเหมา<br class="sm:hidden"/> <span class="hidden sm:inline">· </span>ก่อสร้างสำเร็จ</div>
        </div>
        <div class="rounded-xl bg-navy-900 px-3 py-4 text-center shadow-lg shadow-navy-900/20">
          <div class="font-mono text-3xl sm:text-4xl font-bold tabular-nums text-hivis leading-none">1</div>
          <div class="mt-1.5 text-[11px] sm:text-xs text-white/60 leading-snug">ทีมครบจบ<br class="sm:hidden"/> <span class="hidden sm:inline">· </span>ไม่โยนงานกัน</div>
        </div>
      </div>

      <div class="mt-8">
        <div class="flex flex-wrap gap-3">
          <a href="{{ route('home') }}#contact" class="inline-flex items-center gap-2 rounded-xl bg-accent px-6 py-3.5 font-semibold text-white shadow-lg shadow-navy-900/20 hover:bg-navy-900 transition">ส่งรูปให้ประเมินเบื้องต้นฟรี <i class="bi bi-arrow-right"></i></a>
          <a href="{{ route('home') }}#projects" class="inline-flex items-center gap-2 rounded-xl border border-navy-900 px-6 py-3.5 font-semibold text-navy-900 hover:bg-navy-900 hover:text-white transition">ดูผลงานจริง</a>
        </div>
        <p class="mt-2.5 text-sm text-muted"><i class="bi bi-shield-check text-accent mr-1"></i>ประเมินฟรี · ไม่มีค่าใช้จ่าย · ไม่ผูกมัด · ตอบกลับภายใน 24 ชม.</p>
      </div>
    </div>
    <div class="relative">
      <div class="relative aspect-4/5 overflow-hidden rounded-2xl shadow-2xl shadow-navy-900/30">
        <!-- TODO: เปลี่ยนเป็นรูปจริงของผู้ก่อตั้งข้างรถแบคโฮ/หน้างาน — รูปจริง 1 รูปสร้างความไว้ใจมากกว่าข้อความ 10 ย่อหน้า -->
        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=1200&q=80&auto=format&fit=crop" alt="{{ config('company.founder_name') }} ผู้ก่อตั้งธีรพงษ์เซอร์วิส" class="h-full w-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/60 via-transparent to-transparent"></div>
        <div class="absolute inset-x-5 bottom-5 flex items-center gap-4 rounded-xl bg-white/95 backdrop-blur p-4 shadow-xl">
          <span class="grid place-items-center w-11 h-11 rounded-lg bg-navy-900 text-white text-xl"><i class="bi bi-patch-check-fill"></i></span>
          <div>
            <div class="font-bold text-navy-900 text-[15px]">ก่อตั้งโดย {{ config('company.founder_name') }}</div>
            <div class="text-[13px] text-muted">จากเด็กติดรถ สู่ผู้เชี่ยวชาญกำแพงกันดิน · {{ config('company.experience_label') }} {{ config('company.experience_years') }} ปี</div>
          </div>
        </div>
      </div>
      <div class="absolute -left-4 top-8 hidden sm:flex items-center gap-3 rounded-xl bg-navy-900 p-3 pr-4 shadow-xl ring-1 ring-navy-800">
        <span class="grid place-items-center w-10 h-10 rounded-lg bg-hivis/20 text-hivis text-lg"><i class="bi bi-patch-check-fill"></i></span>
        <div>
          <div class="font-mono font-bold text-hivis leading-none tabular-nums text-2xl">0</div>
          <div class="text-[12px] text-white/60 mt-0.5">งานที่เคยทิ้ง</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== TRUST STRIP (คำมั่นของเรา) ===== -->
<div class="border-y border-line bg-white">
  <div class="mx-auto max-w-7xl px-6 py-7 flex flex-wrap items-center justify-between gap-4">
    <span class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">คำมั่นที่เรารักษาเสมอ</span>
    <div class="flex flex-wrap gap-2.5">
      <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[15px] text-ink2"><i class="bi bi-patch-check-fill text-accent"></i> ไม่ทิ้งงานเด็ดขาด</span>
      <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[15px] text-ink2"><i class="bi bi-eye-fill text-accent"></i> ราคาตามจริง ไม่มีแอบแฝง</span>
      <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[15px] text-ink2"><i class="bi bi-box-seam-fill text-accent"></i> วัสดุตรงสเปก</span>
      <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[15px] text-ink2"><i class="bi bi-chat-dots-fill text-accent"></i> คุยง่าย ตอบตรง</span>
      <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[15px] text-ink2"><i class="bi bi-box2-heart-fill text-accent"></i> ครบจบในทีมเดียว</span>
    </div>
  </div>
</div>

<!-- ===== STATS (ตัวเลขที่เป็นความจริง) ===== -->
<section class="bg-navy-900 text-white">
  <div class="mx-auto max-w-7xl px-6 py-20 lg:py-24">
    <div class="grid lg:grid-cols-12 gap-8 items-end mb-14">
      <div class="lg:col-span-7">
        <span class="inline-flex items-center gap-2 text-hivis font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-hivis"></span> สิ่งที่เราภูมิใจ</span>
        <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight leading-tight">ตัวเลขที่เราภูมิใจที่สุด<br/>ไม่ใช่ตัวเลขที่ใหญ่ที่สุด</h2>
      </div>
      <p class="lg:col-span-5 text-lg text-white/60 leading-relaxed">ตัวเลขที่คุณเห็นด้านบนแล้ว — นี่คือรายละเอียดที่เรารักษาไว้ได้ทุกวัน ทุกงาน จาก{{ config('company.experience_label') }} {{ config('company.experience_years') }} ปี</p>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-px bg-white/10 rounded-2xl overflow-hidden">
      <div class="bg-navy-900 p-7">
        <div class="font-mono text-5xl font-bold tracking-tight tabular-nums">{{ config('company.experience_years') }}<span class="text-2xl text-hivis ml-1">ปี</span></div>
        <div class="mt-2 text-white/55">{{ config('company.experience_label') }}</div>
      </div>
      <div class="bg-navy-900 p-7">
        <div class="font-mono text-5xl font-bold tracking-tight tabular-nums">{{ config('company.projects_completed') }}<span class="text-2xl text-hivis ml-1">งาน</span></div>
        <div class="mt-2 text-white/55">รับเหมาก่อสร้างที่ส่งมอบเรียบร้อย ตั้งแต่ถมดินจนถึงกำแพงกันดิน</div>
      </div>
      <div class="bg-navy-900 p-7">
        <div class="font-mono text-5xl font-bold tracking-tight tabular-nums">0<span class="text-2xl text-hivis ml-1">งาน</span></div>
        <div class="mt-2 text-white/55">ที่เคยถูกทิ้ง — และเราตั้งใจรักษาสถิตินี้ตลอดไป</div>
      </div>
      <div class="bg-navy-900 p-7">
        <div class="font-mono text-5xl font-bold tracking-tight tabular-nums">100<span class="text-2xl text-hivis ml-1">%</span></div>
        <div class="mt-2 text-white/55">ประเมินราคาตามจริง ไม่มีค่าใช้จ่ายแอบแฝง</div>
      </div>
      <div class="bg-navy-900 p-7">
        <div class="font-mono text-5xl font-bold tracking-tight tabular-nums">1<span class="text-2xl text-hivis ml-1">ทีม</span></div>
        <div class="mt-2 text-white/55">ครบจบในที่เดียว ตั้งแต่ปรึกษา วางแผน จนส่งมอบงาน</div>
      </div>
    </div>
  </div>
</section>

<!-- ===== OUR STORY + TIMELINE ===== -->
<section class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
  <div class="grid lg:grid-cols-12 gap-12 lg:gap-20 items-start">
    <div class="lg:col-span-5 lg:sticky lg:top-28">
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
        <span class="w-7 h-px bg-accent"></span> เรื่องราวของเรา
      </span>
      <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">จากเด็กติดรถ สู่ผู้เชี่ยวชาญกำแพงกันดิน</h2>
      <p class="mt-5 text-[16px] text-ink2 leading-relaxed">ผมเกิดมาในครอบครัวที่ยากจน ชีวิตวัยเด็กไม่มีอะไรมาก... นอกจากความหลงใหลอย่างหนึ่ง — <strong>ทุกครั้งที่เห็นรถแบคโฮหรือรถเกรดทำงาน ผมจะยืนดูจนลืมเวลา</strong></p>
      <p class="mt-4 text-[16px] text-ink2 leading-relaxed">เพราะผมเริ่มจากศูนย์ คลุกคลีกับเครื่องจักรและหน้างานจริงมา {{ config('company.experience_years') }} ปี ผมจึงรู้ทันทุกปัญหาโครงสร้าง รู้ว่าตรงไหนมักถูกหมกเม็ด — และนั่นคือเหตุผลที่ผมกล้าการันตีว่า <strong class="text-navy-900">ปัญหาเหล่านั้นจะไม่เกิดขึ้นในบ้านของคุณ</strong></p>
      <div class="mt-8 flex items-center gap-4 p-5 rounded-2xl bg-surface border border-line">
        <!-- TODO: เปลี่ยนเป็นรูปถ่ายจริงของผู้ก่อตั้ง -->
        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=200&q=80&auto=format&fit=crop" alt="{{ config('company.founder_name') }}" class="w-14 h-14 rounded-xl object-cover shrink-0" />
        <div>
          <div class="font-bold text-navy-900">{{ config('company.founder_name') }}</div>
          <div class="text-[14px] text-muted mt-0.5">{{ config('company.founder_title') }} {{ config('company.name') }}</div>
          <div class="text-[13px] text-ink2 mt-1">"รับงานใครแล้ว งานต้องออกมาดี"</div>
        </div>
      </div>
    </div>

    <!-- Timeline: เส้นทางการเติบโต 4 ขั้น -->
    <div class="lg:col-span-7">
      <div class="relative pl-8 border-l-2 border-line space-y-0">

        <div class="relative pb-10">
          <span class="absolute -left-[calc(1rem+1px)] top-1 w-8 h-8 rounded-full bg-navy-900 text-white grid place-items-center text-sm font-bold ring-4 ring-white">1</span>
          <div class="ml-6">
            <div class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-3">จุดเริ่มต้น</div>
            <h3 class="text-xl font-bold text-navy-900"><i class="bi bi-wrench-adjustable text-accent mr-1.5"></i>เด็กติดรถ — จุดเริ่มต้นของความหลงใหล</h3>
            <p class="mt-2 text-[15px] text-ink2 leading-relaxed">ในขณะที่เด็กคนอื่นเล่นของเล่น ผมขอไปเป็น "เด็กติดรถ" คอยอัดจารบี เช็ดเครื่อง หยิบจับงานเล็ก ๆ น้อย ๆ ข้างเครื่องจักร มือเปื้อนน้ำมันทุกวัน แต่ใจพองโตทุกครั้งที่ได้อยู่ใกล้มัน — ที่นั่นเองที่ผมได้รู้จักเครื่องจักรทุกซอกทุกมุม ก่อนจะได้ขับมันจริงเสียอีก</p>
          </div>
        </div>

        <div class="relative pb-10">
          <span class="absolute -left-[calc(1rem+1px)] top-1 w-8 h-8 rounded-full bg-navy-900 text-white grid place-items-center text-sm font-bold ring-4 ring-white">2</span>
          <div class="ml-6">
            <div class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-3">จากคนดู สู่คนขับ</div>
            <h3 class="text-xl font-bold text-navy-900"><i class="bi bi-truck text-accent mr-1.5"></i>พนักงานควบคุมเครื่องจักร</h3>
            <p class="mt-2 text-[15px] text-ink2 leading-relaxed">พอโตถึงวัยที่จับคันโยกได้ ผมก็ได้เป็นพนักงานควบคุมเครื่องจักรเต็มตัว ขับแบคโฮและเครื่องจักรหนักทุกวัน จนชำนาญระดับ "ฟังเสียงเครื่องก็รู้ว่างานจะออกมาแบบไหน" และได้ทำงานก่อสร้างเคียงข้างช่างและผู้รับเหมาหลายปี เก็บวิชาแบบครูพักลักจำ — ดูของจริง ทำของจริง ผิดจริง แก้จริง</p>
          </div>
        </div>

        <div class="relative pb-10">
          <span class="absolute -left-[calc(1rem+1px)] top-1 w-8 h-8 rounded-full bg-navy-900 text-white grid place-items-center text-sm font-bold ring-4 ring-white">3</span>
          <div class="ml-6">
            <div class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-3">ก้าวแรกบนขาตัวเอง</div>
            <h3 class="text-xl font-bold text-navy-900"><i class="bi bi-cone-striped text-accent mr-1.5"></i>ผู้รับเหมารายเล็ก — ถมดิน เคลียริ่ง</h3>
            <p class="mt-2 text-[15px] text-ink2 leading-relaxed">เมื่อฝีมือถึง ผมออกมารับเหมาเอง เริ่มจากงานที่ถนัดที่สุด — งานถมดิน งานเคลียริ่งพื้นที่ ผมไม่ได้จบวิศวกรรม แต่เพราะเข้ากับคนง่าย จึงโชคดีได้เรียนรู้จากวิศวกรตัวจริงและผู้รับเหมารายใหญ่ ตั้งแต่เรื่องโครงสร้าง แรงดันดิน ไปจนถึงการประสานงานหน้างาน — รับงานยากขึ้นทีละขั้น ไม่รับงานที่ยังทำไม่เป็น แต่เมื่อรับแล้ว งานต้องออกมาดี</p>
          </div>
        </div>

        <div class="relative">
          <span class="absolute -left-[calc(1rem+1px)] top-1 w-8 h-8 rounded-full bg-hivis text-navy-900 grid place-items-center text-sm font-bold ring-4 ring-white"><i class="bi bi-flag-fill text-xs"></i></span>
          <div class="ml-6">
            <div class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-3">ปัจจุบัน</div>
            <h3 class="text-xl font-bold text-navy-900"><i class="bi bi-bricks text-accent mr-1.5"></i>ผู้เชี่ยวชาญกำแพงกันดิน ถมดิน และรั้ว</h3>
            <p class="mt-2 text-[15px] text-ink2 leading-relaxed">จากเด็กติดรถคนนั้น วันนี้คือ {{ config('company.legal_name') }} ผู้เชี่ยวชาญเฉพาะทางด้านงานกำแพงกันดิน งานถมดิน และงานรั้ว ด้วย {{ config('company.experience_label') }} {{ config('company.experience_years') }} ปี — ครบทุกมุม: รู้เครื่องจักร รู้หน้างาน รู้หลักวิศวกรรม และรู้ใจลูกค้า</p>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- ===== CORE VALUES: หลักการ 3 ข้อ ===== -->
<section class="bg-surface border-t border-line">
  <div class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
    <div class="max-w-2xl mb-12">
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> หลักการของเรา</span>
      <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">หลักการ 3 ข้อ ที่เราไม่เคยเปลี่ยน</h2>
      <p class="mt-4 text-lg text-ink2 leading-relaxed">หลักการเหล่านี้ไม่ได้เขียนขึ้นเพื่อการตลาด — แต่คือนิสัยของผู้ก่อตั้ง ที่กลายเป็นวัฒนธรรมของทีมทุกคน</p>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
      <div class="rounded-2xl border border-line bg-white p-7 hover:border-navy-900 hover:-translate-y-1 hover:shadow-2xl hover:shadow-navy-900/10 transition">
        <span class="grid place-items-center w-14 h-14 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><i class="bi bi-patch-check-fill"></i></span>
        <h3 class="text-xl font-bold text-navy-900">รับผิดชอบจนงานจบ — ไม่ทิ้งงานเด็ดขาด</h3>
        <p class="mt-2 text-[15px] text-ink2 leading-relaxed">เรารู้ดีว่าความกลัวอันดับหนึ่งของคนจ้างผู้รับเหมาคือ "กลัวโดนทิ้งงาน" ตลอด {{ config('company.experience_years') }} ปีที่ผ่านมา เราไม่เคยทิ้งงานแม้แต่งานเดียว ทุกโปรเจกต์มีการส่งมอบที่ชัดเจน ตรวจรับได้จริง</p>
      </div>
      <div class="rounded-2xl border border-line bg-white p-7 hover:border-navy-900 hover:-translate-y-1 hover:shadow-2xl hover:shadow-navy-900/10 transition">
        <span class="grid place-items-center w-14 h-14 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><i class="bi bi-chat-heart-fill"></i></span>
        <h3 class="text-xl font-bold text-navy-900">คุยง่าย เป็นกันเอง เหมือนญาติทำให้</h3>
        <p class="mt-2 text-[15px] text-ink2 leading-relaxed">โทรหาเราแล้วได้คุยกับคนที่รู้งานจริง ถามอะไรตอบตรง ๆ ด้วยภาษาชาวบ้าน ไม่ใช้ศัพท์ช่างมากดลูกค้า — เพราะเราเชื่อว่าลูกค้าต้องเข้าใจงานของตัวเอง ก่อนตัดสินใจจ่ายเงิน</p>
      </div>
      <div class="rounded-2xl border border-line bg-white p-7 hover:border-navy-900 hover:-translate-y-1 hover:shadow-2xl hover:shadow-navy-900/10 transition">
        <span class="grid place-items-center w-14 h-14 rounded-xl bg-accent/8 text-accent text-2xl mb-5"><i class="bi bi-shield-fill-check"></i></span>
        <h3 class="text-xl font-bold text-navy-900">ซื่อสัตย์ต่องาน — งานต้องออกมาดี</h3>
        <p class="mt-2 text-[15px] text-ink2 leading-relaxed">ประเมินราคาตามจริง วัสดุตรงสเปก ไม่มีค่าใช้จ่ายแอบแฝง เราดูแลงานของลูกค้าเสมือนบ้านของเราเอง — เพราะบ้านทุกหลังคือเงินเก็บและความฝันของคนคนหนึ่ง</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== FOUNDER (คำจากผู้ก่อตั้ง) ===== -->
<section class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
  <div class="max-w-2xl mb-12">
    <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> คำจากผู้ก่อตั้ง</span>
    <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">คนที่อยู่เบื้องหลังทุกงานของเรา</h2>
  </div>

  <div class="rounded-2xl border border-line bg-white overflow-hidden">
    <div class="grid lg:grid-cols-5 gap-0">
      <div class="lg:col-span-2 relative aspect-4/3 lg:aspect-auto overflow-hidden">
        <!-- TODO: เปลี่ยนเป็นรูปจริงของผู้ก่อตั้ง (ถ้ามีรูปเก่าสมัยขับแบคโฮ + รูปปัจจุบัน จะทรงพลังมาก) -->
        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=900&q=80&auto=format&fit=crop" alt="{{ config('company.founder_name') }}" class="absolute inset-0 w-full h-full object-cover" />
      </div>
      <div class="lg:col-span-3 p-8 lg:p-10 flex flex-col justify-center">
        <span class="inline-block rounded-full bg-hivis/15 text-accent text-xs font-bold tracking-widest px-3 py-1 mb-4 self-start">{{ config('company.founder_title') }}</span>
        <h3 class="text-3xl font-bold text-navy-900">{{ config('company.founder_name') }}</h3>
        <div class="mt-1 text-muted font-medium">{{ config('company.founder_title') }} {{ config('company.name') }} · {{ config('company.experience_label') }} {{ config('company.experience_years') }} ปี</div>
        <p class="mt-5 text-[16px] text-ink2 leading-relaxed max-w-xl">"ผมเริ่มจากศูนย์ ไม่มีทุน ไม่มีเส้นสาย — แต่มีประสบการณ์หน้างานจริงที่ทำให้ผมรู้ว่า <strong>ลูกค้ากลัวอะไรที่สุด: โดนทิ้งงาน โดนบวกราคา โดนหมกเม็ด</strong> ทุกวันนี้ผมยังยึดว่า <strong>รับงานใครแล้ว งานต้องออกมาดี</strong> เพราะชื่อ 'ธีรพงษ์' คือชื่อที่ผมต้องรับผิดชอบด้วยชีวิตการทำงานทั้งหมด — และบ้านของคุณก็ไม่ต่างจากบ้านของผมเอง"</p>
        <div class="mt-6 flex flex-wrap gap-2.5">
          <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[14px] text-ink2"><i class="bi bi-gear-wide-connected text-accent"></i> เริ่มจากเด็กติดรถ สู่ผู้ควบคุมเครื่องจักร</span>
          <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[14px] text-ink2"><i class="bi bi-mortarboard-fill text-accent"></i> เรียนรู้จากวิศวกรและผู้รับเหมาใหญ่</span>
          <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[14px] text-ink2"><i class="bi bi-buildings-fill text-accent"></i> รับเหมา {{ config('company.projects_completed') }} งาน</span>
          <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-2 text-[14px] text-ink2"><i class="bi bi-patch-check-fill text-accent"></i> ไม่เคยทิ้งงาน</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== EXPERTISE (ความเชี่ยวชาญของเราวันนี้) ===== -->
<section class="bg-navy-900 text-white">
  <div class="mx-auto max-w-7xl px-6 py-20 lg:py-24">
    <div class="grid lg:grid-cols-12 gap-12 items-center">
      <div class="lg:col-span-5">
        <span class="inline-flex items-center gap-2 text-hivis font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-hivis"></span> ความเชี่ยวชาญของเรา</span>
        <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight leading-tight">รู้เครื่องจักร รู้หน้างาน รู้หลักวิศวกรรม</h2>
        <p class="mt-5 text-lg text-white/60 leading-relaxed">จากงานถมดินในวันแรก สู่ความเชี่ยวชาญเฉพาะทาง — บริการแบบ One-Stop Service ตั้งแต่ปรึกษา วางแผน ประเมินราคา จนถึงส่งมอบงานสมบูรณ์</p>
        <a href="{{ route('frontend.services.index') }}" class="mt-7 inline-flex items-center gap-2 rounded-xl bg-hivis px-7 py-3.5 font-semibold text-navy-900 hover:bg-white transition">ดูบริการทั้งหมด <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="lg:col-span-7 grid sm:grid-cols-2 gap-4">
        <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-6 hover:bg-white/10 transition">
          <span class="grid place-items-center w-12 h-12 rounded-xl bg-hivis/15 text-hivis text-2xl mb-4"><i class="bi bi-bricks"></i></span>
          <div class="text-[13px] font-semibold text-hivis uppercase tracking-wide">แก้ปัญหา</div>
          <div class="mt-1 font-bold text-white">จบปัญหาดินสไลด์ · กำแพงทรุด · ตามแก้ไม่รู้จบ</div>
          <div class="mt-2 text-[14px] text-white/55">ด้วยการคำนวณแรงดันดินตามหลักวิศวกรรม วัสดุตรงสเปก และทีมที่คลุกคลีกับหน้างานจริงมา {{ config('company.experience_years') }} ปี</div>
        </div>
        <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-6 hover:bg-white/10 transition">
          <span class="grid place-items-center w-12 h-12 rounded-xl bg-hivis/15 text-hivis text-2xl mb-4"><i class="bi bi-columns-gap"></i></span>
          <div class="text-[13px] font-semibold text-hivis uppercase tracking-wide">แก้ปัญหา</div>
          <div class="mt-1 font-bold text-white">รั้วเอียง · ร้าว · เก็บงานไม่เรียบ</div>
          <div class="mt-2 text-[14px] text-white/55">รั้วสำเร็จรูปและรั้วก่อฉาบแข็งแรงตามหลักโครงสร้าง สวยลงตัวกับพื้นที่ เก็บงานเรียบทุกจุดเชื่อมต่อ</div>
        </div>
        <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-6 hover:bg-white/10 transition">
          <span class="grid place-items-center w-12 h-12 rounded-xl bg-hivis/15 text-hivis text-2xl mb-4"><i class="bi bi-truck"></i></span>
          <div class="text-[13px] font-semibold text-hivis uppercase tracking-wide">แก้ปัญหา</div>
          <div class="mt-1 font-bold text-white">พื้นที่ไม่เรียบ · น้ำขัง · ถมไม่แน่น</div>
          <div class="mt-2 text-[14px] text-white/55">งานถมดิน เคลียริ่ง เทพื้นคอนกรีต — เครื่องจักรและคนขับชำนาญจริง งานเล็กหรือใหญ่ก็รับ ไม่ทิ้งกลางคัน</div>
        </div>
        <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-6 hover:bg-white/10 transition">
          <span class="grid place-items-center w-12 h-12 rounded-xl bg-hivis/15 text-hivis text-2xl mb-4"><i class="bi bi-lightning-charge-fill"></i></span>
          <div class="text-[13px] font-semibold text-hivis uppercase tracking-wide">แก้ปัญหา</div>
          <div class="mt-1 font-bold text-white">จ้างหลายทีมแล้วโยนความผิดกันไปมา</div>
          <div class="mt-2 text-[14px] text-white/55">งานระบบไฟฟ้า ไฟเบอร์ LAN CCTV ครบจบในทีมเดียว ไม่ต้องประสานหลายเจ้า ไม่ปวดหัวเรื่องใครรับผิดชอบ</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== TESTIMONIALS (ใส่รีวิวจริงเท่านั้น) ===== -->
<section class="bg-surface border-t border-line">
  <div class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
    <div class="text-center max-w-2xl mx-auto mb-12">
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> เสียงจากลูกค้าจริง</span>
      <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ลูกค้าที่เคยกลัวเหมือนคุณ — แล้วเลือกไว้ใจเรา</h2>
      <p class="mt-3 text-[15px] text-ink2">รีวิวที่เน้นเรื่องที่ลูกค้ากังวลจริง: ราคาโปร่งใส ไม่ทิ้งงาน ไม่บวกเพิ่ม</p>
    </div>
    {{-- ใส่รีวิวจริงจากลูกค้าจริงเท่านั้น — ขออนุญาตก่อนนำมาลง --}}
    <div class="grid md:grid-cols-3 gap-5">
      <figure class="rounded-2xl bg-white ring-1 ring-line p-7 flex flex-col">
        <div class="text-hivis text-[15px] mb-4"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
        <span class="inline-block self-start rounded-full bg-accent/8 text-accent text-[11px] font-bold tracking-wide px-2.5 py-1 mb-3">เรื่องราคา · ไม่บวกเพิ่ม</span>
        <blockquote class="text-ink leading-relaxed flex-1">"ประทับใจที่แจกแจง BOQ ละเอียดมาก จบงานแล้วไม่มีบวกเพิ่มซักบาทเดียว สบายใจมากครับ"</blockquote>
        <figcaption class="mt-5 flex items-center gap-3">
          <span class="grid place-items-center w-10 h-10 rounded-full bg-surface text-navy-900 font-bold">ส</span>
          <span><span class="block font-semibold text-navy-900 text-[15px]">[ชื่อลูกค้า]</span><span class="block text-[13px] text-muted">กำแพงกันดิน · [พื้นที่]</span></span>
        </figcaption>
      </figure>
      <figure class="rounded-2xl bg-white ring-1 ring-line p-7 flex flex-col">
        <div class="text-hivis text-[15px] mb-4"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
        <span class="inline-block self-start rounded-full bg-accent/8 text-accent text-[11px] font-bold tracking-wide px-2.5 py-1 mb-3">เรื่องไม่ทิ้งงาน</span>
        <blockquote class="text-ink leading-relaxed flex-1">"เคยโดนช่างเก่าทิ้งงานกำแพงจนทรุด ได้ทีมธีรพงษ์มาช่วยแก้ งานจบไว ตรงสเปก ไม่ทิ้งงานจริงๆ"</blockquote>
        <figcaption class="mt-5 flex items-center gap-3">
          <span class="grid place-items-center w-10 h-10 rounded-full bg-surface text-navy-900 font-bold">ว</span>
          <span><span class="block font-semibold text-navy-900 text-[15px]">[ชื่อลูกค้า]</span><span class="block text-[13px] text-muted">แก้ไขกำแพงทรุด · [พื้นที่]</span></span>
        </figcaption>
      </figure>
      <figure class="rounded-2xl bg-white ring-1 ring-line p-7 flex flex-col">
        <div class="text-hivis text-[15px] mb-4"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
        <span class="inline-block self-start rounded-full bg-accent/8 text-accent text-[11px] font-bold tracking-wide px-2.5 py-1 mb-3">เรื่องโปร่งใส · ตอบตรง</span>
        <blockquote class="text-ink leading-relaxed flex-1">"โทรถามอะไรตอบตรงๆ ไม่กดดันให้ตัดสินใจ ส่งรูปไปประเมินเบื้องต้นฟรีจริง ไม่มีค่าใช้จ่ายแอบแฝงเลยค่ะ"</blockquote>
        <figcaption class="mt-5 flex items-center gap-3">
          <span class="grid place-items-center w-10 h-10 rounded-full bg-surface text-navy-900 font-bold">ก</span>
          <span><span class="block font-semibold text-navy-900 text-[15px]">[ชื่อลูกค้า]</span><span class="block text-[13px] text-muted">งานรั้ว · [พื้นที่]</span></span>
        </figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ===== CTA ===== -->
<section class="bg-navy-900 text-white">
  <div class="mx-auto max-w-7xl px-6 py-14 lg:py-16 flex flex-col lg:flex-row items-center justify-between gap-8">
    <div>
      <h2 class="text-2xl lg:text-3xl font-bold tracking-tight">อยากได้ผู้รับเหมาที่รู้งานจริง คุยง่าย และไม่ทิ้งงาน?</h2>
      <p class="mt-2 text-white/60 text-lg">ส่งรูปหน้างานมาให้ดู เราประเมินเบื้องต้นให้ฟรี ไม่มีค่าใช้จ่าย ไม่ผูกมัด</p>
    </div>
    <div class="shrink-0">
      <div class="flex flex-wrap gap-3">
        <a href="{{ config('company.line_official') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-xl bg-hivis px-7 py-3.5 font-semibold text-navy-900 hover:bg-white transition"><i class="bi bi-line"></i> ทัก LINE Official ส่งรูปหน้างาน</a>
        <a href="tel:{{ config('company.phone') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/25 px-7 py-3.5 font-semibold text-white hover:bg-white/10 transition"><i class="bi bi-telephone-fill"></i> โทร {{ config('company.phone_formatted') }}</a>
      </div>
      <p class="mt-2.5 text-sm text-white/45 text-center lg:text-right"><i class="bi bi-shield-check text-hivis mr-1"></i>ประเมินฟรี · ไม่มีค่าใช้จ่าย · ไม่ผูกมัด</p>
    </div>
  </div>
</section>
@endsection