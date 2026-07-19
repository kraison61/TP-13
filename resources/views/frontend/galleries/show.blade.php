@extends('layouts.frontend')

@section('content')
<x-frontend.page-hero
    :current="$hero['current'] ?? null"
    :eyebrow="$hero['eyebrow'] ?? ''"
    :title="$hero['title'] ?? ''"
    :description="$hero['description'] ?? ''"
    :badges="$hero['badges'] ?? []"
/>

<div class="bg-surface pb-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-7 -mt-8 relative z-10">
        <div class="bg-white rounded-2xl px-5 sm:px-7 py-5 shadow-md grid gap-5 grid-cols-2 sm:grid-cols-3 lg:grid-cols-[repeat(auto-fill,minmax(140px,1fr))]">
            @foreach ($stats as $stat)
                <div class="flex flex-col gap-1 min-w-0">
                    <span class="text-[11px] text-muted uppercase tracking-widest font-semibold">{{ $stat['label'] }}</span>
                    <span class="text-[15px] sm:text-[17px] font-bold text-navy-900 leading-snug">{{ $stat['value'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-7 pt-8">
        <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
            <h2 class="text-lg font-bold text-navy-900">ภาพโครงการทั้งหมด</h2>
            <span class="text-sm text-muted">คลิกที่ภาพเพื่อขยาย</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 auto-rows-[200px] lg:auto-rows-[220px] gap-3">
            @foreach ($photos as $index => $photo)
                <button type="button"
                    data-gallery-photo
                    data-index="{{ $index }}"
                    data-src="{{ $photo['src'] }}"
                    data-caption="{{ $photo['caption'] }}"
                    @class([
                        'group relative overflow-hidden rounded-xl cursor-zoom-in bg-slate-200 text-left',
                        $photo['span'],
                    ])>
                    <img src="{{ $photo['thumb'] }}" alt="{{ $photo['caption'] }}" loading="lazy" decoding="async" width="800" height="600"
                         class="w-full h-full object-cover block transition duration-500 group-hover:scale-105" />
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-end p-4 bg-linear-to-t from-navy-950/88 via-transparent to-transparent">
                        <p class="text-white text-sm font-medium leading-snug line-clamp-2">{{ $photo['caption'] }}</p>
                    </div>
                </button>
            @endforeach
        </div>
    </div>
</div>

<dialog id="gallery-lb" class="fixed inset-0 z-50 m-0 h-full max-h-none w-full max-w-none border-0 bg-[rgba(5,15,30,.96)] p-0 backdrop:bg-[rgba(5,15,30,.96)] open:flex open:flex-col open:items-center open:justify-center">
    <form method="dialog" class="fixed top-4 right-4 z-10">
        <button type="submit" class="w-10 h-10 rounded-full flex items-center justify-center bg-white/8 border border-white/14 text-white hover:bg-white/20 transition-colors" aria-label="ปิด">
            <x-icon name="x-lg" />
        </button>
    </form>
    <button type="button" id="gallery-lb-prev" class="fixed left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full flex items-center justify-center bg-white/8 border border-white/12 text-white hover:bg-white/18 transition-colors" aria-label="ก่อนหน้า">
        <x-icon name="chevron-left" />
    </button>
    <button type="button" id="gallery-lb-next" class="fixed right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full flex items-center justify-center bg-white/8 border border-white/12 text-white hover:bg-white/18 transition-colors" aria-label="ถัดไป">
        <x-icon name="chevron-right" />
    </button>
    <div class="flex-1 w-full flex items-center justify-center overflow-hidden px-4 sm:px-20 pt-14 pb-5 min-h-0">
        <img id="gallery-lb-main" src="" alt="" class="max-w-full max-h-[70vh] object-contain rounded shadow-2xl block" />
    </div>
    <p id="gallery-lb-caption" class="text-white/60 text-sm text-center px-5 pb-1 font-light min-h-5"></p>
    <p id="gallery-lb-counter" class="text-white/35 text-xs text-center pb-3"></p>
    <div id="gallery-lb-thumbs" class="flex gap-2 px-5 pb-5 overflow-x-auto [scrollbar-width:thin] w-full justify-center">
        @foreach ($photos as $index => $photo)
            <button type="button"
                data-gallery-thumb
                data-index="{{ $index }}"
                data-src="{{ $photo['src'] }}"
                data-caption="{{ $photo['caption'] }}"
                @class([
                    'w-15 h-11 rounded overflow-hidden cursor-pointer opacity-45 hover:opacity-80 transition-opacity shrink-0 ring-0 ring-white',
                    'opacity-100 ring-2' => $index === 0,
                ])>
                <img src="{{ $photo['thumb'] }}" alt="{{ $photo['caption'] }}" class="w-full h-full object-cover block" loading="lazy" width="60" height="44" />
            </button>
        @endforeach
    </div>
</dialog>
@endsection
