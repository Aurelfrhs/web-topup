<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'name' => 'whatsapp_api_key',
                'value' => '123abc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'auto_refund',
                'value' => 'true',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'api_supplier_url',
                'value' => 'https://supplier.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
