<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@dprd.com',
            'password' => Hash::make('admin1597'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Supervisor',
            'email' => 'svisor@dprd.com',
            'password' => Hash::make('supervisor1597'),
            'role' => 'supervisor',
            'email_verified_at' => now(),
        ]);
    }
} 