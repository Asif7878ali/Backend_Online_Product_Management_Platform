<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'price',
        'stock',
        'image'
    ];

    //  Product belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Optional: Accessor (full image URL)
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : null;
    }

    // Optional: Scope (only available products)
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }
}