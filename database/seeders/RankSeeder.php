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
            ['name' => 'Member', 'min_downline_count' => 0, 'transaction_bonus' => 5000],
            ['name' => 'Leader', 'min_downline_count' => 10, 'transaction_bonus' => 10000],
            ['name' => 'Manager', 'min_downline_count' => 50, 'transaction_bonus' => 15000],
            ['name' => 'Director', 'min_downline_count' => 200, 'transaction_bonus' => 25000],
        ];

        foreach ($ranks as $rank) {
            Rank::create($rank);
        }
    }
}
