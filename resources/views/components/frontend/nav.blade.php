<header id="nav" class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-line">
    <nav class="mx-auto max-w-7xl px-6 h-[68px] flex items-center justify-between gap-4">
        <a href="#home" class="flex items-center gap-3 shrink-0">
            <span class="relative grid place-items-center w-10 h-10 rounded-lg bg-navy-900 text-white font-mono font-bold text-sm">TP
                <span class="absolute w-1.5 h-1.5 rounded-[2px] bg-hivis translate-x-3 translate-y-3"></span>
            </span>
            <span class="font-bold text-navy-900 tracking-tight text-[17px] whitespace-nowrap">ธีรพงษ์การช่าง</span>
        </a>

        <div class="hidden lg:flex items-center gap-1 text-[15px] font-medium text-ink2">
            <a href="#home"     class="px-3.5 py-2 rounded-lg hover:text-navy-900 hover:bg-surface transition">หน้าแรก</a>
            <a href="{{ route('services') }}" class="px-3.5 py-2 rounded-lg hover:text-navy-900 hover:bg-surface transition">บริการ</a>
            <a href="#projects" class="px-3.5 py-2 rounded-lg hover:text-navy-900 hover:bg-surface transition">ผลงาน</a>
            <a href="#process"  class="px-3.5 py-2 rounded-lg hover:text-navy-900 hover:bg-surface transition">ขั้นตอน</a>
            <a href="{{ route('blog.index') }}"   class="px-3.5 py-2 rounded-lg hover:text-navy-900 hover:bg-surface transition">บทความ</a>
            <a href="{{ route('portal') }}"       class="px-3.5 py-2 rounded-lg hover:text-navy-900 hover:bg-surface transition">พอร์ทัลลูกค้า <i class="bi bi-arrow-up-right text-xs"></i></a>
        </div>

        <div class="flex items-center gap-2">
            <a href="#contact" class="hidden sm:inline-flex items-center gap-2 rounded-xl bg-accent px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy-900 transition">ขอใบเสนอราคา</a>
            <button id="menuBtn" class="lg:hidden grid place-items-center w-10 h-10 rounded-lg border border-line text-navy-900" aria-label="เมนู">
                <i class="bi bi-list text-2xl"></i>
            </button>
        </div>
    </nav>

    {{-- mobile menu --}}
    <div id="mobileMenu" class="lg:hidden hidden border-t border-line bg-white">
        <div class="mx-auto max-w-7xl px-6 py-3 flex flex-col text-[15px] font-medium text-ink2">
            <a href="#home"                   class="py-2.5 border-b border-line/70">หน้าแรก</a>
            <a href="{{ route('services') }}" class="py-2.5 border-b border-line/70">บริการ</a>
            <a href="#projects"               class="py-2.5 border-b border-line/70">ผลงาน</a>
            <a href="#process"                class="py-2.5 border-b border-line/70">ขั้นตอน</a>
            <a href="{{ route('blog.index') }}" class="py-2.5 border-b border-line/70">บทความ</a>
            <a href="{{ route('portal') }}"   class="py-2.5">พอร์ทัลลูกค้า</a>
        </div>
    </div>
</header>