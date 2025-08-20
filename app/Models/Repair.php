<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_number',
        'customer_id',
        'user_id',
        'device_type',
        'brand',
        'model',
        'problem_description',
        'solution_description',
        'status',
        'estimated_cost',
        'final_cost',
        'estimated_completion_date',
        'completion_date',
        'notes',
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
        'estimated_completion_date' => 'date',
        'completion_date' => 'date',
    ];

    /**
     * Get the customer that owns the repair.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user that owns the repair.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include pending repairs.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include in progress repairs.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope a query to only include completed repairs.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Check if repair is overdue.
     */
    public function isOverdue()
    {
        if ($this->estimated_completion_date && $this->status !== 'completed') {
            return now()->isAfter($this->estimated_completion_date);
        }
        return false;
    }

    /**
     * Mark repair as completed.
     */
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->completion_date = now();
        $this->save();
    }

    /**
     * Mark repair as in progress.
     */
    public function markAsInProgress()
    {
        $this->status = 'in_progress';
        $this->save();
    }
}
