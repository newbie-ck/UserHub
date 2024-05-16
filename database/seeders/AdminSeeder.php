<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if admin already exists
        if (!User::where('username', 'admin2024')->exists()) {
            // Create admin account
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'username' => 'admin2024',
                'password' => bcrypt('adminpassWord1@'), // Hashed password
                'phone_number' => '60123456789',
                'is_admin' => true,
            ]);
        }
    }
}
