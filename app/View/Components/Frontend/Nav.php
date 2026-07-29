<?php

namespace App\View\Components\Frontend;

use App\Models\Service;
use App\Models\ServiceCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Nav extends Component
{
    /**
     * @var list<array{
     *     label: string,
     *     href: string,
     *     icon?: ?string,
     *     children: list<array{
     *         label: string,
     *         href: string,
     *         icon?: ?string,
     *         children: list<array{label: string, href: string, icon?: ?string, children: list<array{}>}>
     *     }>
     * }>
     */
    public array $items;

    public function __construct(
        ?array $items = null,
        public string $ctaLabel = 'ขอใบเสนอราคา',
        public string $ctaMobileLabel = 'ขอราคา',
        public string $ctaHref = '#contact',
    ) {
        $categories = ServiceCategory::query()
            ->whereHas('services', fn ($q) => $q->where('is_active', true))
            ->with(['services' => fn ($q) => $q
                ->where('is_active', true)
                ->orderBy('id')
                ->select(['id', 'title', 'slug', 'icon_name', 'service_category_id'])])
            ->orderBy('id')
            ->get(['id', 'name', 'slug']);

        $uncategorized = Service::query()
            ->where('is_active', true)
            ->whereNull('service_category_id')
            ->orderBy('id')
            ->get(['title', 'slug', 'icon_name']);

        $this->items = collect($items ?? config('frontend.nav', []))
            ->map(function (array $item) use ($categories, $uncategorized) {
                $mapped = [
                    'label' => $item['label'],
                    'href' => ($item['type'] ?? 'route') === 'route'
                        ? route($item['url'])
                        : $item['url'],
                    'icon' => $item['icon'] ?? null,
                    'children' => [],
                ];

                if (($item['dropdown'] ?? null) === 'services') {
                    $mapped['children'] = $categories->map(fn (ServiceCategory $category) => [
                        'label' => $category->name,
                        'href' => '',
                        'icon' => null,
                        'children' => $category->services->map(fn (Service $service) => [
                            'label' => $service->title,
                            'href' => route('frontend.services.show', $service->slug),
                            'icon' => $service->icon_name,
                            'children' => [],
                        ])->all(),
                    ])->all();

                    foreach ($uncategorized as $service) {
                        $mapped['children'][] = [
                            'label' => $service->title,
                            'href' => route('frontend.services.show', $service->slug),
                            'icon' => $service->icon_name,
                            'children' => [],
                        ];
                    }

                    foreach ($item['dropdown_extra'] ?? [] as $extra) {
                        $mapped['children'][] = [
                            'label' => $extra['label'],
                            'href' => ($extra['type'] ?? 'route') === 'route'
                                ? route($extra['url'])
                                : $extra['url'],
                            'icon' => $extra['icon'] ?? null,
                            'children' => [],
                        ];
                    }
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
