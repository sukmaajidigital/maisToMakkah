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

        $defaultRank = Rank::where('name', 'Member')->first();
        $directorRank = Rank::where('name', 'Director')->first();

        // --- LEVEL 0 (ROOT USER) ---
        $level0User = User::create([
            'name' => 'user',
            'longname' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'phone' => '081200000000',
            'bank_name' => 'BCA',
            'bank_account_number' => '1234567890',
            'bank_account_name' => 'Direktur Utama',
            'parent_id' => null,
            'rank_id' => $directorRank->id,
        ]);

        // --- LEVEL 1 ---
        $level1Users = collect();
        // Buat 5 downline langsung untuk user root
        for ($i = 1; $i <= 5; $i++) {
            $level1Users->push(User::factory()->create([
                'parent_id' => $level0User->id,
                'rank_id' => Rank::whereIn('name', ['Manager', 'Senior Manager'])->inRandomOrder()->first()->id,
            ]));
        }

        // --- LEVEL 2 ---
        $level2Users = collect();
        foreach ($level1Users as $parent) {
            // Setiap user level 1 punya 1-5 anak
            for ($i = 1; $i <= rand(1, 5); $i++) {
                $level2Users->push(User::factory()->create([
                    'parent_id' => $parent->id,
                    'rank_id' => $defaultRank->id,
                ]));
            }
        }

        // --- LEVEL 3 ---
        foreach ($level2Users as $parent) {
            if (rand(0, 1) === 1) {
                // Setiap user level 2 punya 1-5 anak
                for ($i = 1; $i <= rand(1, 5); $i++) {
                    User::factory()->create([
                        'parent_id' => $parent->id,
                        'rank_id' => $defaultRank->id,
                    ]);
                }
            }
        }
    }
}
