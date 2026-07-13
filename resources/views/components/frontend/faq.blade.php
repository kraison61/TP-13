@props(['faqs'])
<section id="faq" class="mx-auto max-w-7xl px-4 sm:px-6 py-20 lg:py-28">
    <div class="grid lg:grid-cols-12 gap-10 lg:gap-16">
        <div class="lg:col-span-5">
            <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> คำถามที่พบบ่อย</span>
            <h2 class="mt-4 text-4xl lg:text-5xl font-bold tracking-tight text-navy-900 leading-tight">ก่อนตัดสินใจ คุณอาจอยากรู้</h2>
            <p class="mt-4 text-lg text-ink2 leading-relaxed">หากไม่พบคำตอบที่ต้องการ โทร <a href="tel:{{ config('company.phone') }}" class="font-mono tabular-nums text-accent font-semibold">{{ config('company.phone_formatted') }}</a> ทีมงานพร้อมตอบ {{ config('company.open_hours') }}</p>
            <a href="#contact" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-accent px-6 py-3.5 font-semibold text-white hover:bg-navy-900 transition">ขอคำปรึกษาฟรี <i class="bi bi-arrow-right"></i></a>
        </div>

        <div id="faqItems" class="lg:col-span-7 space-y-3">
            @foreach($faqs as $i => $faq)
            <details class="group rounded-2xl border border-line bg-white px-5 [&_summary::-webkit-details-marker]:hidden" name="faq" {{ $i === 0 ? 'open' : '' }}>
                <summary class="flex cursor-pointer items-center justify-between gap-4 py-4 font-semibold text-navy-900">
                    {{ $faq['q'] }}
                    <i class="bi bi-plus-lg text-accent transition group-open:rotate-45"></i>
                </summary>
                <p class="pb-5 -mt-1 text-[15px] text-ink2 leading-relaxed">{!! $faq['a'] !!}</p>
            </details>
            @endforeach
        </div>
    </div>
</section>