<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@su-boutique.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin12345'),
                'role' => 'admin' // or 'is_admin' => 1 depending on your system
            ]
        );
    }
}
