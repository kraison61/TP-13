<?php

/**
 * เมนูนำทางหลัก (Nav)
 * เรียกใช้: config('frontend.nav')
 *
 * dropdown: 'services' → ดึงรายการบริการย่อยจาก DB อัตโนมัติ
 */
return [
    ['label' => 'รับเหมาก่อสร้าง', 'url' => 'home', 'type' => 'route'],
    [
        'label' => 'บริการก่อสร้าง',
        'url' => 'frontend.services.index',
        'type' => 'route',
        'dropdown' => 'services',
    ],
    ['label' => 'คลังผลงาน', 'url' => 'frontend.galleries.index', 'type' => 'route'],
    ['label' => 'บทความและผลงาน', 'url' => 'blog.index', 'type' => 'route'],
    ['label' => 'ติดต่อเรา', 'url' => 'contact-us', 'type' => 'route'],
];
