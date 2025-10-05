<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Diskon 20% Semua Game',
                'description' => 'Promo spesial bulan ini',
                'image' => null,
                'link' => null,
                'position' => 'home',
                'is_active' => true,
            ],
            [
                'title' => 'Top Up Mobile Legends Termurah',
                'description' => 'Mulai dari 15 ribu',
                'image' => null,
                'link' => '/game/mobile-legends',
                'position' => 'home',
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            DB::table('banners')->insert(array_merge($banner, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}