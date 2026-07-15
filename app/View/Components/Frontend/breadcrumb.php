<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class breadcrumb extends Component
{
    /** @var list<array{label: string, url: ?string, active: bool}> */
    public array $items;

    /**
     * @param  list<array{label: string, url?: ?string, active?: bool}>|null  $items
     * @param  array<string, string>|null  $labels
     * @param  list<array{label: string, url: string}>  $parents
     */
    public function __construct(
        ?array $items = null,
        ?array $labels = null,
        public ?string $current = null,
        public string $variant = 'light',
        public bool $bar = false,
        public array $parents = [],
    ) {
        $this->items = $items ?? $this->buildFromSegments($labels);
    }

    /**
     * @param  array<string, string>|null  $labels
     * @return list<array{label: string, url: ?string, active: bool}>
     */
    private function buildFromSegments(?array $labels): array
    {
        $segments = request()->segments();
        $labelMap = array_merge(config('frontend.breadcrumbs.labels', []), $labels ?? []);
        $homeLabel = config('frontend.breadcrumbs.home_label', 'หน้าแรก');

        $items = [[
            'label' => $homeLabel,
            'url' => empty($segments) && empty($this->parents) ? null : route('home'),
            'active' => empty($segments) && empty($this->parents),
        ]];

        foreach ($this->parents as $parent) {
            $items[] = [
                'label' => $parent['label'],
                'url' => $parent['url'],
                'active' => false,
            ];
        }

        $path = '';

        foreach ($segments as $index => $segment) {
            $path .= '/'.$segment;
            $isLast = $index === count($segments) - 1;

            $label = $isLast && $this->current
                ? $this->current
                : ($labelMap[$segment] ?? $this->humanizeSegment($segment));

            $items[] = [
                'label' => $label,
                'url' => $isLast ? null : url($path),
                'active' => $isLast,
            ];
        }

        return $items;
    }

    private function humanizeSegment(string $segment): string
    {
        return Str::of($segment)->replace(['-', '_'], ' ')->title()->toString();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.breadcrumb');
    }
}
