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

        return view('frontend.blog.index', compact('blogs'));
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

        return view('frontend.blog.show', compact('blog', 'relatedBlogs', 'blogSchemaLd'));
    }
}
