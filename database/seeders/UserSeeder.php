<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario administrador principal
        User::create([
            'name' => 'Karen',
            'email' => 'management@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Cajero',
            'email' => 'cajero@gmail.com',
            'password' => Hash::make('cashier'),
            'role' => 'cashier',
        ]);

        // Algunos usuarios tipo cajero
        User::factory()->count(10)->create([
            'role' => 'cashier',
        ]);

        // Algunos usuarios tipo cajero
        User::factory()->count(2)->create([
            'role' => 'manager',
        ]);
    }
}
