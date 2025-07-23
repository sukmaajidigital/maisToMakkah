<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rank;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Ambil rank paling dasar (Member)
        $defaultRank = Rank::where('name', 'Member')->first();

        // --- LEVEL MASTER ---
        $level0User = User::create([
            'name' => 'user',
            'longname' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'phone' => '081200000000',
            'bank_name' => 'BCA',
            'bank_account_number' => '1234567890',
            'bank_account_name' => 'Super Admin',
            'parent_id' => null,
            'rank_id' => Rank::where('name', 'Director')->first()->id, // Rank tertinggi
        ]);

        // --- LEVEL 1 ---
        $level1Users = collect();
        for ($i = 1; $i <= 3; $i++) {
            $level1Users->push(User::factory()->create([
                'parent_id' => $level0User->id,
                'rank_id' => Rank::inRandomOrder()->first()->id,
            ]));
        }

        // --- LEVEL 2 ---
        $level2Users = collect();
        foreach ($level1Users as $parent) {
            for ($i = 1; $i <= rand(2, 4); $i++) { // Setiap user level 1 punya 2-4 anak
                $level2Users->push(User::factory()->create([
                    'parent_id' => $parent->id,
                    'rank_id' => $defaultRank->id,
                ]));
            }
        }

        // --- LEVEL 3 ---
        $level3Users = collect();
        foreach ($level2Users as $parent) {
            // Tidak semua user level 2 punya anak, untuk variasi
            if (rand(0, 1) === 1) {
                for ($i = 1; $i <= rand(1, 3); $i++) {
                    $level3Users->push(User::factory()->create([
                        'parent_id' => $parent->id,
                        'rank_id' => $defaultRank->id,
                    ]));
                }
            }
        }

        // --- LEVEL 4 ---
        foreach ($level3Users as $parent) {
            // Tidak semua user level 3 punya anak
            if (rand(0, 1) === 1) {
                for ($i = 1; $i <= rand(1, 2); $i++) {
                    User::factory()->create([
                        'parent_id' => $parent->id,
                        'rank_id' => $defaultRank->id,
                    ]);
                }
            }
        }
    }
}
