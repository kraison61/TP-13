<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        $categories = [
            'ทั้งหมด',
            'อาคารพาณิชย์',
            'ที่อยู่อาศัย',
            'โครงสร้างพื้นฐาน',
            'อุตสาหกรรม',
            'ภูมิทัศน์',
        ];

        $projects = [
            ['slug' => 'one-bangkok-tower', 'title' => 'อาคารสำนักงาน One Bangkok Tower', 'category' => 'อาคารพาณิชย์', 'province' => 'กรุงเทพมหานคร', 'specs' => '45,000 ม²  ·  32 ชั้น  ·  LEED Gold', 'image' => 'https://picsum.photos/seed/bkk-tower/800/600', 'alt' => 'อาคารสำนักงาน One Bangkok Tower'],
            ['slug' => 'grand-chiangmai-village', 'title' => 'บ้านจัดสรร The Grand เชียงใหม่', 'category' => 'ที่อยู่อาศัย', 'province' => 'เชียงใหม่', 'specs' => '180 ยูนิต  ·  25 ไร่  ·  EIA ผ่านแล้ว', 'image' => 'https://picsum.photos/seed/cm-village/800/600', 'alt' => 'บ้านจัดสรร The Grand เชียงใหม่'],
            ['slug' => 'mun-river-bridge', 'title' => 'สะพานข้ามแม่น้ำมูล', 'category' => 'โครงสร้างพื้นฐาน', 'province' => 'นครราชสีมา', 'specs' => '1.2 กม.  ·  4 ช่องจราจร  ·  50 ปี', 'image' => 'https://picsum.photos/seed/mun-bridge/800/600', 'alt' => 'สะพานข้ามแม่น้ำมูล'],
            ['slug' => 'rayong-auto-parts', 'title' => 'โรงงานชิ้นส่วนยานยนต์ ระยอง', 'category' => 'อุตสาหกรรม', 'province' => 'ระยอง', 'specs' => '12,000 ม²  ·  Clean Room  ·  ISO 9001', 'image' => 'https://picsum.photos/seed/rayong-plant/800/600', 'alt' => 'โรงงานชิ้นส่วนยานยนต์ ระยอง'],
            ['slug' => 'phuket-central-park', 'title' => 'สวนสาธารณะ Phuket Central Park', 'category' => 'ภูมิทัศน์', 'province' => 'ภูเก็ต', 'specs' => '8 ไร่  ·  3,200 ต้น  ·  Smart Irrigation', 'image' => 'https://picsum.photos/seed/phuket-park/800/600', 'alt' => 'สวนสาธารณะ Phuket Central Park'],
            ['slug' => 'kk-central-mall', 'title' => 'ศูนย์การค้า KK Central', 'category' => 'อาคารพาณิชย์', 'province' => 'ขอนแก่น', 'specs' => '85,000 ม²  ·  5 ชั้น  ·  2,000 คัน', 'image' => 'https://picsum.photos/seed/kk-mall/800/600', 'alt' => 'ศูนย์การค้า KK Central'],
            ['slug' => 'sathorn-skyline', 'title' => 'คอนโดมิเนียม Sathorn Skyline', 'category' => 'ที่อยู่อาศัย', 'province' => 'กรุงเทพมหานคร', 'specs' => '320 ยูนิต  ·  45 ชั้น  ·  Infinity Pool', 'image' => 'https://picsum.photos/seed/sathorn-sky/800/600', 'alt' => 'คอนโดมิเนียม Sathorn Skyline'],
            ['slug' => 'chiangrai-highway', 'title' => 'ถนนสายเชียงราย–แม่สาย', 'category' => 'โครงสร้างพื้นฐาน', 'province' => 'เชียงราย', 'specs' => '68 กม.  ·  4 ช่องจราจร', 'image' => 'https://picsum.photos/seed/cr-highway/800/600', 'alt' => 'ถนนสายเชียงราย–แม่สาย'],
            ['slug' => 'bangpu-industrial-ph3', 'title' => 'นิคมอุตสาหกรรมบางปู Phase 3', 'category' => 'อุตสาหกรรม', 'province' => 'สมุทรปราการ', 'specs' => '400 ไร่  ·  EIA ผ่าน  ·  Waste Water', 'image' => 'https://picsum.photos/seed/bangpu-ind3/800/600', 'alt' => 'นิคมอุตสาหกรรมบางปู Phase 3'],
        ];

        $hero = [
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
}
