@props(['projects', 'totalProjects' => null])

@php
    $totalProjects = $totalProjects ?? count($projects);
@endphp

<section id="galleries" class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> คลังผลงาน</span>
            <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ภาพงานจริงจากหน้างานทั่วประเทศ</h2>
            <p class="mt-4 text-lg text-ink2">ตัวอย่างผลงานก่อสร้างจริงในแต่ละพื้นที่ — ภาพแรกของแต่ละหน้างานจากคลังผลงานของเรา</p>
        </div>

        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($projects as $project)
                <a href="{{ route('frontend.galleries.show', $project['slug']) }}"
                   class="group relative block aspect-4/3 overflow-hidden rounded-2xl ring-1 ring-line transition duration-300">
                    <img src="{{ $project['image'] }}" alt="{{ $project['alt'] }}" loading="lazy"
                         class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-950/85 via-navy-950/15 to-transparent"></div>
                    <div class="absolute inset-0 p-5 flex flex-col justify-end text-white">
                        <span class="self-start rounded-full bg-white/20 backdrop-blur px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide">{{ $project['category'] }}</span>
                        <h3 class="mt-2.5 text-lg font-bold">{{ $project['title'] }}</h3>
                        @if ($project['specs'])
                            <p class="text-[13px] text-white/75 line-clamp-2">{{ $project['specs'] }}</p>
                        @endif
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-muted py-12">ยังไม่มีภาพในคลังผลงาน</p>
            @endforelse
        </div>

        @if ($totalProjects > count($projects))
            <div class="mt-10 text-center">
                <a href="{{ route('frontend.galleries.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-navy-900 px-6 py-3.5 font-semibold text-navy-900 hover:bg-navy-900 hover:text-white transition">
                    เพิ่มเติม ({{ $totalProjects }}) <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>
</section>
