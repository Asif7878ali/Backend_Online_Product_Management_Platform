<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'description',
        'price',
        'stock',
        'threshold',
        'reserved_stock',
        'image'
    ];

    // Product belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product belongs to Vendor (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Full image URL
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : null;
    }

    // Available stock (real stock)
    public function getAvailableStockAttribute()
    {
        return $this->stock - $this->reserved_stock;
    }

    // Scope: only available products
    public function scopeAvailable($query)
    {
        return $query->whereRaw('stock - reserved_stock > 0');
    }

    // Check low stock
    public function isLowStock()
    {
        return $this->stock <= $this->threshold;
    }
}
