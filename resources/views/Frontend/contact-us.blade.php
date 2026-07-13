@extends('layouts.frontend')

@section('content')
    <!-- ======== PAGE HERO ======== -->
<section class="relative overflow-hidden bg-gradient-to-b from-surface to-white">
  <div class="pointer-events-none absolute -top-24 right-0 h-[480px] w-[480px] rounded-full bg-accent/10 blur-3xl"></div>
  <div class="relative mx-auto max-w-7xl px-6 py-16 lg:py-24">
    <div class="max-w-2xl">
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase">
        <span class="w-7 h-px bg-accent"></span> ติดต่อเรา
      </span>
      <h1 class="mt-5 text-[clamp(2.2rem,4.2vw,3.6rem)] font-bold leading-[1.3] tracking-tight text-navy-900">
      ปรึกษางานช่างฟรี คุยกับตัวจริง<span class="bg-gradient-to-t from-hivis/60 from-[28%] to-transparent to-[28%]">ไม่มีข้อผูกมัด</span>
      </h1>
      <p class="mt-5 text-lg leading-relaxed text-ink2 max-w-xl">
      บริษัท ธีรพงษ์ เซอร์วิส จำกัด จดทะเบียนนิติบุคคลถูกต้องตามกฎหมาย พร้อมให้คำแนะนำอย่างตรงไปตรงมา ประเมินราคาตามหน้างานจริง ไม่หมกเม็ด
      </p>
      <div class="mt-7 flex flex-wrap gap-x-8 gap-y-3 text-[15px] text-ink2">
        <span><i class="bi bi-check-circle-fill text-accent mr-1.5"></i> ตอบกลับภายใน 24 ชั่วโมง</span>
        <span><i class="bi bi-check-circle-fill text-accent mr-1.5"></i> สำรวจหน้างานฟรี</span>
        <span><i class="bi bi-check-circle-fill text-accent mr-1.5"></i> ใบเสนอราคาไม่มีข้อผูกมัด</span>
      </div>
    </div>
  </div>
</section>

