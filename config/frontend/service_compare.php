<?php

/**
 * คอลัมน์ตารางเปรียบเทียบบริการ
 * เรียกใช้: config('frontend.service_compare.columns')
 */
return [
    'columns' => [
        ['key' => 'title', 'label' => 'บริการ', 'align' => 'left'],
        ['key' => 'price', 'label' => 'ราคาเริ่มต้น', 'align' => 'center'],
        ['key' => 'unit', 'label' => 'หน่วย', 'align' => 'center'],
        ['key' => 'dur', 'label' => 'ระยะงาน', 'align' => 'center'],
        ['key' => 'warranty', 'label' => 'รับประกัน', 'align' => 'center'],
        ['key' => 'cert', 'label' => 'ใบ กว.', 'align' => 'center'],
    ],
];
