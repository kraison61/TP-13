@if ($bar)
<div class="border-b border-line bg-surface">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-3.5">
@endif

<nav aria-label="breadcrumb" {{ $attributes->class([
    'flex flex-wrap items-center gap-2',
    'text-[14px]' => $bar,
    'text-[13px]' => ! $bar,
    'text-white/50' => $variant === 'dark',
    'text-muted' => $variant === 'light',
]) }}>
    @foreach ($items as $item)
        @if (! $loop->first)
            <i @class([
                'bi bi-chevron-right',
                'text-[11px]' => $bar,
                'text-[10px]' => ! $bar,
                'text-white/40' => $variant === 'dark',
                'text-line' => $variant === 'light',
            ]) aria-hidden="true"></i>
        @elseif ($bar && $item['active'] && count($items) === 1)
            <i class="bi bi-house-door-fill text-accent text-[13px]" aria-hidden="true"></i>
        @endif

        @if ($item['active'] || empty($item['url']))
            <span @class([
                'font-medium',
                'text-white/80' => $variant === 'dark',
                'text-navy-900' => $variant === 'light',
            ])>{{ $item['label'] }}</span>
        @else
            <a href="{{ $item['url'] }}" @class([
                'transition',
                'hover:text-white' => $variant === 'dark',
                'hover:text-navy-900' => $variant === 'light',
            ])>{{ $item['label'] }}</a>
        @endif
    @endforeach
</nav>

@if ($bar)
    </div>
</div>
@endif
