<?php

/**
 * ป้ายกรองหมวดหมู่ผลงาน (ใช้ใน projects component)
 * key ต้องตรงกับ cat ใน config('frontend.projects')
 * เรียกใช้: config('frontend.filter_labels')
 */
return [
    'all'   => 'ทั้งหมด',
    'wall'  => 'กำแพงกันดิน',
    'fence' => 'รั้วบ้าน',
    'road'  => 'ถนน & ทางเข้า',
    'slab'  => 'ลานคอนกรีต',
    'drain' => 'ระบายน้ำ',
];
