<section class="relative overflow-hidden bg-navy-900 text-white">
  <div class="pointer-events-none absolute -top-32 right-0 h-[500px] w-[500px] rounded-full bg-accent/40 blur-3xl opacity-50"></div>
  <div class="relative mx-auto max-w-7xl px-4 sm:px-6 py-16 lg:py-20">
    <div class="max-w-3xl">
      <span class="inline-flex items-center gap-2 text-hivis font-semibold tracking-[0.18em] text-xs uppercase">
        <span class="w-7 h-px bg-hivis"></span> {{ $eyebrow }}
      </span>
      <h1 class="mt-4 text-[clamp(2rem,4vw,3.2rem)] font-bold leading-[1.3] tracking-tight">{!! $title !!}</h1>
      <p class="mt-4 text-lg text-white/65 leading-relaxed max-w-2xl">{{ $description }}</p>
    </div>
    @if ($badges)
      <div class="mt-10 flex flex-wrap gap-3">
        @foreach ($badges as $badge)
          <span class="inline-flex items-center gap-2 rounded-full bg-white/10 ring-1 ring-white/20 px-4 py-2 text-[14px]">
            <x-icon:name="$badge['icon']" class="text-hivis" /> {{ $badge['text'] }}
          </span>
        @endforeach
      </div>
    @endif
  </div>
</section>
