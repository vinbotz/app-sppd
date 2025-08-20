<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
        ]);

        \App\Models\User::updateOrCreate([
            'email' => 'admin@dprd.com'
        ], [
            'name' => 'Admin',
            'password' => bcrypt('admin1597'),
            'role' => 'admin',
        ]);
        \App\Models\User::updateOrCreate([
            'email' => 'svisor@dprd.com'
        ], [
            'name' => 'Supervisor',
            'password' => bcrypt('supervisor1597'),
            'role' => 'supervisor',
        ]);
    }
}
