<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID user & produk yang sudah ada dari database
        $userIds = DB::table('users')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();

        // Jika salah satu kosong, hentikan seeder
        if (empty($userIds) || empty($productIds)) {
            $this->command->warn('⚠️ Tidak ada data users atau products. Jalankan UserSeeder dan ProductSeeder dulu.');
            return;
        }

        $orders = [];

        for ($i = 1; $i <= 10; $i++) {
            $orders[] = [
                'user_id' => $userIds[array_rand($userIds)],
                'product_id' => $productIds[array_rand($productIds)],

                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'game_user_id' => 'USER_' . rand(1000, 9999),
                'server_id' => 'S' . rand(1, 10),

                'amount' => rand(10000, 100000),
                'payment_method' => fake()->randomElement(['Dana', 'OVO', 'Bank Transfer', 'QRIS']),
                'status' => fake()->randomElement(['pending', 'processing', 'success', 'failed', 'refunded']),
                'note' => fake()->optional()->sentence(),

                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('orders')->insert($orders);
    }
}
