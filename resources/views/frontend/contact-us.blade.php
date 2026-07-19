@extends('layouts.frontend')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-b from-surface to-white">
  <div class="pointer-events-none absolute -top-24 right-0 h-[480px] w-[480px] rounded-full bg-accent/10 blur-3xl"></div>
  <div class="relative mx-auto max-w-7xl px-4 sm:px-6 py-16 lg:py-24">
    <div class="max-w-2xl">
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
        <span class="w-7 h-px bg-accent"></span> ติดต่อเรา
      </span>
      <h1 class="mt-5 text-[clamp(2.2rem,4.2vw,3.6rem)] font-bold leading-[1.3] tracking-tight text-navy-900">
        พร้อมช่วยคุณ<span class="bg-gradient-to-t from-hivis/60 from-[28%] to-transparent to-[28%]">เริ่มต้นทุกโครงการ</span>
      </h1>
      <p class="mt-5 text-lg leading-relaxed text-ink2 max-w-xl">
        ทีมงานพร้อมตอบทุกคำถาม ให้คำปรึกษา และสำรวจหน้างานฟรีภายใน 3 วันทำการ — ไม่มีค่าใช้จ่ายใดๆ
      </p>
      <div class="mt-7 flex flex-wrap gap-x-8 gap-y-3 text-[15px] text-ink2">
        <span><x-icon name="check-circle-fill" class="text-accent mr-1.5 inline-block" /> ตอบกลับภายใน 24 ชั่วโมง</span>
        <span><x-icon name="check-circle-fill" class="text-accent mr-1.5 inline-block" /> สำรวจหน้างานฟรี</span>
        <span><x-icon name="check-circle-fill" class="text-accent mr-1.5 inline-block" /> ใบเสนอราคาไม่มีข้อผูกมัด</span>
      </div>
    </div>
  </div>
</section>

<!-- ======== INFO STRIP ======== -->
<div class="border-y border-line bg-white">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 py-6 grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <div class="flex items-start gap-4 min-w-0">
      <span class="grid place-items-center w-11 h-11 rounded-xl bg-accent/8 text-accent text-xl shrink-0"><x-icon name="telephone-fill" /></span>
      <div class="min-w-0">
        <div class="text-[13px] font-medium text-muted uppercase tracking-wide">โทรศัพท์</div>
        <a href="tel:{{ config('company.phone') }}" class="mt-0.5 block font-mono font-semibold text-navy-900 tabular-nums text-lg hover:text-accent transition">{{ config('company.phone_formatted') }}</a>
      </div>
    </div>
    <div class="flex items-start gap-4 min-w-0">
      <span class="grid place-items-center w-11 h-11 rounded-xl bg-accent/8 text-accent text-xl shrink-0"><x-icon name="envelope-fill" /></span>
      <div class="min-w-0">
        <div class="text-[13px] font-medium text-muted uppercase tracking-wide">อีเมล</div>
        <a href="mailto:{{ config('company.email') }}" class="mt-0.5 block font-medium text-navy-900 hover:text-accent transition break-all">{{ config('company.email') }}</a>
      </div>
    </div>
    <div class="flex items-start gap-4 min-w-0">
      <span class="grid place-items-center w-11 h-11 rounded-xl bg-accent/8 text-accent text-xl shrink-0"><x-icon name="geo-alt-fill" /></span>
      <div class="min-w-0">
        <div class="text-[13px] font-medium text-muted uppercase tracking-wide">สำนักงาน</div>
        <div class="mt-0.5 font-medium text-navy-900 text-[15px]">{{ config('company.address') }}</div>
      </div>
    </div>
    <div class="flex items-start gap-4 min-w-0">
      <span class="grid place-items-center w-11 h-11 rounded-xl bg-accent/8 text-accent text-xl shrink-0"><x-icon name="clock-fill" /></span>
      <div class="min-w-0">
        <div class="text-[13px] font-medium text-muted uppercase tracking-wide">เวลาทำการ</div>
        <div class="mt-0.5 font-medium text-navy-900 text-[15px]">{{ config('company.open_hours') }}</div>
      </div>
    </div>
  </div>
</div>


