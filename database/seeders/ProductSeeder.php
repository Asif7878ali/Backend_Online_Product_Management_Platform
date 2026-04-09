<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories (avoid duplicate on re-run)
        $electronics = Category::firstOrCreate(['name' => 'Electronics']);
        $fashion = Category::firstOrCreate(['name' => 'Fashion']);

        // Insert Products
        Product::insert([
            [
                'category_id' => $electronics->id,
                'title' => 'iPad Air',
                'description' => 'Apple tablet device',
                'price' => 60000,
                'stock' => 12,
                'image' => 'products/ipad.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Dell Monitor',
                'description' => '24-inch LED monitor',
                'price' => 15000,
                'stock' => 20,
                'image' => 'products/monitor.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Hoodie',
                'description' => 'Warm cotton hoodie',
                'price' => 1800,
                'stock' => 35,
                'image' => 'products/hoodie.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Cap',
                'description' => 'Stylish baseball cap',
                'price' => 500,
                'stock' => 60,
                'image' => 'products/cap.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Keyboard',
                'description' => 'Mechanical keyboard',
                'price' => 2500,
                'stock' => 22,
                'image' => 'products/keyboard.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Mouse',
                'description' => 'Wireless optical mouse',
                'price' => 1200,
                'stock' => 30,
                'image' => 'products/mouse.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Sunglasses',
                'description' => 'UV protection sunglasses',
                'price' => 1500,
                'stock' => 25,
                'image' => 'products/sunglasses.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Backpack',
                'description' => 'Travel backpack',
                'price' => 2200,
                'stock' => 18,
                'image' => 'products/backpack.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Power Bank',
                'description' => '10000mAh power bank',
                'price' => 1800,
                'stock' => 28,
                'image' => 'products/powerbank.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Router',
                'description' => 'WiFi 6 router',
                'price' => 3500,
                'stock' => 14,
                'image' => 'products/router.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}