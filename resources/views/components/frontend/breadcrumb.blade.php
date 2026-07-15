<!-- ============ BREADCRUMB ============ -->
<nav
  aria-label="breadcrumb"
  @class([
      'border-b border-line bg-surface' => $bar && ! $embedded,
      $attributes->get('class'),
  ])
>
  <div @class([
      'flex items-center gap-2 flex-wrap',
      'mx-auto max-w-7xl px-6 py-3.5 text-[14px]' => ! $embedded,
      'text-[13px]' => $embedded,
      'text-white/50' => $embedded && $variant === 'dark',
      'text-white/70' => ! $embedded && $variant === 'dark',
      'text-muted' => $variant !== 'dark',
  ])>
    @foreach ($items as $index => $item)
      @if ($index > 0)
        <i @class([
            'bi bi-chevron-right',
            'text-[10px]' => $embedded,
            'text-[11px]' => ! $embedded,
        ])></i>
      @endif

      @if ($item['active'] || ! $item['url'])
        <span @class([
            'font-medium',
            'text-white/80' => $embedded && $variant === 'dark',
            'text-white' => ! $embedded && $variant === 'dark',
            'text-navy-900' => $variant !== 'dark',
        ])>{{ $item['label'] }}</span>
      @else
        <a
          href="{{ $item['url'] }}"
          @class([
              'transition',
              'hover:text-white' => $variant === 'dark',
              'hover:text-navy-900' => $variant !== 'dark',
          ])
        >{{ $item['label'] }}</a>
      @endif
    @endforeach
  </div>
</nav>
