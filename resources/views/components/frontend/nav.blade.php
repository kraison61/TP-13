<div id="mobileMenuBackdrop" class="fixed inset-0 z-40 bg-navy-950/40 hidden lg:hidden" aria-hidden="true"></div>

<header id="nav" class="top-0 z-50 max-lg:fixed max-lg:inset-x-0 lg:sticky bg-white max-lg:backdrop-blur-none lg:bg-white/90 lg:backdrop-blur-md border-b border-line">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 h-[68px] flex items-center justify-between gap-2 sm:gap-4" aria-label="เมนูหลัก">
        <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 min-w-0 shrink" aria-label="{{ config('company.brand') }} — หน้าแรก">
            <span class="relative grid place-items-center w-10 h-10 rounded-lg bg-navy-900 text-white font-mono font-bold text-sm shrink-0">TP
                <span class="absolute w-1.5 h-1.5 rounded-[2px] bg-hivis translate-x-3 translate-y-3"></span>
            </span>
            <span class="hidden min-[380px]:inline font-bold text-navy-900 tracking-tight text-[17px] whitespace-nowrap truncate">{{ config('company.brand') }}</span>
        </a>

        {{-- Desktop menu --}}
        <ul class="hidden lg:flex items-center gap-1 text-[15px] font-medium text-ink2">
            @foreach ($items as $item)
                <li @class(['relative group' => ! empty($item['children'])])>
                    @if (! empty($item['children']))
                        <a href="{{ $item['href'] }}"
                           class="inline-flex items-center gap-1 px-3.5 py-2 rounded-lg hover:text-navy-900 hover:bg-surface transition"
                           aria-haspopup="true">
                            {{ $item['label'] }}
                            <x-icon name="chevron-down" class="text-[10px] shrink-0" />
                        </a>
                        <div class="absolute left-0 top-full pt-2 hidden group-hover:block group-focus-within:block min-w-[260px] z-50">
                            <ul class="rounded-xl border border-line bg-white py-2 shadow-lg shadow-navy-900/10">
                                @foreach ($item['children'] as $child)
                                    <li>
                                        <a href="{{ $child['href'] }}"
                                           class="flex items-center gap-2.5 px-4 py-2.5 text-[14px] hover:bg-surface hover:text-navy-900 transition">
                                            @if ($child['icon'])
                                                <x-icon:name="$child['icon']" class="text-accent shrink-0" />
                                            @endif
                                            {{ $child['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                                <li class="border-t border-line mt-1 pt-1">
                                    <a href="{{ $item['href'] }}"
                                       class="block px-4 py-2.5 text-[13px] font-semibold text-accent hover:bg-surface transition">
                                        ดูบริการก่อสร้างทั้งหมด <x-icon name="arrow-right" class="text-xs inline-block" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ $item['href'] }}" class="block px-3.5 py-2 rounded-lg hover:text-navy-900 hover:bg-surface transition">
                            {{ $item['label'] }}@if ($item['icon']) <x-icon:name="$item['icon']" class="text-xs inline-block" />@endif
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>

        <div class="flex items-center gap-2">
            <a href="{{ $ctaHref }}"
               class="inline-flex lg:hidden items-center rounded-xl bg-accent px-2.5 min-[380px]:px-3 py-2 text-xs min-[380px]:text-sm font-semibold text-white shadow-md shadow-navy-900/15 hover:bg-navy-900 transition shrink-0">
                {{ $ctaMobileLabel }}
            </a>
            <a href="{{ $ctaHref }}"
               class="hidden lg:inline-flex items-center gap-2 rounded-xl bg-accent px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/15 hover:bg-navy-900 transition">
                {{ $ctaLabel }} <x-icon name="arrow-right" />
            </a>
            <button id="menuBtn" type="button" class="lg:hidden grid place-items-center w-10 h-10 rounded-lg border border-line text-navy-900 text-2xl" aria-label="เปิดเมนู" aria-expanded="false" aria-controls="mobileMenu">
                <x-icon name="list" />
            </button>
        </div>
    </nav>

    {{-- Mobile menu --}}
    <div id="mobileMenu" class="lg:hidden hidden border-t border-line bg-white max-h-[calc(100dvh-68px)] overflow-y-auto">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-3 flex flex-col text-[15px] font-medium text-ink2">
            @foreach ($items as $item)
                @if (! empty($item['children']))
                    <details class="border-b border-line/70 group/nav">
                        <summary class="py-2.5 cursor-pointer list-none flex items-center justify-between gap-2 marker:content-none">
                            <span>{{ $item['label'] }}</span>
                            <x-icon name="chevron-down" class="text-xs transition group-open/nav:rotate-180 shrink-0" />
                        </summary>
                        <div class="pb-2 pl-1 space-y-0.5">
                            @foreach ($item['children'] as $child)
                                <a href="{{ $child['href'] }}" class="flex items-center gap-2 py-2 pl-3 text-[14px] hover:text-navy-900 transition">
                                    @if ($child['icon'])
                                        <x-icon:name="$child['icon']" class="text-accent shrink-0" />
                                    @endif
                                    {{ $child['label'] }}
                                </a>
                            @endforeach
                            <a href="{{ $item['href'] }}" class="block py-2 pl-3 text-[13px] font-semibold text-accent">
                                ดูบริการก่อสร้างทั้งหมด →
                            </a>
                        </div>
                    </details>
                @else
                    <a href="{{ $item['href'] }}" @class(['py-2.5', 'border-b border-line/70' => ! $loop->last])>
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
            <a href="{{ $ctaHref }}"
               class="mt-3 inline-flex items-center justify-center gap-2 rounded-xl bg-accent px-4 py-3 text-sm font-semibold text-white hover:bg-navy-900 transition">
                {{ $ctaLabel }} <x-icon name="arrow-right" />
            </a>
        </div>
    </div>
</header>
<div class="h-[68px] shrink-0 lg:hidden" aria-hidden="true"></div>
