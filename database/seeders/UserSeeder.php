<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua user yang ada sebelumnya
        User::truncate();

        // Buat admin
        User::create([
            'name' => 'admin',
            'email' => 'rifdah31@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345'),
            'roles' => 'admin',
        ]);
    }
}
