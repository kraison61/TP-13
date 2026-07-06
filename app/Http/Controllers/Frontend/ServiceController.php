<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services=Service::all();
        // สร้าง Array เก็บข้อมูลบริการแต่ละหัวข้อ
        // $services = [
        //     [
        //         'slug' => 'wall',
        //         'title' => 'กำแพงกันดิน',
        //         'description' => 'กำแพงคอนกรีตเสริมเหล็กสำหรับกันดินพัง กั้นน้ำ และปรับระดับพื้นที่ คำนวณโครงสร้างโดยวิศวกรโยธา...',
        //         'price' => '2,800',
        //         'unit' => 'บาท/ตร.ม.',
        //         'duration' => '14–30',
        //         'features' => [
        //             'สำรวจและออกแบบโครงสร้าง', 'คำนวณโดยวิศวกรโยธา', 'เข็มเจาะ หรือเข็มตอก', 'รับประกันโครงสร้าง 2 ปี'
        //         ],
        //         'image' => 'https://images.unsplash.com/photo-1517089596392-fb9a9033e05b?w=900&q=80&auto=format&fit=crop',
        //         'icon' => 'bi-bricks',
        //     ],
        //     [
        //         'slug' => 'fence',
        //         'title' => 'รั้วบ้าน',
        //         'description' => 'รั้วสำเร็จรูป รั้วก่ออิฐฉาบปูน รั้วโมเดิร์น รั้วเหล็กดัด พร้อมประตูและระบบรีโมทอัตโนมัติ...',
        //         'price' => '1,500',
        //         'unit' => 'บาท/ตร.ม.',
        //         'duration' => '7–21',
        //         'features' => [
        //             'รั้วก่ออิฐมอญ / บล็อกปูน', 'รั้วสำเร็จรูป Precast', 'ประตูบานเลื่อน / บานสวิง + รีโมท', 'รับประกันงาน 2 ปี'
        //         ],
        //         'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=900&q=80&auto=format&fit=crop',
        //         'icon' => 'bi-grid-3x3',
        //     ],
        //     // คุณสามารถคัดลอกข้อมูล ถนน, ลานคอนกรีต, ระบายน้ำ มาเพิ่มเป็นก้อน Array แบบด้านบนได้เลยครับ
        // ];

        // ส่งตัวแปร $services ไปให้ไฟล์ View ที่ชื่อว่า resources/views/services/index.blade.php
        return view('frontend.services.index', ['services' => $services]);
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
