<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'user_id',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total',
        'status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the sale.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user that owns the sale.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sale items for the sale.
     */
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Scope a query to only include completed sales.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include pending sales.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Calculate the total with tax and discount.
     */
    public function calculateTotal()
    {
        $this->total = $this->subtotal + $this->tax_amount - $this->discount_amount;
        return $this->total;
    }

    /**
     * Apply discount percentage.
     */
    public function applyDiscount($percentage)
    {
        $this->discount_amount = ($this->subtotal * $percentage) / 100;
        $this->calculateTotal();
        return $this;
    }

    /**
     * Apply tax percentage.
     */
    public function applyTax($percentage)
    {
        $this->tax_amount = ($this->subtotal * $percentage) / 100;
        $this->calculateTotal();
        return $this;
    }
}
