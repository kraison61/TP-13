<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Support\BlogPageSchema;
use App\Support\SeoMeta;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('service')
            ->whereNotNull('service_id')
            ->latest()
            ->paginate(12);

        $hero = [
            'current' => 'บทความ',
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
        $breadcrumbParents = [
            ['label' => 'บทความ', 'url' => route('blog.index')],
        ];

        $view = view('frontend.blog.show', compact(
            'blog',
            'relatedBlogs',
            'blogSchemaLd',
            'breadcrumbCurrent',
            'breadcrumbParents',
        ));

        if ($blog->slug === 'solar-cell-installation-price') {
            $seo = SeoMeta::forBlog($blog);
            $seo['title'] = 'ติดโซล่าเซลล์ ราคา คิดจากอะไร อ่านใบเสนอราคาก่อนเซ็น | ธีรพงษ์';
            $seo['og']['title'] = $seo['title'];
            $seo['twitter']['title'] = $seo['title'];
            $seo['keywords'] = 'ติดโซล่าเซลล์ ราคา, โซล่าเซลล์ 5kW ราคา, ราคาติดโซล่าเซลล์, ราคาติดโซล่าเซลล์บ้าน';
            $view->with('seo', $seo);
        }

        if ($blog->slug === 'solar-cell-10kw-production-price') {
            $seo = SeoMeta::forBlog($blog);
            $seo['title'] = 'โซล่าเซลล์ 10kW ผลิตไฟได้กี่หน่วย? เช็คราคาปี 2569';
            $seo['og']['title'] = $seo['title'];
            $seo['twitter']['title'] = $seo['title'];
            $seo['keywords'] = 'โซล่าเซลล์ 10kw ผลิตไฟได้กี่หน่วย, โซล่าเซลล์ 10kw ราคา, ราคาโซล่าเซลล์ 10kw, ติดตั้งโซล่าเซลล์ 10kw ราคา, โซล่าเซลล์ออฟกริด 10kw ราคา, โซล่าเซลล์ 10kw ใช้อะไรได้บ้าง';
            $view->with('seo', $seo);
        }

        if ($blog->slug === 'home-solar-cell-price-guide') {
            $seo = SeoMeta::forBlog($blog);
            $seo['title'] = 'บ้านโซล่าเซลล์ ติดขนาดไหนดี? เช็คราคาครบทุกขนาด ปี 2569';
            $seo['og']['title'] = $seo['title'];
            $seo['twitter']['title'] = $seo['title'];
            $seo['keywords'] = 'บ้านโซล่าเซลล์, ราคาติดตั้งโซล่าเซลล์บ้าน, ติดโซล่าเซลล์ 5kw ราคา, โซล่าเซลล์สำหรับบ้าน 1 หลัง, ติดโซล่าเซลล์ 3kw ราคา, ติดโซล่าเซลล์บ้านแบบไหนดี, ติดโซล่าเซลล์ 5000w ราคาถูก, โซล่าเซลล์พร้อมแบตเตอรี่ ราคา';
            $view->with('seo', $seo);
        }

        return $view;
    }
}
