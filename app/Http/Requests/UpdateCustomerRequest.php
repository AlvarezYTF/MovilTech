<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->route('customer')->id;
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $customerId,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'requires_electronic_invoice' => 'boolean',
        ];

        // Conditional validations for electronic invoicing
        if ($this->boolean('requires_electronic_invoice')) {
            $rules = array_merge($rules, [
                'identification_document_id' => 'required|exists:dian_identification_documents,id',
                'identification' => 'required|string|max:20',
                'municipality_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!\App\Models\DianMunicipality::where('factus_id', $value)->exists()) {
                            $fail('El municipio seleccionado no es válido.');
                        }
                    },
                ],
            ]);

            // Get identification document for specific validations
            $identificationDocument = \App\Models\DianIdentificationDocument::find(
                $this->input('identification_document_id')
            );

            // DV required if document requires it
            if ($identificationDocument && $identificationDocument->requires_dv) {
                $rules['dv'] = 'required|string|size:1';
            }

            // Company required for juridical persons (NIT)
            if ($identificationDocument && $identificationDocument->code === 'NIT') {
                $rules['company'] = 'required|string|max:255';
                $rules['legal_organization_id'] = 'nullable|exists:dian_legal_organizations,id';
                $rules['tribute_id'] = 'nullable|exists:dian_customer_tributes,id';
            }

            // Optional fields
            $rules['trade_name'] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
