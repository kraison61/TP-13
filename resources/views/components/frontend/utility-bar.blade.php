<div class="hidden lg:block bg-navy-950 text-white/70 text-[13px]">
    <div class="mx-auto max-w-7xl px-6 h-10 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <span><x-icon name="geo-alt-fill" class="text-hivis mr-1 inline-block" /> กรุงเทพมหานคร, ปริมณฑล &amp; รับงานโครงการก่อสร้างทั่วประเทศ</span>
            <span><x-icon name="clock-fill" class="text-hivis mr-1 inline-block" /> {{ config('company.open_hours') }}</span>
        </div>
        <div class="flex items-center gap-6">
            <a href="{{ config('company.line_official') }}" class="hover:text-white transition"><x-icon name="line" class="text-hivis mr-1 inline-block" /> {{ config('company.line_official_name') }}</a>
            <a href="tel:{{ config('company.phone') }}" class="hover:text-white transition font-mono tabular-nums tracking-tight"><x-icon name="telephone-fill" class="text-hivis mr-1 inline-block" /> {{ config('company.phone_formatted') }}</a>
        </div>
    </div>
</div>
