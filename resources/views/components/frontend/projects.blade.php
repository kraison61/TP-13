@props(['blogs', 'filterServices'])

@php
    $fallbackImage = 'https://images.unsplash.com/photo-1517089596392-fb9a9033e05b?w=900&q=80&auto=format&fit=crop';
    $allLabel = config('frontend.filter_labels.all', 'ทั้งหมด');
@endphp

<section id="projects" class="bg-surface">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:py-28">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> ผลงานที่ผ่านมา</span>
            <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ผลงานก่อสร้างจริง — ลูกค้าจริง พื้นที่จริง</h2>
            <p class="mt-4 text-lg text-ink2">เลือกหมวดเพื่อกรองผลงานตามประเภทงาน</p>
        </div>

        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap gap-2.5" id="project-filters" role="tablist" aria-label="กรองผลงานตามบริการ">
                <button type="button" data-filter="all" role="tab" aria-selected="true"
                    class="inline-flex items-center gap-2 rounded-full border px-4 py-2.5 text-[15px] font-medium transition border-navy-900 bg-navy-900 text-white">
                    {{ $allLabel }}
                    <span class="rounded-full bg-white/20 px-2 py-0.5 text-[11px] font-semibold tabular-nums">{{ $blogs->count() }}</span>
                </button>
                @foreach ($filterServices as $service)
                    <button type="button" data-filter="{{ $service->slug }}" data-filter-title="{{ $service->title }}" role="tab" aria-selected="false"
                        class="inline-flex items-center gap-2 rounded-full border px-4 py-2.5 text-[15px] font-medium transition border-line bg-transparent text-ink2 hover:border-navy-900 hover:text-navy-900">
                        {{ $service->title }}
                        <span class="rounded-full bg-surface px-2 py-0.5 text-[11px] font-semibold text-muted tabular-nums">{{ $service->blogs_count }}</span>
                    </button>
                @endforeach
            </div>

            <label class="relative w-full sm:max-w-xs">
                <span class="sr-only">ค้นหาผลงาน</span>
                <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-muted pointer-events-none"></i>
                <input type="search" id="project-search" placeholder="ค้นหาชื่องาน..."
                    class="w-full rounded-xl border border-line bg-white py-2.5 pl-10 pr-4 text-[15px] text-navy-900 placeholder:text-muted focus:border-navy-900 focus:outline-none focus:ring-2 focus:ring-navy-900/10">
            </label>
        </div>

        <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-5" id="project-grid">
            @forelse ($blogs as $blog)
                <a href="{{ route('blog.show', $blog->slug) }}"
                   data-project-card
                   data-cat="{{ $blog->service->slug }}"
                   data-title="{{ $blog->title }}"
                   data-service-title="{{ $blog->service->title }}"
                   class="group relative block aspect-4/3 overflow-hidden rounded-2xl ring-1 ring-line transition duration-300">
                    @if ($blog->cover_image)
                        @if (str_starts_with($blog->cover_image, 'http'))
                            <img src="{{ $blog->cover_image }}" alt="{{ $blog->title }}" loading="lazy"
                                 class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <img src="{{ Storage::disk('s3')->url($blog->cover_image) }}?width=900&format=webp&fit=cover"
                                 alt="{{ $blog->title }}" loading="lazy"
                                 class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        @endif
                    @else
                        <img src="{{ $fallbackImage }}" alt="{{ $blog->title }}" loading="lazy"
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

            <p id="project-empty" class="hidden col-span-full text-center text-muted py-12">
                ไม่พบผลงานในหมวดนี้
            </p>
        </div>
    </div>
</section>
