<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loker;

class LokerSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat 20 loker
        for ($i = 1; $i <= 20; $i++) {
            Loker::create([
                'nomor_loker' => $i,
                'status' => 'kosong',
            ]);
        }
    }
}
