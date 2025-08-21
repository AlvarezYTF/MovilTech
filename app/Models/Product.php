<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'category_id',
        'quantity',
        'price',
        'cost_price',
        'status',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the sale items for the product.
     */
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock()
    {
        return $this->quantity > 0;
    }

    /**
     * Get the profit margin.
     */
    public function getProfitMarginAttribute()
    {
        if ($this->cost_price && $this->cost_price > 0) {
            return (($this->price - $this->cost_price) / $this->cost_price) * 100;
        }
        return 0;
    }
}
