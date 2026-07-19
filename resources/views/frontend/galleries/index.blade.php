@extends('layouts.frontend')

@section('content')
<x-frontend.page-hero
    :current="$hero['current'] ?? null"
    :eyebrow="$hero['eyebrow'] ?? ''"
    :title="$hero['title'] ?? ''"
    :description="$hero['description'] ?? ''"
    :badges="$hero['badges'] ?? []"
/>

<div class="bg-white border-b border-slate-200 sticky top-0 z-20 shadow-sm">
    <div class="max-w-6xl mx-auto px-7 flex items-center gap-5 h-15">
        <div class="flex gap-2 flex-1 overflow-x-auto [scrollbar-width:none] py-0.5" id="gallery-filters" role="tablist" aria-label="กรองโครงการตามหมวดหมู่">
            @foreach ($categories as $category)
                <button type="button"
                    data-filter="{{ $category === 'ทั้งหมด' ? 'all' : $category }}"
                    role="tab"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    @class([
                        'cursor-pointer h-9 px-[18px] rounded-full text-sm font-medium border-[1.5px] transition-colors duration-150 shrink-0',
                        'bg-navy-900 border-navy-900 text-white' => $loop->first,
                        'bg-white border-navy-900 text-navy-900 hover:bg-navy-900 hover:text-white' => ! $loop->first,
                    ])>
                    {{ $category }}
                </button>
            @endforeach
        </div>
        <p class="text-sm text-slate-500 shrink-0">
            <strong id="gallery-count" class="text-navy-900 font-bold">{{ count($projects) }}</strong> โครงการ
        </p>
    </div>
</div>

<main class="max-w-6xl mx-auto px-7 py-9 pb-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="gallery-grid">
        @foreach ($projects as $project)
            <article data-gallery-card data-cat="{{ $project['category'] }}"
                class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 focus-within:outline-2 focus-within:outline-navy-900">
                <a href="{{ route('frontend.galleries.show', $project['slug']) }}" class="block text-inherit no-underline">
                    <div class="aspect-[4/3] overflow-hidden relative">
                        <img class="w-full h-full object-cover block" src="{{ $project['image'] }}" alt="{{ $project['alt'] }}" loading="lazy" width="800" height="600" />
                        <div class="absolute inset-0 pointer-events-none" style="background:linear-gradient(to top,rgba(6,44,74,.94),rgba(10,61,98,.5) 40%,transparent 70%)"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <span class="inline-block bg-white/15 backdrop-blur border border-white/20 text-white text-[11px] font-semibold px-2.5 py-1 rounded mb-2 tracking-widest uppercase">{{ $project['category'] }}</span>
                            <h3 class="text-white text-base font-semibold leading-snug mb-1.5" style="text-wrap:pretty">{{ $project['title'] }}</h3>
                            <p class="text-white/65 text-[12.5px] font-light leading-relaxed">{{ $project['specs'] }}</p>
                        </div>
                    </div>
                    <div class="px-5 py-3.5 flex items-center justify-between border-t border-slate-100">
                        <span class="flex items-center gap-1.5 text-slate-400 text-sm">
                            <x-icon name="gallery-pin" class="w-[10px] h-[13px]" />
                            {{ $project['province'] }}
                        </span>
                        <span class="flex items-center gap-1 text-navy-900 text-[13px] font-semibold">
                            ดูรายละเอียด
                            <x-icon name="gallery-arrow" class="w-[14px] h-[14px]" />
                        </span>
                    </div>
                </a>
            </article>
        @endforeach
    </div>

    <div id="gallery-empty" class="hidden text-center py-24 text-slate-400">
        <x-icon name="gallery-empty" class="mx-auto mb-4 opacity-35 w-12 h-12" />
        <p class="text-lg font-medium text-slate-600 mb-1">ไม่พบโครงการในหมวดนี้</p>
        <p class="text-sm">ลองเลือกหมวดหมู่อื่น</p>
    </div>
</main>
@endsection
