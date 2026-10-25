<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;
use App\Models\User;

class TripSeeder extends Seeder
{
    public function run()
    {
        // Cari akun jastiper (berdasarkan nama vanya atau user pertama)
        $jastiper = User::where('name', 'LIKE', '%vanya%')->first() ?? User::first();

        if (!$jastiper) {
            return; // Jika belum ada user sama sekali, hentikan
        }

        // 1. Trip Tokyo & Osaka, Jepang
        Trip::firstOrCreate(
            ['destinasi' => 'Tokyo & Osaka, Jepang'],
            [
                'user_id' => $jastiper->id,
                'estimasi_fee' => 150000,
                'tanggal_mulai' => '2026-11-10',
                'foto' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=600&q=80'
            ]
        );

        // 2. Trip Bangkok, Thailand
        Trip::firstOrCreate(
            ['destinasi' => 'Bangkok, Thailand'],
            [
                'user_id' => $jastiper->id,
                'estimasi_fee' => 100000,
                'tanggal_mulai' => '2026-11-15',
                'foto' => 'https://images.unsplash.com/photo-1508009603885-50cf7c579365?auto=format&fit=crop&w=600&q=80'
            ]
        );

        // 3. Trip Seoul, Korea Selatan
        Trip::firstOrCreate(
            ['destinasi' => 'Seoul, Korea Selatan'],
            [
                'user_id' => $jastiper->id,
                'estimasi_fee' => 120000,
                'tanggal_mulai' => '2026-11-20',
                'foto' => 'https://images.unsplash.com/photo-1538485399061-0703c43577d2?auto=format&fit=crop&w=600&q=80'
            ]
        );
    }
}