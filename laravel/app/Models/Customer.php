<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the sales for the customer.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Get the repairs for the customer.
     */
    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    /**
     * Scope a query to only include active customers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the total spent by the customer.
     */
    public function getTotalSpentAttribute()
    {
        return $this->sales()->where('status', 'completed')->sum('total') ?? 0;
    }

    /**
     * Get the total repairs count.
     */
    public function getTotalRepairsAttribute()
    {
        return $this->repairs()->count();
    }
}
