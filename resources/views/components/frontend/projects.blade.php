@props(['blogs', 'totalProjects' => null])

@php
    $fallbackImage = 'https://images.unsplash.com/photo-1517089596392-fb9a9033e05b?w=900&q=80&auto=format&fit=crop';
    $totalProjects = $totalProjects ?? $blogs->count();
@endphp

<section id="projects" class="bg-surface">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> ผลงานที่ผ่านมา</span>
            <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ผลงานก่อสร้างจริง — ลูกค้าจริง พื้นที่จริง</h2>
            <p class="mt-4 text-lg text-ink2">ตัวอย่างงานก่อสร้างที่เราดำเนินการให้ลูกค้าจริงในพื้นที่กรุงเทพฯ และปริมณฑล</p>
        </div>

        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($blogs as $blog)
                <a href="{{ route('blog.show', $blog->slug) }}"
                   class="group relative block aspect-4/3 overflow-hidden rounded-2xl ring-1 ring-line transition duration-300">
                    @if ($blog->cover_image)
                        @if (str_starts_with($blog->cover_image, 'http'))
                            <img src="{{ $blog->cover_image }}" alt="{{ $blog->title }}" loading="lazy"
                                 width="900" height="675"
                                 class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <img src="{{ Storage::disk('s3')->url($blog->cover_image) }}?width=900&format=webp&fit=cover"
                                 alt="{{ $blog->title }}" loading="lazy" width="900" height="675"
                                 class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        @endif
                    @else
                        <img src="{{ $fallbackImage }}" alt="{{ $blog->title }}" loading="lazy"
                             width="900" height="675"
                             class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition duration-500">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-950/85 via-navy-950/15 to-transparent"></div>
                    <div class="absolute inset-0 p-5 flex flex-col justify-end text-white">
                        <span class="self-start rounded-full bg-white/20 backdrop-blur px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide">{{ $blog->service->title }}</span>
                        <h3 class="mt-2.5 text-lg font-bold">{{ $blog->title }}</h3>
                        <p class="text-[13px] text-white/75 line-clamp-2">{{ $blog->description }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-muted py-12">ยังไม่มีบทความผลงาน</p>
            @endforelse
        </div>

        @if ($totalProjects > $blogs->count())
            <div class="mt-10 text-center">
                <a href="{{ route('blog.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-navy-900 px-6 py-3.5 font-semibold text-navy-900 hover:bg-navy-900 hover:text-white transition">
                    เพิ่มเติม ({{ $totalProjects }}) <x-icon name="arrow-right" />
                </a>
            </div>
        @endif
    </div>
</section>
