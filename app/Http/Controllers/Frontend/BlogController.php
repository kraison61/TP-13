<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Support\BlogPageSchema;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('service')
            ->whereNotNull('service_id')
            ->latest()
            ->paginate(12);

        $hero = [
            'eyebrow' => 'บทความ',
            'title' => 'บทความและผลงาน',
            'description' => 'บทความ ความรู้ และตัวอย่างผลงานก่อสร้างจากทีมงานของเรา',
            'badges' => [
                ['icon' => 'bi-journal-text', 'text' => $blogs->total().' บทความ'],
                ['icon' => 'bi-lightbulb', 'text' => 'ความรู้ก่อสร้าง'],
                ['icon' => 'bi-shield-check', 'text' => 'จากทีมงานจริง'],
            ],
        ];

        return view('frontend.blog.index', compact('blogs', 'hero'))->with('hideLayoutBreadcrumb', true);
    }

    public function show(string $slug)
    {
        $blog = Blog::with('service.category')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedBlogs = Blog::with('service')
            ->where('id', '!=', $blog->id)
            ->when($blog->service_id, fn ($q) => $q->where('service_id', $blog->service_id))
            ->latest()
            ->limit(3)
            ->get();

        $blogSchemaLd = BlogPageSchema::graph($blog);

        $breadcrumbCurrent = $blog->title;

        return view('frontend.blog.show', compact('blog', 'relatedBlogs', 'blogSchemaLd', 'breadcrumbCurrent'));
    }
}
