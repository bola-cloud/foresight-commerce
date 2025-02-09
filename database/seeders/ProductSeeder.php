<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 2, 'ar_name' => 'الأجهزة الطبية', 'en_name' => 'Medical Devices'],
            ['id' => 3, 'ar_name' => 'أجهزة قياس الحرارة', 'en_name' => 'Thermometers'],
            ['id' => 4, 'ar_name' => 'أجهزة البخار', 'en_name' => 'Steam Inhalers'],
        ]);
        DB::table('products')->insert([
            [
                'ar_name' => 'جهاز قياس ضغط الدم',
                'en_name' => 'Blood Pressure Monitor',
                'category_id' => 1, // Replace with actual category ID
                'price' => 120.50,
                'quantity' => 50,
                'ar_description' => 'جهاز رقمي لقياس ضغط الدم بدقة وسهولة الاستخدام.',
                'en_description' => 'A digital blood pressure monitor for accurate and easy use.',
                'ar_features' => json_encode(["شاشة عرض كبيرة", "ذاكرة لقراءات متعددة", "مناسب لجميع الأعمار"]),
                'en_features' => json_encode(["Large display screen", "Memory for multiple readings", "Suitable for all ages"]),
                'ar_manufacturer' => 'شركة بيام الطبية',
                'en_manufacturer' => 'Pyam Medical Co.',
                'images' => json_encode([
                    [
                        'url' => 'http://127.0.0.1:8000/storage/products/bp_monitor_1.jpg',
                        'primary' => true,
                    ],
                    [
                        'url' => 'http://127.0.0.1:8000/storage/products/bp_monitor_2.jpg',
                        'primary' => false,
                    ],
                ]),
            ],
            [
                'ar_name' => 'مقياس الحرارة الرقمي',
                'en_name' => 'Digital Thermometer',
                'category_id' => 2, // Replace with actual category ID
                'price' => 45.75,
                'quantity' => 100,
                'ar_description' => 'مقياس حرارة رقمي سريع ودقيق.',
                'en_description' => 'A fast and accurate digital thermometer.',
                'ar_features' => json_encode(["قياس سريع ودقيق", "شاشة LED واضحة", "تصميم مريح"]),
                'en_features' => json_encode(["Quick and accurate measurement", "Clear LED display", "Ergonomic design"]),
                'ar_manufacturer' => 'شركة بيام الطبية',
                'en_manufacturer' => 'Pyam Medical Co.',
                'images' => json_encode([
                    [
                        'url' => 'http://127.0.0.1:8000/storage/products/thermometer_1.jpg',
                        'primary' => true,
                    ],
                    [
                        'url' => 'http://127.0.0.1:8000/storage/products/thermometer_2.jpg',
                        'primary' => false,
                    ],
                ]),
            ],
            [
                'ar_name' => 'جهاز استنشاق البخار',
                'en_name' => 'Steam Inhaler',
                'category_id' => 3, // Replace with actual category ID
                'price' => 230.00,
                'quantity' => 30,
                'ar_description' => 'جهاز استنشاق بخار مناسب لعلاج مشكلات الجهاز التنفسي.',
                'en_description' => 'A steam inhaler suitable for treating respiratory issues.',
                'ar_features' => json_encode(["سهولة الاستخدام", "مناسب للاستخدام المنزلي", "فعال في تحسين التنفس"]),
                'en_features' => json_encode(["Easy to use", "Suitable for home use", "Effective in improving breathing"]),
                'ar_manufacturer' => 'شركة بيام الطبية',
                'en_manufacturer' => 'Pyam Medical Co.',
                'images' => json_encode([
                    [
                        'url' => 'http://127.0.0.1:8000/storage/products/steam_inhaler_1.jpg',
                        'primary' => true,
                    ],
                    [
                        'url' => 'http://127.0.0.1:8000/storage/products/steam_inhaler_2.jpg',
                        'primary' => false,
                    ],
                ]),
            ],
        ]);

    }
}