<!-- ======== MAP + COMPANY INFO ======== -->
<section class="bg-surface border-t border-line overflow-x-hidden">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28">
    <div class="grid lg:grid-cols-12 gap-12 min-w-0">
      <!-- Map -->
      <div class="lg:col-span-7 min-w-0 w-full max-w-full overflow-hidden">
        <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase mb-5">
          <span class="w-7 h-px bg-accent"></span> แผนที่
        </span>
        <div class="map-embed rounded-2xl border border-line shadow-xl shadow-navy-900/5">
            <iframe
              title="แผนที่สำนักงาน{{ config('company.brand') }}"
              src="{{ config('company.map_url') }}"
              width="600" height="375"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          <div class="absolute inset-x-3 bottom-3 z-10 sm:inset-x-4 sm:bottom-4 flex items-center gap-3 rounded-xl bg-white/95 backdrop-blur px-3 py-2.5 sm:px-4 sm:py-3 shadow-xl pointer-events-none min-w-0 max-w-[calc(100%-1.5rem)] sm:max-w-[calc(100%-2rem)]">
            <span class="grid place-items-center w-9 h-9 rounded-lg bg-navy-900 text-white text-base shrink-0"><x-icon name="geo-alt-fill" /></span>
            <div class="min-w-0">
              <div class="font-bold text-navy-900 text-[14px]">สำนักงานใหญ่</div>
              <div class="text-[12px] text-muted line-clamp-2">{{ config('company.address') }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Company info -->
      <div class="lg:col-span-5 min-w-0">
        <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase mb-5">
          <span class="w-7 h-px bg-accent"></span> ข้อมูลบริษัท
        </span>
        <h2 class="text-3xl font-bold tracking-tight text-navy-900 leading-tight">{{ config('company.brand') }}</h2>
        <p class="mt-3 text-[15px] text-ink2 leading-relaxed">รับเหมาก่อสร้างครบวงจร — กำแพงกันดิน รั้ว ถนน ลานคอนกรีต และงานปรับพื้นที่ ในเขตกรุงเทพฯ และปริมณฑล {{ config('company.experience_label') }} {{ config('company.experience_years') }} ปี</p>
        <ul class="mt-7 space-y-5">
          <li class="flex gap-4 items-start min-w-0">
            <span class="grid place-items-center w-11 h-11 rounded-xl bg-white border border-line text-accent text-xl shrink-0"><x-icon name="geo-alt-fill" /></span>
            <div class="min-w-0">
              <div class="font-semibold text-navy-900">ที่อยู่สำนักงาน</div>
              <div class="mt-0.5 text-[15px] text-ink2">{{ config('company.address') }}</div>
            </div>
          </li>
          <li class="flex gap-4 items-start min-w-0">
            <span class="grid place-items-center w-11 h-11 rounded-xl bg-white border border-line text-accent text-xl shrink-0"><x-icon name="telephone-fill" /></span>
            <div class="min-w-0">
              <div class="font-semibold text-navy-900">โทรศัพท์</div>
              <a href="tel:{{ config('company.phone') }}" class="mt-0.5 block font-mono tabular-nums text-lg font-semibold text-navy-900 hover:text-accent transition">{{ config('company.phone_formatted') }}</a>
            </div>
          </li>
          <li class="flex gap-4 items-start min-w-0">
            <span class="grid place-items-center w-11 h-11 rounded-xl bg-white border border-line text-accent text-xl shrink-0"><x-icon name="envelope-fill" /></span>
            <div class="min-w-0">
              <div class="font-semibold text-navy-900">อีเมล</div>
              <a href="mailto:{{ config('company.email') }}" class="mt-0.5 block text-[15px] font-medium text-navy-900 hover:text-accent transition break-all">{{ config('company.email') }}</a>
            </div>
          </li>
          <li class="flex gap-4 items-start min-w-0">
            <span class="grid place-items-center w-11 h-11 rounded-xl bg-white border border-line text-accent text-xl shrink-0"><x-icon name="clock-fill" /></span>
            <div class="min-w-0">
              <div class="font-semibold text-navy-900">เวลาทำการ</div>
              <div class="mt-0.5 text-[15px] text-ink2">{{ config('company.open_hours') }}</div>
            </div>
          </li>
        </ul>
        <div class="mt-7 flex flex-wrap gap-2.5">
          <a href="{{ config('company.facebook') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-navy-900 px-4 py-2.5 text-[14px] font-semibold text-white hover:bg-accent transition"><x-icon name="facebook" /> Facebook</a>
          <a href="{{ config('company.line_official') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-navy-900 px-4 py-2.5 text-[14px] font-semibold text-white hover:bg-accent transition"><x-icon name="line" /> {{ config('company.line_official_name') }}</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ======== CTA BANNER ======== -->
<section class="bg-navy-900 text-white">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 py-14 lg:py-16 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
    <div class="min-w-0">
      <h2 class="lg:text-3xl font-bold tracking-tight">ยังมีข้อสงสัย? โทรหาเราได้เลย</h2>
      <p class="mt-2 text-white/60 text-lg">ทีมงานพร้อมให้คำปรึกษาโดยไม่มีค่าใช้จ่าย {{ config('company.open_hours') }}</p>
    </div>
    <div class="flex flex-wrap gap-3 w-full sm:w-auto">
      <a href="tel:{{ config('company.phone') }}" class="inline-flex items-center gap-2 rounded-xl bg-hivis px-7 py-3.5 font-semibold text-navy-900 hover:bg-white transition">
        <x-icon name="telephone-fill" /> {{ config('company.phone_formatted') }}
      </a>
      <a href="#contact" class="inline-flex items-center gap-2 rounded-xl border border-white/25 px-7 py-3.5 font-semibold text-white hover:bg-white/10 transition">
        ส่งข้อความ <x-icon name="arrow-right" />
      </a>
    </div>
  </div>
</section>
@endsection
