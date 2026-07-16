<?php

return [
    'title_suffix' => 'รับเหมาก่อสร้างครบวงจร',
    'robots' => 'index, follow',
    'twitter_card' => 'summary_large_image',
    'locale' => 'th_TH',
    'site_name' => null, // null = config('company.brand')

    'defaults' => [
        'title' => null, // built from brand + suffix
        'description' => null, // uses config('frontend.schema.description')
        'keywords' => null,
        'image' => null, // uses config('frontend.schema.image')
    ],

    'pages' => [
        'home' => [
            'title' => 'รับเหมาก่อสร้างครบวงจร',
            'description' => null,
            'keywords' => 'รับเหมาก่อสร้าง, งานโยธา, กำแพงกันดิน, รั้วบ้าน, กรุงเทพ, ปริมณฑล',
        ],
        'frontend.services.index' => [
            'title' => 'บริการทั้งหมด',
            'description' => 'งานก่อสร้างนอกตัวบ้านครบจบในที่เดียว — กำแพงกันดิน รั้วบ้าน ถนน ลานคอนกรีต ระบายน้ำ และปรับพื้นที่ ในกรุงเทพฯ และปริมณฑล',
            'keywords' => 'บริการก่อสร้าง, รับเหมาก่อสร้าง, งานนอกตัวบ้าน, กำแพงกันดิน, รั้วบ้าน',
        ],
        'frontend.blog.index' => [
            'title' => 'บทความและผลงาน',
            'description' => 'บทความ ความรู้ และตัวอย่างผลงานก่อสร้างจากทีมงานของเรา',
            'keywords' => 'บทความก่อสร้าง, ความรู้งานโยธา, ผลงานก่อสร้าง',
        ],
        'blog.index' => [
            'title' => 'บทความและผลงาน',
            'description' => 'บทความ ความรู้ และตัวอย่างผลงานก่อสร้างจากทีมงานของเรา',
            'keywords' => 'บทความก่อสร้าง, ความรู้งานโยธา, ผลงานก่อสร้าง',
        ],
        'frontend.galleries.index' => [
            'title' => 'คลังผลงาน',
            'description' => 'ผลงานที่เราภาคภูมิใจ — โครงการก่อสร้างและวิศวกรรมทั่วประเทศไทย',
            'keywords' => 'ผลงานก่อสร้าง, คลังผลงาน, โครงการก่อสร้าง',
        ],
        'frontend.projects.index' => [
            'title' => 'ผลงานและโครงการ',
            'description' => 'ตัวอย่างผลงานก่อสร้างและโครงการจากทีมงานของเรา',
            'keywords' => 'ผลงานก่อสร้าง, โครงการก่อสร้าง',
        ],
        'contact-us' => [
            'title' => 'ติดต่อเรา',
            'description' => 'ติดต่อสอบถาม ขอใบเสนอราคา หรือนัดสำรวจหน้างานฟรี — ทีมงานพร้อมให้คำปรึกษา',
            'keywords' => 'ติดต่อรับเหมาก่อสร้าง, ขอใบเสนอราคา, สำรวจหน้างาน',
        ],
        'about-us' => [
            'title' => 'เกี่ยวกับเรา',
            'description' => 'ทำความรู้จักทีมงานและประสบการณ์การให้บริการรับเหมาก่อสร้างครบวงจร',
            'keywords' => 'เกี่ยวกับเรา, รับเหมาก่อสร้าง, ประวัติบริษัท',
        ],
    ],
];
