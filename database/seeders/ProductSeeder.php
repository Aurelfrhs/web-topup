<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Mobile Legends Products
        $mlProducts = [
            ['name' => '50 Diamond', 'price' => 15000],
            ['name' => '100 Diamond', 'price' => 28000],
            ['name' => '250 Diamond', 'price' => 68000],
            ['name' => '500 Diamond', 'price' => 135000],
            ['name' => '1000 Diamond', 'price' => 270000],
        ];

        foreach ($mlProducts as $product) {
            DB::table('products')->insert([
                'game_id' => 1,
                'name' => $product['name'],
                'description' => 'Top up ' . $product['name'] . ' Mobile Legends',
                'price' => $product['price'],
                'stock' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Free Fire Products
        $ffProducts = [
            ['name' => '50 Diamond', 'price' => 7000],
            ['name' => '100 Diamond', 'price' => 14000],
            ['name' => '250 Diamond', 'price' => 35000],
            ['name' => '500 Diamond', 'price' => 70000],
            ['name' => '1000 Diamond', 'price' => 140000],
        ];

        foreach ($ffProducts as $product) {
            DB::table('products')->insert([
                'game_id' => 2,
                'name' => $product['name'],
                'description' => 'Top up ' . $product['name'] . ' Free Fire',
                'price' => $product['price'],
                'stock' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // PUBG Mobile Products
        $pubgProducts = [
            ['name' => '60 UC', 'price' => 15000],
            ['name' => '325 UC', 'price' => 75000],
            ['name' => '660 UC', 'price' => 150000],
            ['name' => '1800 UC', 'price' => 400000],
        ];

        foreach ($pubgProducts as $product) {
            DB::table('products')->insert([
                'game_id' => 3,
                'name' => $product['name'],
                'description' => 'Top up ' . $product['name'] . ' PUBG Mobile',
                'price' => $product['price'],
                'stock' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
