<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceProduct;
use Illuminate\Database\Seeder;

class ServiceProductSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->productsBySlug() as $slug => $products) {
            $service = Service::query()->where('slug', $slug)->first();

            if (! $service) {
                continue;
            }

            foreach ($products as $index => $product) {
                ServiceProduct::query()->updateOrCreate(
                    [
                        'service_id' => $service->id,
                        'name' => $product['name'],
                    ],
                    [
                        'description' => $product['description'],
                        'image' => $product['image'],
                        'affiliate_link' => $product['affiliate_link'],
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ],
                );
            }
        }
    }

    /**
     * @return array<string, list<array{name: string, description: string, image: string, affiliate_link: string}>>
     */
    private function productsBySlug(): array
    {
        return [
            'landfill' => [
                [
                    'name' => 'ดินถมบดอัดแน่น',
                    'description' => 'ดินถมคุณภาพ สำหรับงานถมพื้นที่',
                    'image' => 'https://placehold.co/40x40/0a3d62/ffffff?text=ดิน',
                    'affiliate_link' => 'https://shopee.co.th/search?keyword=ดินถม',
                ],
                [
                    'name' => 'Geotextile กันดิน',
                    'description' => 'ผ้าใยสังเคราะห์กันดินร่วง',
                    'image' => 'https://placehold.co/40x40/071a2c/ffffff?text=Geo',
                    'affiliate_link' => 'https://shopee.co.th/search?keyword=geotextile',
                ],
                [
                    'name' => 'เครื่องบดอัดดิน',
                    'description' => 'เครื่องบดอัดดินเช่า/ซื้อ',
                    'image' => 'https://placehold.co/40x40/ffc83a/071a2c?text=บด',
                    'affiliate_link' => 'https://shopee.co.th/search?keyword=เครื่องบดอัดดิน',
                ],
            ],
            'pile' => [
                [
                    'name' => 'เสาเข็มคอนกรีต',
                    'description' => 'เสาเข็มสำเร็จรูป สำหรับงานฐานราก',
                    'image' => 'https://placehold.co/40x40/0a3d62/ffffff?text=เสา',
                    'affiliate_link' => 'https://shopee.co.th/search?keyword=เสาเข็มคอนกรีต',
                ],
                [
                    'name' => 'ปูนซีเมนต์ตราเสือ',
                    'description' => 'ปูนซีเมนต์สำหรับงานเทฐานราก',
                    'image' => 'https://placehold.co/40x40/ef4444/ffffff?text=ปูน',
                    'affiliate_link' => 'https://shopee.co.th/search?keyword=ปูนซีเมนต์ตราเสือ',
                ],
            ],
            'building-demolish' => [
                [
                    'name' => 'หน้ากากกันฝุ่น N95',
                    'description' => 'อุปกรณ์ป้องกันฝุ่นระหว่างรื้อถอน',
                    'image' => 'https://placehold.co/40x40/071a2c/ffffff?text=N95',
                    'affiliate_link' => 'https://shopee.co.th/search?keyword=หน้ากาก%20N95',
                ],
                [
                    'name' => 'ถุงมือกันบาด',
                    'description' => 'ถุงมือนิรภัยสำหรับงานรื้อถอน',
                    'image' => 'https://placehold.co/40x40/36475a/ffffff?text=มือ',
                    'affiliate_link' => 'https://shopee.co.th/search?keyword=ถุงมือกันบาด',
                ],
                [
                    'name' => 'เครื่องตัดคอนกรีต',
                    'description' => 'เครื่องตัดคอนกรีตสำหรับงานรื้อถอน',
                    'image' => 'https://placehold.co/40x40/0a3d62/ffffff?text=ตัด',
                    'affiliate_link' => 'https://shopee.co.th/search?keyword=เครื่องตัดคอนกรีต',
                ],
            ],
            'landjustment' => [
                [
                    'name' => 'เลเซอร์ระดับ',
                    'description' => 'เครื่องวัดระดับสำหรับงานปรับพื้นที่',
                    'image' => 'https://placehold.co/40x40/0a3d62/ffffff?text=เลเซอร์',
                    'affiliate_link' => 'https://shopee.co.th/search?keyword=เลเซอร์ระดับ',
                ],
                [
                    'name' => 'เชือกวัดระดับ',
                    'description' => 'อุปกรณ์วัดระดับพื้นดิน',
                    'image' => 'https://placehold.co/40x40/071a2c/ffffff?text=เชือก',
                    'affiliate_link' => 'https://shopee.co.th/search?keyword=เชือกวัดระดับ',
                ],
            ],
        ];
    }
}
