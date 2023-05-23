<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'              => 'Afeez Azeez',
            'email'             => 'azeezafeez212@gmail.com',
            'username'          => 'afeez_dev',
            'is_admin'          => 1,
            'email_verified_at' => now(),
            'password' => '123456',
            'bio'      => 'Software Developer in the making',
            'phone'    => '2348131353926',
            'linkedin' => 'https://linkedin.com/in/afeezazeez',
            'role'     => 'Software Developer'
        ]);
    }
}
