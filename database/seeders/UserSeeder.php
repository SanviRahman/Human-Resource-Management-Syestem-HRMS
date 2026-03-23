<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'employeeID' => 'ADM-001',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // HR User
        User::create([
            'employeeID' => 'HR-001',
            'password' => Hash::make('password123'),
            'role' => 'hr',
        ]);

        // Normal User
        User::create([
            'employeeID' => 'EMP-001',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}