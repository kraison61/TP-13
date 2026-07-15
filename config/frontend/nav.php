<?php

/**
 * เมนูนำทางหลัก (Nav)
 * เรียกใช้: config('frontend.nav')
 */
return [
    ['label' => 'หน้าแรก', 'url' => 'home', 'type' => 'route'],
    ['label' => 'บริการ', 'url' => 'frontend.services.index', 'type' => 'route'],
    ['label' => 'ผลงาน', 'url' => 'projects', 'type' => 'anchor'],
    ['label' => 'บทความ', 'url' => 'blog.index', 'type' => 'route'],
    ['label' => 'ทีมงาน', 'url' => 'about-us', 'type' => 'anchor'],
    ['label' => 'ติดต่อ', 'url' => 'contact-us', 'type' => 'route', 'icon' => 'bi-arrow-up-right'],
];
