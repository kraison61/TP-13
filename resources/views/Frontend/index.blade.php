@php
$steps = [
    ['icon'=>'bi-chat-left-text','label'=>'STEP 01','title'=>'ปรึกษา & สำรวจหน้างาน','desc'=>'นัดเข้าวัดหน้างานฟรีภายใน 3 วัน พร้อมคำแนะนำจากวิศวกร'],
    ['icon'=>'bi-rulers',         'label'=>'STEP 02','title'=>'ออกแบบ & เสนอราคา',     'desc'=>'ส่งแบบโครงสร้างพร้อม BOQ ละเอียดทุกรายการใน 5–7 วันทำการ'],
    ['icon'=>'bi-cone-striped',   'label'=>'STEP 03','title'=>'ก่อสร้างจริง',           'desc'=>'เริ่มงานพร้อมรายงานความคืบหน้ารายสัปดาห์ + รูปถ่ายในพอร์ทัล'],
    ['icon'=>'bi-shield-check',   'label'=>'STEP 04','title'=>'ส่งมอบ & รับประกัน',    'desc'=>'ตรวจรับงานพร้อมเจ้าของบ้าน รับประกันงานก่อสร้าง 2 ปีเต็ม'],
];
@endphp

@extends('layouts.frontend')

@section('content')



{{-- ============ HERO ============ --}}
<x-frontend.hero layout="home" />

{{-- ============ TRUST STRIP ============ --}}
<!-- <x-frontend.trust /> -->

{{-- ============ SERVICES ============ --}}
<x-frontend.services :services="$services" />

{{-- ============ STATS ============ --}}
<x-frontend.stats />

{{-- ============ PROJECTS ============ --}}
<x-frontend.projects
    :blogs="$projectBlogs"
    :total-projects="$allProjectBlogs->count()"
    :filter-services="$filterServices"
/>

@if (! empty($mainSchemaLd['@graph']))
<script type="application/ld+json">
{!! json_encode($mainSchemaLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endif

@if (! empty($projectSchemaLd['itemListElement']))
<script type="application/ld+json">
{!! json_encode($projectSchemaLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endif

{{-- ============ PROCESS ============ --}}
<x-frontend.process :steps="$steps" />

{{-- ============ TESTIMONIALS ============ --}}
@if (! empty($testimonials))
<x-frontend.testimonials :testimonials="$testimonials" :testiTabs="$testiTabs" />
@endif

{{-- ============ FAQ ============ --}}
<x-frontend.faq :faqs="$faqItems" />


@endsection