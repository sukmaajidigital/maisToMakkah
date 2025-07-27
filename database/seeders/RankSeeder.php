<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = [
            // Peringkat dasar, tanpa bonus transaksi
            ['name' => 'Member', 'min_downline_count' => 0, 'transaction_bonus' => 0],

            // Peringkat dengan bonus transaksi
            ['name' => 'Manager', 'min_downline_count' => 100, 'transaction_bonus' => 20000],
            ['name' => 'Senior Manager', 'min_downline_count' => 200, 'transaction_bonus' => 40000],
            ['name' => 'Executive Manager', 'min_downline_count' => 300, 'transaction_bonus' => 60000],
            ['name' => 'General Manager', 'min_downline_count' => 400, 'transaction_bonus' => 80000],
            ['name' => 'Director', 'min_downline_count' => 500, 'transaction_bonus' => 100000],
        ];

        foreach ($ranks as $rank) {
            Rank::create($rank);
        }
    }
}
