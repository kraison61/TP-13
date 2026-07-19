<?php

namespace App\View\Components\Frontend;

use App\Models\Review;
use App\Support\FrontendCache;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Testimonials extends Component
{
    /** @var list<array{i: string, name: string, project: string, quote: string, rating: int}> */
    public array $testimonials;

    public function __construct()
    {
        try {
            $this->testimonials = FrontendCache::remember('testimonials.reviews', fn () => Review::query()
                ->with(['service' => fn ($q) => $q
                    ->where('is_active', true)
                    ->select('id', 'title', 'service_category_id')
                    ->with('category:id,name')])
                ->whereHas('service', fn ($q) => $q->where('is_active', true))
                ->latest('id')
                ->get()
                ->map(fn (Review $review) => $this->formatReview($review))
                ->values()
                ->all());
        } catch (\Throwable) {
            $this->testimonials = [];
        }
    }

    public function shouldRender(): bool
    {
        return $this->testimonials !== [];
    }

    /**
     * @return array{i: string, name: string, project: string, quote: string, rating: int}
     */
    private function formatReview(Review $review): array
    {
        $displayName = preg_replace('/^คุณ\s*/u', '', $review->author_name) ?? $review->author_name;
        $project = $review->service->title;

        if ($review->location) {
            $project .= ' · '.$review->location;
        }

        return [
            'i' => mb_substr(trim($displayName), 0, 1),
            'name' => $review->author_name,
            'project' => $project,
            'quote' => $review->review_text,
            'rating' => (int) $review->rating,
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.testimonials');
    }
}
