<?php

namespace App\View\Components\Frontend;

use App\Models\Service;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class nav extends Component
{
    /** @var list<array{label: string, href: string, icon?: ?string, children: list<array{label: string, href: string, icon?: ?string}>}> */
    public array $items;

    public function __construct(
        ?array $items = null,
        public string $ctaLabel = 'ขอใบเสนอราคา',
        public string $ctaMobileLabel = 'ขอราคา',
        public string $ctaHref = '#contact',
    ) {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get(['title', 'slug', 'icon_name']);

        $this->items = collect($items ?? config('frontend.nav', []))
            ->map(function (array $item) use ($services) {
                $mapped = [
                    'label' => $item['label'],
                    'href' => ($item['type'] ?? 'route') === 'route'
                        ? route($item['url'])
                        : $item['url'],
                    'icon' => $item['icon'] ?? null,
                    'children' => [],
                ];

                if (($item['dropdown'] ?? null) === 'services') {
                    $mapped['children'] = $services->map(fn (Service $service) => [
                        'label' => $service->title,
                        'href' => route('frontend.services.show', $service->slug),
                        'icon' => $service->icon_name,
                    ])->all();
                }

                return $mapped;
            })
            ->all();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.nav');
    }
}
