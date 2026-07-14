<div id="mobileMenuBackdrop" class="fixed inset-0 z-40 bg-navy-950/40 hidden lg:hidden" aria-hidden="true"></div>

<header id="nav" class="top-0 z-50 max-lg:fixed max-lg:inset-x-0 lg:sticky bg-white max-lg:backdrop-blur-none lg:bg-white/90 lg:backdrop-blur-md border-b border-line">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 h-[68px] flex items-center justify-between gap-2 sm:gap-4">
        <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 min-w-0 shrink">
            <span class="relative grid place-items-center w-10 h-10 rounded-lg bg-navy-900 text-white font-mono font-bold text-sm shrink-0">TP
                <span class="absolute w-1.5 h-1.5 rounded-[2px] bg-hivis translate-x-3 translate-y-3"></span>
            </span>
            <span class="hidden min-[380px]:inline font-bold text-navy-900 tracking-tight text-[17px] whitespace-nowrap truncate">ธีรพงษ์การช่าง</span>
        </a>

        <div class="hidden lg:flex items-center gap-1 text-[15px] font-medium text-ink2">
            @foreach ($items as $item)
            <a href="{{ $item['href'] }}" class="px-3.5 py-2 rounded-lg hover:text-navy-900 hover:bg-surface transition">
                {{ $item['label'] }}@if ($item['icon']) <i class="bi {{ $item['icon'] }} text-xs"></i>@endif
            </a>
            @endforeach
        </div>

        <div class="flex items-center gap-2">
            <a href="#contact" class="inline-flex lg:hidden items-center rounded-xl bg-accent px-2.5 min-[380px]:px-3 py-2 text-xs min-[380px]:text-sm font-semibold text-white hover:bg-navy-900 transition shrink-0">ขอราคา</a>
            <a href="#contact" class="hidden lg:inline-flex items-center gap-2 rounded-xl bg-accent px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy-900 transition">ขอใบเสนอราคา</a>
            <button id="menuBtn" class="lg:hidden grid place-items-center w-10 h-10 rounded-lg border border-line text-navy-900" aria-label="เมนู">
                <i class="bi bi-list text-2xl"></i>
            </button>
        </div>
    </nav>

    {{-- mobile menu --}}
    <div id="mobileMenu" class="lg:hidden hidden border-t border-line bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-3 flex flex-col text-[15px] font-medium text-ink2">
            @foreach ($items as $item)
            <a href="{{ $item['href'] }}" @class(['py-2.5', 'border-b border-line/70' => ! $loop->last])>{{ $item['label'] }}</a>
            @endforeach
        </div>
    </div>
</header>
<div class="h-[68px] shrink-0 lg:hidden" aria-hidden="true"></div>
