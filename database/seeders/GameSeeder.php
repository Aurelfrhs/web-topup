<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            [
                'name' => 'Mobile Legends',
                'slug' => 'mobile-legends',
                'category' => 'MOBA',
                'description' => 'Game MOBA terpopuler di Indonesia. Top up diamond Mobile Legends murah dan cepat.',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Free Fire',
                'slug' => 'free-fire',
                'category' => 'Battle Royale',
                'description' => 'Battle Royale terfavorit. Top up diamond Free Fire dengan harga termurah.',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'PUBG Mobile',
                'slug' => 'pubg-mobile',
                'category' => 'Battle Royale',
                'description' => 'Game Battle Royale realistis. Top up UC PUBG Mobile instant dan aman.',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Genshin Impact',
                'slug' => 'genshin-impact',
                'category' => 'RPG',
                'description' => 'Open-world action RPG. Top up Genesis Crystal Genshin Impact termurah.',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Valorant',
                'slug' => 'valorant',
                'category' => 'FPS',
                'description' => 'Tactical shooter dari Riot Games. Top up VP Valorant murah dan cepat.',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Call of Duty Mobile',
                'slug' => 'call-of-duty-mobile',
                'category' => 'FPS',
                'description' => 'FPS mobile terbaik. Top up CP COD Mobile dengan harga terjangkau.',
                'image' => null,
                'is_active' => true,
            ],
        ];

        foreach ($games as $game) {
            DB::table('games')->insert(array_merge($game, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}