<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 50 người dùng role = 'user'
        User::factory()->count(50)->create();

        // Tùy chọn: Tạo 1 tài khoản admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@sgfood.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'department' => 'IT',
        ]);
    }
}
