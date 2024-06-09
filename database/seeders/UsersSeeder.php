<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin Tokoku',
            'email' => 'admin@tokoku.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);
    }
}
