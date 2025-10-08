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
                'original_price' => 15000.00,
                'discount_percentage' => 20,
                'discounted_price' => 12000.00,
                'stock' => 100,
                'sold' => 0,
                'start_time' => Carbon::now()->subDays(1),
                'end_time' => Carbon::now()->addDays(7),
                'status' => 'active',
            ],
            [
                'product_id' => 3, // 250 Diamond ML
                'original_price' => 68000.00,
                'discount_percentage' => 15,
                'discounted_price' => 57800.00,
                'stock' => 50,
                'sold' => 0,
                'start_time' => Carbon::now()->subDays(2),
                'end_time' => Carbon::now()->addDays(5),
                'status' => 'active',
            ],
            [
                'product_id' => 6, // 50 Diamond FF
                'original_price' => 7000.00,
                'discount_percentage' => 25,
                'discounted_price' => 5250.00,
                'stock' => 200,
                'sold' => 0,
                'start_time' => Carbon::now()->subHours(12),
                'end_time' => Carbon::now()->addDays(3),
                'status' => 'active',
            ],
            [
                'product_id' => 11, // 60 UC PUBG
                'original_price' => 15000.00,
                'discount_percentage' => 10,
                'discounted_price' => 13500.00,
                'stock' => 75,
                'sold' => 0,
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addDays(2),
                'status' => 'active',
            ],
            // Flash Sale yang akan datang (upcoming)
            [
                'product_id' => 5, // 1000 Diamond ML
                'original_price' => 270000.00,
                'discount_percentage' => 30,
                'discounted_price' => 189000.00,
                'stock' => 25,
                'sold' => 0,
                'start_time' => Carbon::now()->addDays(3),
                'end_time' => Carbon::now()->addDays(10),
                'status' => 'active',
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
