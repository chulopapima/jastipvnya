<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Trip;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class JastipSeeder extends Seeder
{
    public function run(): void
    {
        // Reset tabel trip & user dummy biar tidak bentrok
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Trip::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Buat Akun Jastiper Dummy
        $jastiper1 = User::firstOrCreate(
            ['email' => 'budi@jastip.com'],
            [
                'name' => 'Budi Jastip Tokyo',
                'password' => Hash::make('password'),
                'role' => 'jastiper',
                'no_hp' => '081234567890',
            ]
        );

        $jastiper2 = User::firstOrCreate(
            ['email' => 'siti@jastip.com'],
            [
                'name' => 'Siti Bangkok Express',
                'password' => Hash::make('password'),
                'role' => 'jastiper',
                'no_hp' => '089876543210',
            ]
        );

        // 2. Buat Contoh Trip Jastip Lengkap Foto URL Sampel
        Trip::create([
            'user_id' => $jastiper1->id,
            'destinasi' => 'Tokyo & Osaka, Jepang 🇯🇵',
            'tanggal_berangkat' => '2026-11-01',
            'tanggal_pulang' => '2026-11-10',
            'estimasi_fee' => 75000,
            'deskripsi' => 'Menerima jastip Sepatu Onitsuka Tiger, Figure Akihabara, Snacks Don Quijote, dan Baju Uniqlo Japan Limited!',
            'foto' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=600&q=80',
        ]);

        Trip::create([
            'user_id' => $jastiper2->id,
            'destinasi' => 'Bangkok, Thailand 🇹🇭',
            'tanggal_berangkat' => '2026-11-05',
            'tanggal_pulang' => '2026-11-12',
            'estimasi_fee' => 35000,
            'deskripsi' => 'Jastip Milk Tea Powder, Baju Bangkok Fashion Mall, Skincare Gentlewoman & Cosmetics!',
            'foto' => 'https://images.unsplash.com/photo-1508009603885-50cf7c579365?w=600&q=80',
        ]);

        Trip::create([
            'user_id' => $jastiper1->id,
            'destinasi' => 'Seoul, Korea Selatan 🇰🇷',
            'tanggal_berangkat' => '2026-11-15',
            'tanggal_pulang' => '2026-11-22',
            'estimasi_fee' => 50000,
            'deskripsi' => 'Open Jastip Skincare Olive Young, Album K-Pop, Hoodie & Streetwear Hongdae!',
            'foto' => 'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?w=600&q=80',
        ]);
    }
}