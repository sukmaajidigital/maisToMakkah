<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan eksekusi sangat penting
        $this->call([
            AdminSeeder::class,
            RankSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,         // Membuat struktur jaringan
            TransactionSeeder::class,  // Mensimulasikan aktivitas (transaksi, bonus, klaim)
        ]);
    }
}
