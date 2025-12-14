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
        'requires_electronic_invoice',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_electronic_invoice' => 'boolean',
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
     * Get the tax profile for the customer.
     */
    public function taxProfile()
    {
        return $this->hasOne(CustomerTaxProfile::class);
    }

    /**
     * Check if customer requires electronic invoice.
     */
    public function requiresElectronicInvoice(): bool
    {
        return $this->requires_electronic_invoice && 
               $this->taxProfile !== null;
    }

    /**
     * Check if customer has complete tax profile data.
     */
    public function hasCompleteTaxProfileData(): bool
    {
        if (!$this->requires_electronic_invoice) {
            return false;
        }
        
        $profile = $this->taxProfile;
        if (!$profile) {
            return false;
        }
        
        $required = ['identification_document_id', 'identification', 'municipality_id'];
        
        foreach ($required as $field) {
            if (empty($profile->$field)) {
                return false;
            }
        }
        
        if ($profile->requiresDV() && empty($profile->dv)) {
            return false;
        }
        
        if ($profile->isJuridicalPerson() && empty($profile->company)) {
            return false;
        }
        
        return true;
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
