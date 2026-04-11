<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test123@gmail.com'],
            [
                'name' => 'Test User',
                'role' => 'admin',
                'password' => bcrypt('12345678'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'riseofasif1999@gmail.com'],
            [
                'name' => 'Asif Ali',
                'role' => 'vendor',
                'password' => bcrypt('Pass@123'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'asif12bn@gmail.com'],
            [
                'name' => 'Alex Ross',
                'role' => 'vendor',
                'password' => bcrypt('Pass@123'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'aloasif31@gmail.com'],
            [
                'name' => 'Muskan Sheikh',
                'role' => 'vendor',
                'password' => bcrypt('Pass@123'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'example234@gmail.com'],
            [
                'name' => 'Zaid Aly',
                'role' => 'customer',
                'password' => bcrypt('Wasd@123'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'adil234@gmail.com'],
            [
                'name' => 'Adil Sheikh',
                'role' => 'customer',
                'password' => bcrypt('Wasd@123'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'hans234@gmail.com'],
            [
                'name' => 'Hans Raj',
                'role' => 'customer',
                'password' => bcrypt('Wasd@123'),
            ]
        );
    }
}
