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
            [
                'category_id' => $electronics->id,
                'title' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse',
                'price' => 1200,
                'stock' => 50,
                'threshold' => 10,
                'reserved_stock' => 0,
                'image' => 'products/mouse.jpg',
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Bluetooth Speaker',
                'description' => 'Portable speaker with deep bass',
                'price' => 3000,
                'stock' => 25,
                'threshold' => 5,
                'reserved_stock' => 0,
                'image' => 'products/speaker.jpg',
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Keyboard',
                'description' => 'Mechanical gaming keyboard',
                'price' => 4500,
                'stock' => 18,
                'threshold' => 5,
                'reserved_stock' => 0,
                'image' => 'products/keyboard.jpg',
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Smartphone',
                'description' => 'Android smartphone with AMOLED display',
                'price' => 25000,
                'stock' => 15,
                'threshold' => 5,
                'reserved_stock' => 0,
                'image' => 'products/phone.jpg',
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'T-Shirt',
                'description' => 'Cotton round neck t-shirt',
                'price' => 800,
                'stock' => 70,
                'threshold' => 15,
                'reserved_stock' => 0,
                'image' => 'products/tshirt.jpg',
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Jeans',
                'description' => 'Slim fit denim jeans',
                'price' => 2200,
                'stock' => 40,
                'threshold' => 10,
                'reserved_stock' => 0,
                'image' => 'products/jeans.jpg',
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Sneakers',
                'description' => 'Comfortable running shoes',
                'price' => 3500,
                'stock' => 30,
                'threshold' => 8,
                'reserved_stock' => 0,
                'image' => 'products/sneakers.jpg',
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Jacket',
                'description' => 'Winter padded jacket',
                'price' => 4000,
                'stock' => 22,
                'threshold' => 6,
                'reserved_stock' => 0,
                'image' => 'products/jacket.jpg',
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