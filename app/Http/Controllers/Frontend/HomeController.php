<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use App\Models\Faq;
use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Support\FrontendCache;
use App\Support\GalleryPresenter;
use App\Support\MainPageSchema;
use App\Support\OrganizationSchema;
use App\Support\ProjectSchema;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = FrontendCache::rememberIds('home.service-ids', fn () => Service::with('activePrice')
            ->where('is_active', true)
            ->orderBy('id'));

        $homeServices = $services->take(config('frontend.services_list.home_limit', 4));

        $allProjectBlogs = FrontendCache::rememberIds('home.project-blog-ids', fn () => Blog::with('service')
            ->whereNotNull('service_id')
            ->whereHas('service', fn ($q) => $q->where('is_active', true))
            ->latest());

        $projectBlogs = $allProjectBlogs->take(config('frontend.projects.home_limit', 6));

        $projectSchemaLd = ProjectSchema::itemList($projectBlogs);

        $faqIds = FrontendCache::remember('home.faq-ids', fn () => Service::query()
            ->where('is_active', true)
            ->whereHas('faqs', fn ($q) => $q->where('is_active', true))
            ->with(['faqs' => fn ($q) => $q
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->limit(1)])
            ->orderBy('id')
            ->get()
            ->map(fn (Service $service) => $service->faqs->first()?->id)
            ->filter()
            ->values()
            ->all());

        $faqs = $faqIds === []
            ? collect()
            : Faq::query()->whereIn('id', $faqIds)->get()
                ->sortBy(fn (Faq $faq) => array_search($faq->id, $faqIds, true))
                ->values();

        $faqItems = $faqs->map(fn (Faq $faq) => [
            'q' => $faq->question,
            'a' => nl2br(e($faq->answer)),
        ])->all();

        $mainSchemaLd = MainPageSchema::graph($homeServices, $faqs);

        $organizationSchemaLd = OrganizationSchema::graph(
            OrganizationSchema::extrasFromServices($services)
        );

        $galleryData = FrontendCache::remember('home.gallery', function () {
            $images = GalleryPresenter::firstPerLocation();

            return [
                'projects' => GalleryPresenter::toProjects(
                    $images->take(config('frontend.galleries.home_limit', 6))
                ),
                'total' => $images->count(),
            ];
        });
        $galleryProjects = $galleryData['projects'];
        $totalGalleryProjects = $galleryData['total'];

        return view('frontend.index', compact(
            'services',
            'homeServices',
            'allProjectBlogs',
            'projectBlogs',
            'projectSchemaLd',
            'mainSchemaLd',
            'organizationSchemaLd',
            'faqItems',
            'galleryProjects',
            'totalGalleryProjects',
        ));
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
