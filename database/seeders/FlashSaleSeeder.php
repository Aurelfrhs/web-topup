<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FlashSaleSeeder extends Seeder
{
    public function run(): void
    {
        $flashSales = [
            [
                'product_id' => 1, // 50 Diamond ML
                'original_price' => 15000,
                'discount_percentage' => 20,
                'discounted_price' => 12000,
                'stock' => 100,
                'sold' => 0,
                'start_time' => Carbon::now()->subDays(1),
                'end_time' => Carbon::now()->addDays(7),
                'is_active' => true,
            ],
            [
                'product_id' => 3, // 250 Diamond ML
                'original_price' => 68000,
                'discount_percentage' => 15,
                'discounted_price' => 57800,
                'stock' => 50,
                'sold' => 0,
                'start_time' => Carbon::now()->subDays(2),
                'end_time' => Carbon::now()->addDays(5),
                'is_active' => true,
            ],
            [
                'product_id' => 6, // 50 Diamond FF
                'original_price' => 7000,
                'discount_percentage' => 25,
                'discounted_price' => 5250,
                'stock' => 200,
                'sold' => 0,
                'start_time' => Carbon::now()->subHours(12),
                'end_time' => Carbon::now()->addDays(3),
                'is_active' => true,
            ],
            [
                'product_id' => 11, // 60 UC PUBG
                'original_price' => 15000,
                'discount_percentage' => 10,
                'discounted_price' => 13500,
                'stock' => 75,
                'sold' => 0,
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addDays(2),
                'is_active' => true,
            ],
            // Flash Sale yang akan datang (upcoming)
            [
                'product_id' => 5, // 1000 Diamond ML
                'original_price' => 270000,
                'discount_percentage' => 30,
                'discounted_price' => 189000,
                'stock' => 25,
                'sold' => 0,
                'start_time' => Carbon::now()->addDays(3),
                'end_time' => Carbon::now()->addDays(10),
                'is_active' => true,
            ],
        ];

        foreach ($flashSales as $flashSale) {
            DB::table('flash_sales')->insert(array_merge($flashSale, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}