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
        // ✅ Create Categories (avoid duplicate on re-run)
        $electronics = Category::firstOrCreate(['name' => 'Electronics']);
        $fashion = Category::firstOrCreate(['name' => 'Fashion']);

        // ✅ Insert Products
        Product::insert([
            [
                'category_id' => $electronics->id,
                'title' => 'iPhone 15',
                'description' => 'Apple smartphone',
                'price' => 80000,
                'stock' => 10,
                'image' => 'products/iphone.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Samsung TV',
                'description' => 'Smart LED TV',
                'price' => 45000,
                'stock' => 5,
                'image' => 'products/tv.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'T-Shirt',
                'description' => 'Cotton T-Shirt',
                'price' => 999,
                'stock' => 50,
                'image' => 'products/tshirt.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Jeans',
                'description' => 'Denim jeans',
                'price' => 1999,
                'stock' => 30,
                'image' => 'products/jeans.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Laptop',
                'description' => 'Gaming laptop',
                'price' => 90000,
                'stock' => 7,
                'image' => 'products/laptop.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Headphones',
                'description' => 'Wireless headphones',
                'price' => 3000,
                'stock' => 25,
                'image' => 'products/headphones.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Shoes',
                'description' => 'Running shoes',
                'price' => 2500,
                'stock' => 20,
                'image' => 'products/shoes.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $fashion->id,
                'title' => 'Jacket',
                'description' => 'Winter jacket',
                'price' => 3500,
                'stock' => 15,
                'image' => 'products/jacket.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Smart Watch',
                'description' => 'Fitness watch',
                'price' => 5000,
                'stock' => 18,
                'image' => 'products/watch.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Bluetooth Speaker',
                'description' => 'Portable speaker',
                'price' => 2000,
                'stock' => 40,
                'image' => 'products/speaker.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}