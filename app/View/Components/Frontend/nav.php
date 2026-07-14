<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class nav extends Component
{
    /** @var list<array{label: string, href: string, icon?: string}> */
    public array $items;

    /**
     * @param  list<array{label: string, url: string, type?: string, icon?: string}>|null  $items
     */
    public function __construct(?array $items = null)
    {
        $this->items = collect($items ?? config('frontend.nav', []))
            ->map(fn (array $item) => [
                'label' => $item['label'],
                'href' => ($item['type'] ?? 'route') === 'route'
                    ? route($item['url'])
                    : $item['url'],
                'icon' => $item['icon'] ?? null,
            ])
            ->all();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.nav');
    }
}
