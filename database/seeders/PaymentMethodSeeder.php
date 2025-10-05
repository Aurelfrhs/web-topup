<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            [
                'name' => 'Dana',
                'code' => 'DANA',
                'type' => 'ewallet',
                'fee_percent' => 1.5,
                'fee_fixed' => 0,
                'is_active' => true,
                'instructions' => 'Gunakan aplikasi DANA untuk melakukan pembayaran ke nomor tujuan yang tertera.',
            ],
            [
                'name' => 'OVO',
                'code' => 'OVO',
                'type' => 'ewallet',
                'fee_percent' => 1.5,
                'fee_fixed' => 0,
                'is_active' => true,
                'instructions' => 'Gunakan aplikasi OVO untuk melakukan pembayaran ke nomor tujuan yang tertera.',
            ],
            [
                'name' => 'Bank BCA',
                'code' => 'BCA',
                'type' => 'bank',
                'fee_percent' => 0,
                'fee_fixed' => 1500,
                'is_active' => true,
                'instructions' => 'Transfer ke rekening BCA yang tertera di halaman pembayaran.',
            ],
            [
                'name' => 'QRIS',
                'code' => 'QRIS',
                'type' => 'qris',
                'fee_percent' => 0.7,
                'fee_fixed' => 0,
                'is_active' => true,
                'instructions' => 'Scan QRIS menggunakan aplikasi e-wallet pilihan Anda.',
            ],
        ]);
    }
}
