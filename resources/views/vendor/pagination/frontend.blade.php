@if ($paginator->hasPages())
    <nav role="navigation" aria-label="เลขหน้า" class="flex flex-col items-center gap-4">
        <div class="inline-flex items-center gap-1.5 sm:gap-2 rounded-full bg-white p-1.5 ring-1 ring-line shadow-sm shadow-navy-900/5">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span
                    aria-disabled="true"
                    class="grid size-10 place-items-center rounded-full text-muted/50 cursor-not-allowed sm:size-11"
                >
                    <x-icon name="arrow-left" class="text-lg" />
                </span>
            @else
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    rel="prev"
                    aria-label="หน้าก่อน"
                    class="grid size-10 place-items-center rounded-full text-navy-900 transition hover:bg-navy-900 hover:text-white sm:size-11"
                >
                    <x-icon name="arrow-left" class="text-lg" />
                </a>
            @endif

            {{-- Page numbers --}}
            <div class="flex items-center gap-1 px-0.5">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="grid size-9 place-items-center text-sm font-medium text-muted select-none" aria-hidden="true">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span
                                    aria-current="page"
                                    class="grid size-9 place-items-center rounded-full bg-navy-900 text-sm font-semibold text-white shadow-md shadow-navy-900/20 sm:size-10"
                                >
                                    {{ $page }}
                                </span>
                            @else
                                <a
                                    href="{{ $url }}"
                                    aria-label="ไปหน้า {{ $page }}"
                                    class="grid size-9 place-items-center rounded-full text-sm font-medium text-navy-900 transition hover:bg-surface hover:text-accent sm:size-10"
                                >
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    rel="next"
                    aria-label="หน้าถัดไป"
                    class="grid size-10 place-items-center rounded-full text-navy-900 transition hover:bg-navy-900 hover:text-white sm:size-11"
                >
                    <x-icon name="arrow-right" class="text-lg" />
                </a>
            @else
                <span
                    aria-disabled="true"
                    class="grid size-10 place-items-center rounded-full text-muted/50 cursor-not-allowed sm:size-11"
                >
                    <x-icon name="arrow-right" class="text-lg" />
                </span>
            @endif
        </div>

        <p class="text-sm text-muted">
            หน้า
            <span class="font-semibold text-navy-900">{{ $paginator->currentPage() }}</span>
            จาก
            <span class="font-semibold text-navy-900">{{ $paginator->lastPage() }}</span>
            @if ($paginator->total())
                <span class="mx-1.5 text-line">·</span>
                {{ number_format($paginator->total()) }} รายการ
            @endif
        </p>
    </nav>
@endif
