<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Blog;
use App\Support\BlogPageSchema;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
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

    return view('frontend.projects.index', compact('blogs', 'hero'))->with('hideLayoutBreadcrumb', true);
    }
}
