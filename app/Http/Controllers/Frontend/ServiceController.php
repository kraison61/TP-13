<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Service;

use App\Http\Controllers\Controller;
use App\Support\ServicePageSchema;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::query()
            ->with(['prices', 'activePrice', 'scopes'])
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        $compareColumns = config('frontend.service_compare.columns');

        $hero = [
            'current' => 'บริการทั้งหมด',
            'eyebrow' => 'บริการของเรา',
            'title' => 'งานก่อสร้างนอกตัวบ้าน<br/>ครบจบในที่เดียว',
            'description' => 'ทีมช่างเฉพาะทาง ' . config('company.team_size') . ' คน รับงานตั้งแต่โปรเจกต์เล็ก 5 ตร.ม. ถึงโครงการขนาดใหญ่ — ในเขตกรุงเทพฯ และปริมณฑล พร้อมรับประกันงาน 2 ปี',
            'badges' => [
                ['icon' => 'bi-clock', 'text' => 'สำรวจหน้างานฟรี ภายใน 3 วัน'],
                ['icon' => 'bi-shield-check', 'text' => 'รับประกันงาน 2 ปีเต็ม'],
                ['icon' => 'bi-file-earmark-text', 'text' => 'BOQ ละเอียดทุกรายการ'],
                ['icon' => 'bi-award', 'text' => 'ใบอนุญาตก่อสร้าง ระดับ ค'],
            ],
        ];

        return view('frontend.services.index', compact('services', 'compareColumns', 'hero'))
            ->with('hideLayoutBreadcrumb', true);
        // return "services";
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
    public function show(string $slug)
    {
        $service = Service::query()
            ->with([
                'activePrice',
                'activePrices',
                'scopes',
                'category',
                'faqs' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order'),
            ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $otherServices = Service::query()
            ->with('activePrice')
            ->where('is_active', true)
            ->where('id', '!=', $service->id)
            ->orderBy('id')
            ->get();

        $portfolios = $service->portfolios()
            ->latest()
            ->limit(3)
            ->get();

        $steps = [
            ['icon' => 'bi-chat-left-text', 'label' => 'STEP 01', 'title' => 'ปรึกษา & สำรวจหน้างาน', 'desc' => 'นัดเข้าวัดหน้างานฟรีภายใน 3 วัน พร้อมคำแนะนำจากวิศวกร'],
            ['icon' => 'bi-rulers', 'label' => 'STEP 02', 'title' => 'ออกแบบ & เสนอราคา', 'desc' => 'ส่งแบบโครงสร้างพร้อม BOQ ละเอียดทุกรายการใน 5–7 วันทำการ'],
            ['icon' => 'bi-cone-striped', 'label' => 'STEP 03', 'title' => 'ก่อสร้างจริง', 'desc' => 'เริ่มงานพร้อมรายงานความคืบหน้ารายสัปดาห์ + รูปถ่ายในพอร์ทัล'],
            ['icon' => 'bi-shield-check', 'label' => 'STEP 04', 'title' => 'ส่งมอบ & รับประกัน', 'desc' => 'ตรวจรับงานพร้อมเจ้าของบ้าน รับประกันงานก่อสร้าง 2 ปีเต็ม'],
        ];

        $serviceSchemaLd = ServicePageSchema::graph($service);

        $breadcrumbCurrent = $service->title;
        $breadcrumbParents = [
            ['label' => 'บริการทั้งหมด', 'url' => route('frontend.services.index')],
        ];

        return view('frontend.services.show', compact(
            'service',
            'otherServices',
            'portfolios',
            'steps',
            'serviceSchemaLd',
            'breadcrumbCurrent',
            'breadcrumbParents',
        ));
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
