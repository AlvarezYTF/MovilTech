<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTaxSetting extends Model
{
    protected $fillable = [
        'company_name', 'nit', 'dv', 'email',
        'municipality_id', 'economic_activity',
        'logo_url', 'factus_company_id',
    ];

    public function municipality()
    {
        return $this->belongsTo(DianMunicipality::class, 'municipality_id', 'factus_id');
    }

    public static function getInstance(): ?self
    {
        return self::first();
    }

    public function isConfigured(): bool
    {
        return !empty($this->nit) && 
               !empty($this->dv) && 
               !empty($this->municipality_id) &&
               !empty($this->email);
    }

    public function hasFactusId(): bool
    {
        return !empty($this->factus_company_id);
    }
}