<!-- ======== INFO STRIP ======== -->
<div class="border-y border-line bg-white">
  <div class="mx-auto max-w-7xl px-6 py-6 grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <div class="flex items-start gap-4">
      <span class="grid place-items-center w-11 h-11 rounded-xl bg-accent/8 text-accent text-xl shrink-0"><i class="bi bi-telephone-fill"></i></span>
      <div>
        <div class="text-[13px] font-medium text-muted uppercase tracking-wide">โทรศัพท์</div>
        <a href="tel:{{ config('company.phone_formatted') }}" class="mt-0.5 block font-mono font-semibold text-navy-900 tabular-nums text-lg hover:text-accent transition">{{ config('company.phone_formatted') }}</a>
      </div>
    </div>
    <div class="flex items-start gap-4">
      <span class="grid place-items-center w-11 h-11 rounded-xl bg-accent/8 text-accent text-xl shrink-0"><i class="bi bi-envelope-fill"></i></span>
      <div>
        <div class="text-[13px] font-medium text-muted uppercase tracking-wide">อีเมล</div>
        <a href="mailto:{{ config('company.email') }}" class="mt-0.5 block font-medium text-navy-900 hover:text-accent transition">{{ config('company.email') }}</a>
      </div>
    </div>
    <div class="flex items-start gap-4">
      <span class="grid place-items-center w-11 h-11 rounded-xl bg-accent/8 text-accent text-xl shrink-0"><i class="bi bi-geo-alt-fill"></i></span>
      <div>
        <div class="text-[13px] font-medium text-muted uppercase tracking-wide">สำนักงาน</div>
        <div class="mt-0.5 font-medium text-navy-900 text-[15px]">{{ config('company.address') }}</div>
      </div>
    </div>
    <div class="flex items-start gap-4">
      <span class="grid place-items-center w-11 h-11 rounded-xl bg-accent/8 text-accent text-xl shrink-0"><i class="bi bi-clock-fill"></i></span>
      <div>
        <div class="text-[13px] font-medium text-muted uppercase tracking-wide">เวลาทำการ</div>
        <div class="mt-0.5 font-medium text-navy-900 text-[15px]">{{ config('company.open_hours') }}</div>
      </div>
    </div>
  </div>

  <section class="bg-surface border-t border-line">
  <div class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
    <div class="grid lg:grid-cols-12 gap-12">
      <!-- Map -->
      <div class="lg:col-span-7">
        <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase mb-5">
          <span class="w-7 h-px bg-accent"></span> แผนที่
        </span>
        <div class="relative rounded-2xl overflow-hidden border border-line shadow-xl shadow-navy-900/5" style="aspect-ratio:16/10; min-height:360px;">
          <iframe
            title="แผนที่ {{config('company.name')}}"
            src="{{ config('company.map_url') }}"
            style="border:0; width:100%; height:100%; position:absolute; inset:0;"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
          <div class="absolute left-4 bottom-4 flex items-center gap-3 rounded-xl bg-white/95 backdrop-blur px-4 py-3 shadow-xl pointer-events-none">
            <span class="grid place-items-center w-9 h-9 rounded-lg bg-navy-900 text-white text-base shrink-0"><i class="bi bi-geo-alt-fill"></i></span>
            <div>
              <div class="font-bold text-navy-900 text-[14px]">สำนักงานใหญ่</div>
              <div class="text-[12px] text-muted">{{config('company.address')}}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Company info -->
      <div class="lg:col-span-5">
        <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase mb-5">
          <span class="w-7 h-px bg-accent"></span> ข้อมูลบริษัท
        </span>
        <h2 class="text-3xl font-bold tracking-tight text-navy-900 leading-tight">{{config('company.name')}}</h2>
        <p class="mt-3 text-[15px] text-ink2 leading-relaxed">รับเหมาก่อสร้างครบวงจร — กำแพงกันดิน รั้ว ถนน ลานคอนกรีต และงานปรับพื้นที่ ในเขตกรุงเทพฯ และปริมณฑล ประสบการณ์ 18 ปี</p>
        <ul class="mt-7 space-y-5">
          <li class="flex gap-4 items-start">
            <span class="grid place-items-center w-11 h-11 rounded-xl bg-white border border-line text-accent text-xl shrink-0"><i class="bi bi-geo-alt-fill"></i></span>
            <div>
              <div class="font-semibold text-navy-900">ที่อยู่สำนักงาน</div>
              <div class="mt-0.5 text-[15px] text-ink2">{{config('company.address')}}</div>
            </div>
          </li>
          <li class="flex gap-4 items-start">
            <span class="grid place-items-center w-11 h-11 rounded-xl bg-white border border-line text-accent text-xl shrink-0"><i class="bi bi-telephone-fill"></i></span>
            <div>
              <div class="font-semibold text-navy-900">โทรศัพท์</div>
              <a href="tel:{{config('company.phone')}}" class="mt-0.5 block font-mono tabular-nums text-lg font-semibold text-navy-900 hover:text-accent transition">{{config('company.phone_formatted')}}</a>
            </div>
          </li>
          <li class="flex gap-4 items-start">
            <span class="grid place-items-center w-11 h-11 rounded-xl bg-white border border-line text-accent text-xl shrink-0"><i class="bi bi-envelope-fill"></i></span>
            <div>
              <div class="font-semibold text-navy-900">อีเมล</div>
              <a href="mailto:{{config('company.email')}}" class="mt-0.5 block text-[15px] font-medium text-navy-900 hover:text-accent transition">{{config('company.email')}}</a>
            </div>
          </li>
          <li class="flex gap-4 items-start">
            <span class="grid place-items-center w-11 h-11 rounded-xl bg-white border border-line text-accent text-xl shrink-0"><i class="bi bi-clock-fill"></i></span>
            <div>
              <div class="font-semibold text-navy-900">เวลาทำการ</div>
              <div class="mt-1.5 text-[15px] text-ink2 space-y-1">
                <div class="flex justify-between gap-8"><span class="text-muted">{{config('company.open_hours')}}</span></div>
              </div>
            </div>
          </li>
        </ul>
        <div class="mt-7 flex gap-2.5">
          <a href="{{ config('company.facebook') }}" class="inline-flex items-center gap-2 rounded-full bg-navy-900 px-4 py-2.5 text-[14px] font-semibold text-white hover:bg-accent transition"><i class="bi bi-facebook"></i> Facebook</a>
          <a href="#" class="inline-flex items-center gap-2 rounded-full bg-navy-900 px-4 py-2.5 text-[14px] font-semibold text-white hover:bg-accent transition"><i class="bi bi-line"></i> @theeraphong</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection