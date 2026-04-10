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
        // Run Seeder
        $this->call([
            UsersSeeder::class,  // User Seeder
            ProductSeeder::class,  // Product Seeder
        ]);
    }
}
