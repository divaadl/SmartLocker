<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Locker;

class coba extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'kode_loker' => str_pad($i, 2, '0', STR_PAD_LEFT),
                'status' => 'kosong',
                'rfid' => null,
                'waktu_selesai' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Locker::insert($data);
    }
}
