<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAndAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'user',
            'longname' => 'User Long Name',
            'email' => 'user@example.com',
            'phone' => '081234567890',
            'bank_name' => 'BCA',
            'bank_account_name' => 'User Long Name',
            'bank_account_number' => '1234567890',
            'password' => bcrypt('user123'),
        ]);

        \App\Models\Admin::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
