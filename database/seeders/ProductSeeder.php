<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $electronics = Category::firstOrCreate(['name' => 'Electronics']);
        $fashion = Category::firstOrCreate(['name' => 'Fashion']);

        // Get Vendor
        $vendor = User::where('role', 'vendor')->first();

        if (!$vendor) {
            $this->command->error('No vendor found. Please seed users first.');
            return;
        }

        // Products
        $products = [
            [
                'category_id' => $electronics->id,
                'title' => 'iPad Air',
                'description' => 'Apple tablet device',
                'price' => 60000,
                'stock' => 12,
                'threshold' => 5,
                'reserved_stock' => 0,
                'image' => 'products/ipad.jpg',
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Dell Monitor',
                'description' => '24-inch LED monitor',
                'price' => 15000,
                'stock' => 20,
                'threshold' => 5,
                'reserved_stock' => 0,
                'image' => 'products/monitor.jpg',
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Hoodie',
                'description' => 'Warm cotton hoodie',
                'price' => 1800,
                'stock' => 35,
                'threshold' => 10,
                'reserved_stock' => 0,
                'image' => 'products/hoodie.jpg',
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Cap',
                'description' => 'Stylish baseball cap',
                'price' => 500,
                'stock' => 60,
                'threshold' => 10,
                'reserved_stock' => 0,
                'image' => 'products/cap.jpg',
            ],
        ];

        // Insert using firstOrCreate (no duplicates)
        foreach ($products as $product) {
            Product::firstOrCreate(
                ['title' => $product['title']], // unique check
                array_merge($product, [
                    'user_id' => $vendor->id,
                ])
            );
        }
    }
}