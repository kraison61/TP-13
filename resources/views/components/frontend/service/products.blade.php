@props(['service'])

@if ($service->products->isNotEmpty())
<section id="related-products" class="border-y border-line bg-surface overflow-hidden" aria-label="สินค้าแนะนำสำหรับงานนี้">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-3 flex items-center gap-3">
        <span class="text-xs font-semibold uppercase tracking-[0.12em] text-muted shrink-0">สินค้าแนะนำ</span>
    </div>

    <div class="relative w-full">
        <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-6 sm:w-10 bg-gradient-to-r from-surface to-transparent" aria-hidden="true"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-6 sm:w-10 bg-gradient-to-l from-surface to-transparent" aria-hidden="true"></div>

        <div id="svcProdViewport" class="w-full overflow-hidden pb-3">
            <div id="svcProdTrack" class="flex w-max gap-2 px-4 sm:px-6 will-change-transform">
                @foreach ($service->products as $product)
                    <a href="{{ $product->affiliate_link }}"
                       target="_blank"
                       rel="noopener noreferrer sponsored"
                       class="svc-prod-card group flex w-[12.5rem] sm:w-[14rem] shrink-0 items-center gap-2.5 rounded-lg border border-line/80 bg-white/80 px-2.5 py-2 hover:border-line hover:bg-white transition">
                        @if ($product->image)
                            <img src="{{ $product->image }}"
                                 alt=""
                                 loading="lazy"
                                 decoding="async"
                                 width="60"
                                 height="60"
                                 class="size-[60px] shrink-0 rounded object-cover" />
                        @else
                            <span class="grid size-[60px] shrink-0 place-items-center rounded bg-surface text-muted text-sm">
                                <x-icon name="box-seam" />
                            </span>
                        @endif
                        <span class="min-w-0 flex flex-col gap-1">
                            <span class="text-[13px] font-semibold leading-snug text-navy-900 line-clamp-2 group-hover:text-accent">
                                {{ $product->name }}
                            </span>
                            @if ($product->description)
                                <span class="text-[11px] leading-snug text-muted line-clamp-2">{{ $product->description }}</span>
                            @endif
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
