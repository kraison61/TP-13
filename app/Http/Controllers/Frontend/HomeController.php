<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use App\Models\Faq;
use App\Models\Review;
use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Support\MainPageSchema;
use App\Support\ProjectSchema;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('activePrice')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        $homeServices = $services->take(config('frontend.services_list.home_limit', 4));

        $allProjectBlogs = Blog::with('service')
            ->whereNotNull('service_id')
            ->whereHas('service', fn ($q) => $q->where('is_active', true))
            ->latest()
            ->get();

        $projectBlogs = $allProjectBlogs->take(config('frontend.projects.home_limit', 6));

        $projectSchemaLd = ProjectSchema::itemList($allProjectBlogs);

        $faqs = Service::query()
            ->where('is_active', true)
            ->whereHas('faqs', fn ($q) => $q->where('is_active', true))
            ->with(['faqs' => fn ($q) => $q
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->limit(1)])
            ->orderBy('id')
            ->get()
            ->map(fn (Service $service) => $service->faqs->first())
            ->filter()
            ->values();

        $faqItems = $faqs->map(fn (Faq $faq) => [
            'q' => $faq->question,
            'a' => nl2br(e($faq->answer)),
        ])->all();

        $mainSchemaLd = MainPageSchema::graph($services, $faqs);

        $testimonials = $this->buildTestimonials();

        return view('Frontend.index', compact(
            'services',
            'homeServices',
            'allProjectBlogs',
            'projectBlogs',
            'projectSchemaLd',
            'mainSchemaLd',
            'faqItems',
            'testimonials',
        ));
    }

    /**
     * @return list<array{i: string, name: string, project: string, quote: string, rating: int}>
     */
    private function buildTestimonials(): array
    {
        $reviews = Review::query()
            ->with(['service' => fn ($q) => $q
                ->where('is_active', true)
                ->select('id', 'title', 'service_category_id')
                ->with('category:id,name')])
            ->whereHas('service', fn ($q) => $q->where('is_active', true))
            ->latest('id')
            ->get();

        if ($reviews->isEmpty()) {
            return [];
        }

        return $reviews
            ->map(fn (Review $review) => $this->formatReview($review))
            ->values()
            ->all();
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
