<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\GalleryPresenter;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryPresenter::firstPerLocation();
        $projects = GalleryPresenter::toProjects($images);
        $categories = GalleryPresenter::categories($projects);

        $hero = [
            'current' => 'คลังผลงาน',
            'eyebrow' => 'ผลงานของเรา',
            'title' => 'คลังผลงาน',
            'description' => 'ผลงานที่เราภาคภูมิใจ — โครงการก่อสร้างและวิศวกรรมทั่วประเทศไทย',
            'badges' => [
                ['icon' => 'bi-images', 'text' => count($projects).' โครงการ'],
                ['icon' => 'bi-geo-alt', 'text' => 'ครอบคลุมทั่วประเทศ'],
                ['icon' => 'bi-shield-check', 'text' => 'รับประกันงาน 2 ปีเต็ม'],
                ['icon' => 'bi-award', 'text' => 'ใบอนุญาตก่อสร้าง ระดับ ค'],
            ],
        ];

        return view('frontend.galleries.index', compact('categories', 'projects', 'hero'))
            ->with('hideLayoutBreadcrumb', true);
    }

    public function show(string $slug)
    {
        $location = GalleryPresenter::resolveLocationFromSlug($slug);

        abort_unless($location, 404);

        $detail = GalleryPresenter::formatDetail($location);
        $proj = $detail['proj'];
        $stats = $detail['stats'];
        $photos = $detail['photos'];
        $total = count($photos);

        abort_if($total === 0, 404);

        $hero = [
            'current' => $proj['title'],
            'eyebrow' => $proj['category'],
            'title' => $proj['title'],
            'description' => $proj['description'],
            'badges' => [
                ['icon' => 'bi-images', 'text' => number_format($total).' ภาพ'],
                ['icon' => 'bi-geo-alt', 'text' => $proj['province']],
                ['icon' => 'bi-shield-check', 'text' => 'รับประกันงาน 2 ปีเต็ม'],
            ],
        ];

        return view('frontend.galleries.show', compact('proj', 'stats', 'photos', 'total', 'hero'))
            ->with('hideLayoutBreadcrumb', true);
    }
}
