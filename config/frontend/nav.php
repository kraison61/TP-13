<?php

/**
 * เมนูนำทางหลัก (Nav)
 * เรียกใช้: config('frontend.nav')
 *
 * dropdown: 'services' → ดึงหมวดหมู่ + บริการย่อยจาก DB เป็น nested dropdown (+ dropdown_extra ถ้ามี)
 */
return [
    ['label' => 'รับเหมาก่อสร้าง', 'url' => 'home', 'type' => 'route'],
    [
        'label' => 'บริการก่อสร้าง',
        'url' => 'frontend.services.index',
        'type' => 'route',
        'dropdown' => 'services',
        'dropdown_extra' => [
            [
                'label' => 'คำนวณดินถม',
                'url' => 'frontend.services.calculate',
                'type' => 'route',
                'icon' => 'bi-calculator',
            ],
        ],
    ],
    ['label' => 'คลังผลงาน', 'url' => 'frontend.galleries.index', 'type' => 'route'],
    ['label' => 'บทความและผลงาน', 'url' => 'blog.index', 'type' => 'route'],
    ['label' => 'เกี่ยวกับเรา', 'url' => 'about-us', 'type' => 'route'],
    ['label' => 'ติดต่อเรา', 'url' => 'contact-us', 'type' => 'route'],
];
