<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'phone_model',
        'imei',
        'issue_description',
        'repair_status',
        'repair_cost',
        'repair_date',
        'notes',
    ];

    protected $casts = [
        'repair_cost' => 'decimal:2',
        'repair_date' => 'date',
    ];

    /**
     * Get the customer that owns the repair.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope a query to only include pending repairs.
     */
    public function scopePending($query)
    {
        return $query->where('repair_status', 'pending');
    }

    /**
     * Scope a query to only include in progress repairs.
     */
    public function scopeInProgress($query)
    {
        return $query->where('repair_status', 'in_progress');
    }

    /**
     * Scope a query to only include completed repairs.
     */
    public function scopeCompleted($query)
    {
        return $query->where('repair_status', 'completed');
    }

    /**
     * Scope a query to only include delivered repairs.
     */
    public function scopeDelivered($query)
    {
        return $query->where('repair_status', 'delivered');
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute()
    {
        return match($this->repair_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'delivered' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the status display name.
     */
    public function getStatusDisplayAttribute()
    {
        return match($this->repair_status) {
            'pending' => 'Pendiente',
            'in_progress' => 'En Progreso',
            'completed' => 'Completado',
            'delivered' => 'Entregado',
            default => 'Desconocido',
        };
    }
}
