@php
$testimonials = [
    [
        ['i'=>'ก','name'=>'คุณกชกร เลิศมงคล',     'project'=>'รั้วบ้านโมเดิร์น · ราชพฤกษ์',      'quote'=>'ทีมงานเป็นมืออาชีพมาก สื่อสารตรงไปตรงมา ราคาที่เสนอตรงตามที่จ่ายจริง รั้วโมเดิร์นที่ทำให้สวยมากค่ะ'],
        ['i'=>'ส','name'=>'คุณสมชาย ภักดี',        'project'=>'กำแพงกันดิน · บางใหญ่',            'quote'=>'กำแพงกันดินสูง 2.5 ม. ทำเสร็จก่อนกำหนด 3 วัน วิศวกรเข้ามาตรวจหน้างานทุกสัปดาห์ ราคายุติธรรมครับ'],
        ['i'=>'ป','name'=>'คุณปรียา วงศ์เจริญ',    'project'=>'ลานจอดรถ · นนทบุรี',              'quote'=>'ลานคอนกรีตขัดมันสวยตามแบบ ใช้จอดรถมา 2 ปี ไม่มีร้าวเลย คุ้มมาก แนะนำต่อให้เพื่อนบ้านแล้วค่ะ'],
    ],
    [
        ['i'=>'ธ','name'=>'คุณธีระ — Site Manager','project'=>'หมู่บ้านนวธารา · นวนคร',           'quote'=>'รั้วโครงการ 156 ม. ทำใน 24 วัน ไม่มีดราม่ากับลูกบ้าน เก็บงานเรียบร้อย ทำสัญญารอบสอง 2 โครงการแล้วครับ'],
        ['i'=>'ว','name'=>'คุณวีระชัย สุขใจ',      'project'=>'โครงการบ้านเดี่ยว · ปทุมธานี',    'quote'=>'งานถนนคอนกรีต 850 ตร.ม. ส่งมอบทันก่อนเปิดโครงการ เอกสารครบ ใบ กว. เซ็นถูกต้อง ทำงานง่ายมาก'],
    ],
    [
        ['i'=>'ม','name'=>'คุณมานพ ใจดี',           'project'=>'ถมที่ดิน 4 ไร่ · บางบัวทอง',     'quote'=>'ถมที่ 4 ไร่ บดอัดดีมาก ราคาคิดตามคิวจริงไม่โกง ขึ้นบ้านได้สบายๆ ไม่ทรุด ผ่านมา 3 ปียังแน่นเหมือนเดิม'],
        ['i'=>'อ','name'=>'คุณอุไรวรรณ ทองดี',     'project'=>'ระบบระบายน้ำ · ลาดกระบัง',       'quote'=>'วางท่อระบายน้ำรอบที่ดิน 86 เมตร แก้ปัญหาน้ำท่วมขังที่เป็นมานาน ทีมงานชี้แจงทุกขั้นตอน ราคาเป็นธรรม'],
    ],
];

$testiTabs    = ['บ้านพักอาศัย','โครงการหมู่บ้าน','เจ้าของที่ดิน'];
$steps = [
    ['icon'=>'bi-chat-left-text','label'=>'STEP 01','title'=>'ปรึกษา & สำรวจหน้างาน','desc'=>'นัดเข้าวัดหน้างานฟรีภายใน 3 วัน พร้อมคำแนะนำจากวิศวกร'],
    ['icon'=>'bi-rulers',         'label'=>'STEP 02','title'=>'ออกแบบ & เสนอราคา',     'desc'=>'ส่งแบบโครงสร้างพร้อม BOQ ละเอียดทุกรายการใน 5–7 วันทำการ'],
    ['icon'=>'bi-cone-striped',   'label'=>'STEP 03','title'=>'ก่อสร้างจริง',           'desc'=>'เริ่มงานพร้อมรายงานความคืบหน้ารายสัปดาห์ + รูปถ่ายในพอร์ทัล'],
    ['icon'=>'bi-shield-check',   'label'=>'STEP 04','title'=>'ส่งมอบ & รับประกัน',    'desc'=>'ตรวจรับงานพร้อมเจ้าของบ้าน รับประกันงานก่อสร้าง 2 ปีเต็ม'],
];
@endphp

@extends('layouts.frontend')

@section('content')

{{-- ============ BREADCRUMB (HOME) ============ --}}
<x-frontend.breadcrumb bar />

{{-- ============ HERO ============ --}}
<x-frontend.hero />

{{-- ============ TRUST STRIP ============ --}}
<x-frontend.trust />

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
<x-frontend.testimonials :testimonials="$testimonials" :testiTabs="$testiTabs" />

{{-- ============ FAQ ============ --}}
<x-frontend.faq :faqs="$faqItems" />


@endsection