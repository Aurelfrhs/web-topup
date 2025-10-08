<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 10 Game paling populer dan favorit di Indonesia
     */
    public function run(): void
    {
        $games = [
            // 1. Mobile Legends - Game MOBA Terpopuler #1 di Indonesia
            [
                'name' => 'Mobile Legends: Bang Bang',
                'slug' => 'mobile-legends',
                'category' => 'moba',
                'publisher' => 'Moonton',
                'description' => 'Game MOBA 5v5 paling populer di Indonesia dengan berbagai hero unik dan turnamen esports besar.',
                'image' => 'games/mobile-legends.jpg',
                'is_active' => true,
            ],

            // 2. Free Fire - Battle Royale Terpopuler di Indonesia
            [
                'name' => 'Free Fire',
                'slug' => 'free-fire',
                'category' => 'battle-royale',
                'publisher' => 'Garena',
                'description' => 'Battle royale 50 pemain dalam 10 menit. Ringan dan bisa dimainkan di HP spek rendah.',
                'image' => 'games/free-fire.jpg',
                'is_active' => true,
            ],

            // 3. PUBG Mobile - Battle Royale Realistis
            [
                'name' => 'PUBG Mobile',
                'slug' => 'pubg-mobile',
                'category' => 'battle-royale',
                'publisher' => 'Tencent Games',
                'description' => 'Battle royale realistis dengan grafis memukau. Bertahan hidup melawan 99 pemain lainnya.',
                'image' => 'games/pubg-mobile.jpg',
                'is_active' => true,
            ],

            // 4. Genshin Impact - Open World RPG Terbaik
            [
                'name' => 'Genshin Impact',
                'slug' => 'genshin-impact',
                'category' => 'mmorpg',
                'publisher' => 'HoYoverse',
                'description' => 'Open-world action RPG dengan grafis anime memukau. Jelajahi dunia Teyvat yang luas.',
                'image' => 'games/genshin-impact.jpg',
                'is_active' => true,
            ],

            // 5. Valorant - Tactical FPS Terpopuler
            [
                'name' => 'Valorant',
                'slug' => 'valorant',
                'category' => 'fps',
                'publisher' => 'Riot Games',
                'description' => 'Tactical FPS 5v5 dengan agent unik dan ability khusus. Strategi dan aim adalah kunci.',
                'image' => 'games/valorant.jpg',
                'is_active' => true,
            ],

            // 6. Honkai: Star Rail - Turn-Based RPG Terbaru
            [
                'name' => 'Honkai: Star Rail',
                'slug' => 'honkai-star-rail',
                'category' => 'mmorpg',
                'publisher' => 'HoYoverse',
                'description' => 'RPG luar angkasa dengan sistem turn-based strategis dan cerita yang menarik.',
                'image' => 'games/honkai-star-rail.jpg',
                'is_active' => true,
            ],

            // 7. Call of Duty Mobile - FPS All-in-One
            [
                'name' => 'Call of Duty Mobile',
                'slug' => 'cod-mobile',
                'category' => 'fps',
                'publisher' => 'Activision',
                'description' => 'FPS dengan mode multiplayer dan battle royale. Kualitas console di perangkat mobile.',
                'image' => 'games/cod-mobile.jpg',
                'is_active' => true,
            ],

            // 8. Clash of Clans - Strategy Game Legendaris
            [
                'name' => 'Clash of Clans',
                'slug' => 'clash-of-clans',
                'category' => 'others',
                'publisher' => 'Supercell',
                'description' => 'Game strategi legendaris. Bangun desa, latih pasukan, dan serang pemain lain.',
                'image' => 'games/clash-of-clans.jpg',
                'is_active' => true,
            ],

            // 9. Arena of Valor - MOBA Alternatif Terbaik
            [
                'name' => 'Arena of Valor',
                'slug' => 'arena-of-valor',
                'category' => 'moba',
                'publisher' => 'Garena',
                'description' => 'Game MOBA 5v5 dengan hero legendaris dari berbagai mitologi. Pertarungan cepat 10 menit.',
                'image' => 'games/aov.jpg',
                'is_active' => true,
            ],

            // 10. eFootball - Game Sepak Bola Terbaik
            [
                'name' => 'eFootball 2024',
                'slug' => 'efootball-2024',
                'category' => 'sports',
                'publisher' => 'Konami',
                'description' => 'Game sepak bola dengan grafis realistis. Bangun dream team dan rasakan sensasi nyata.',
                'image' => 'games/efootball.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($games as $game) {
            DB::table('games')->insert([
                'name' => $game['name'],
                'slug' => $game['slug'],
                'category' => $game['category'],
                'publisher' => $game['publisher'],
                'description' => $game['description'],
                'image' => $game['image'],
                'is_active' => $game['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('🎮 10 game favorit Indonesia berhasil ditambahkan!');
        $this->command->newLine();
        $this->command->info('📊 Statistik:');
        $this->command->info('   • MOBA: 2 games (Mobile Legends, Arena of Valor)');
        $this->command->info('   • Battle Royale: 2 games (Free Fire, PUBG Mobile)');
        $this->command->info('   • MMORPG: 2 games (Genshin Impact, Honkai Star Rail)');
        $this->command->info('   • FPS: 2 games (Valorant, COD Mobile)');
        $this->command->info('   • Sports: 1 game (eFootball 2024)');
        $this->command->info('   • Others: 1 game (Clash of Clans)');
    }
}