<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $news = [
            [
                'title' => 'Promo Diskon 20% Untuk Semua Game',
                'slug' => 'promo-diskon-20-untuk-semua-game',
                'content' => 'Dapatkan diskon hingga 20% untuk semua top up game favorit Anda. Promo berlaku mulai hari ini hingga akhir bulan. Jangan lewatkan kesempatan emas ini untuk top up dengan harga termurah!',
                'image' => null,
                'is_active' => true,
            ],
            [
                'title' => 'Update Harga Terbaru Mobile Legends',
                'slug' => 'update-harga-terbaru-mobile-legends',
                'content' => 'Kami telah memperbarui harga top up Mobile Legends untuk memberikan harga terbaik kepada Anda. Cek harga terbaru sekarang dan nikmati top up diamond dengan harga lebih murah!',
                'image' => null,
                'is_active' => true,
            ],
            [
                'title' => 'Tips Aman Melakukan Top Up Game Online',
                'slug' => 'tips-aman-melakukan-top-up-game-online',
                'content' => 'Keamanan adalah prioritas utama kami. Berikut adalah beberapa tips untuk melakukan top up game dengan aman: 1. Pastikan situs resmi, 2. Jangan share password, 3. Gunakan metode pembayaran terpercaya.',
                'image' => null,
                'is_active' => true,
            ],
        ];

        foreach ($news as $item) {
            DB::table('news')->insert(array_merge($item, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
