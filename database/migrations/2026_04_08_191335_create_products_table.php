<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // basic info
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);

            // Image
            $table->string('image')->nullable();

            // Category
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            // Inventory Management
            $table->integer('stock')->default(0);        // current stock
            $table->integer('threshold')->default(5);    // low stock alert
            $table->integer('reserved_stock')->default(0); // future use (cart)

            // Vendor (who added product)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // timestamp
            $table->timestamps();

            // indexes
            $table->index('user_id');
            $table->index('category_id');
            $table->index('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
