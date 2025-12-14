<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\ElectronicInvoice;
use App\Models\ElectronicInvoiceItem;
use App\Models\CompanyTaxSetting;
use App\Models\DianDocumentType;
use App\Models\DianOperationType;
use App\Models\DianPaymentMethod;
use App\Models\DianPaymentForm;
use App\Services\FactusNumberingRangeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ElectronicInvoiceService
{
    public function __construct(
        private FactusApiService $apiService,
        private FactusNumberingRangeService $numberingRangeService
    ) {}

    public function createFromSale(Sale $sale): ElectronicInvoice
    {
        $sale->load(['customer.taxProfile', 'saleItems.product']);

        if (!$sale->requiresElectronicInvoice()) {
            throw new \Exception('El cliente no requiere facturación electrónica.');
        }

        if (!$sale->customer->hasCompleteTaxProfileData()) {
            throw new \Exception('El cliente no tiene datos fiscales completos.');
        }

        $company = CompanyTaxSetting::getInstance();
        if (!$company || !$company->isConfigured()) {
            throw new \Exception('La configuración fiscal de la empresa no está completa.');
        }

        if ($sale->hasElectronicInvoice()) {
            throw new \Exception('La venta ya tiene una factura electrónica asociada.');
        }

        return DB::transaction(function () use ($sale, $company) {
            $documentType = DianDocumentType::where('code', '01')->firstOrFail();
            $operationType = DianOperationType::where('code', '10')->firstOrFail();
            $paymentMethod = DianPaymentMethod::where('code', '10')->firstOrFail();
            $paymentForm = DianPaymentForm::where('code', '1')->firstOrFail();

            $range = $this->numberingRangeService->getValidRangeForDocument('Factura de Venta');
            if (!$range) {
                throw new \Exception('No hay un rango de numeración válido disponible.');
            }

            $invoice = ElectronicInvoice::create([
                'sale_id' => $sale->id,
                'customer_id' => $sale->customer_id,
                'factus_numbering_range_id' => $range->factus_id,
                'document_type_id' => $documentType->id,
                'operation_type_id' => $operationType->id,
                'payment_method_code' => $paymentMethod->code,
                'payment_form_code' => $paymentForm->code,
                'reference_code' => 'FV-' . str_pad($sale->id, 8, '0', STR_PAD_LEFT),
                'document' => $range->prefix . str_pad($range->current, 8, '0', STR_PAD_LEFT),
                'status' => 'pending',
                'total' => $sale->total,
                'tax_amount' => $sale->tax_amount ?? 0,
                'gross_value' => $sale->subtotal ?? $sale->total,
                'discount_amount' => $sale->discount_amount ?? 0,
                'surcharge_amount' => 0,
            ]);

            foreach ($sale->saleItems as $saleItem) {
                $product = $saleItem->product;
                $unitMeasure = \App\Models\DianMeasurementUnit::where('code', '94')->first();
                
                if (!$unitMeasure) {
                    throw new \Exception("No se encontró unidad de medida por defecto (código 94).");
                }

                $taxRate = 19.0;
                $taxAmount = ($saleItem->quantity * $saleItem->unit_price) * ($taxRate / 100);
                $total = ($saleItem->quantity * $saleItem->unit_price) + $taxAmount;

                ElectronicInvoiceItem::create([
                    'electronic_invoice_id' => $invoice->id,
                    'tribute_id' => 18,
                    'standard_code_id' => 1,
                    'unit_measure_id' => $unitMeasure->factus_id,
                    'code_reference' => $product->sku ?? 'PROD-' . $product->id,
                    'name' => $product->name,
                    'quantity' => $saleItem->quantity,
                    'price' => $saleItem->unit_price,
                    'tax_rate' => $taxRate,
                    'tax_amount' => $taxAmount,
                    'discount_rate' => 0,
                    'total' => $total,
                ]);
            }

            $invoice->load(['items.unitMeasure', 'customer.taxProfile', 'numberingRange']);

            $payload = $this->buildPayload($invoice, $company);

            try {
                $response = $this->apiService->post('/v1/bills/validate', $payload);

                $invoice->update([
                    'status' => $this->mapStatusFromResponse($response),
                    'cufe' => $response['cufe'] ?? null,
                    'qr' => $response['qr'] ?? null,
                    'payload_sent' => $payload,
                    'response_dian' => $response,
                    'validated_at' => now(),
                    'pdf_url' => $response['pdf_url'] ?? null,
                    'xml_url' => $response['xml_url'] ?? null,
                ]);

                Log::info('Factura electrónica creada y validada exitosamente', [
                    'invoice_id' => $invoice->id,
                    'sale_id' => $sale->id,
                    'cufe' => $invoice->cufe,
                ]);

            } catch (\Exception $e) {
                Log::error('Error al enviar factura a Factus', [
                    'invoice_id' => $invoice->id,
                    'sale_id' => $sale->id,
                    'error' => $e->getMessage(),
                ]);

                $invoice->update([
                    'status' => 'error',
                    'response_dian' => ['error' => $e->getMessage()],
                ]);

                throw $e;
            }

            return $invoice;
        });
    }

    private function buildPayload(ElectronicInvoice $invoice, CompanyTaxSetting $company): array
    {
        $customer = $invoice->customer;
        $taxProfile = $customer->taxProfile;

        return [
            'issuer' => [
                'nit' => $company->nit,
                'dv' => $company->dv,
                'company_name' => $company->company_name,
                'email' => $company->email,
                'municipality_id' => $company->municipality->factus_id,
                'economic_activity' => $company->economic_activity,
            ],
            'customer' => [
                'identification_document_code' => $taxProfile->identificationDocument->code,
                'identification' => $taxProfile->identification,
                'dv' => $taxProfile->dv,
                'company_name' => $taxProfile->company ?? $customer->name,
                'municipality_id' => $taxProfile->municipality->factus_id,
            ],
            'document_type' => $invoice->documentType->code,
            'operation_type' => $invoice->operationType->code,
            'document' => $invoice->document,
            'reference_code' => $invoice->reference_code,
            'numbering_range_id' => $invoice->numberingRange->factus_id,
            'items' => $invoice->items->map(function($item) {
                return [
                    'code_reference' => $item->code_reference,
                    'name' => $item->name,
                    'quantity' => (float) $item->quantity,
                    'price' => (float) $item->price,
                    'unit_measure_id' => $item->unitMeasure->factus_id,
                    'tax_rate' => (float) $item->tax_rate,
                    'tax_amount' => (float) $item->tax_amount,
                    'total' => (float) $item->total,
                ];
            })->toArray(),
            'gross_value' => (float) $invoice->gross_value,
            'tax_amount' => (float) $invoice->tax_amount,
            'discount_amount' => (float) $invoice->discount_amount,
            'total' => (float) $invoice->total,
            'payment_method_code' => $invoice->payment_method_code,
            'payment_form_code' => $invoice->payment_form_code,
        ];
    }

    private function mapStatusFromResponse(array $response): string
    {
        if (isset($response['status'])) {
            $status = strtolower($response['status']);
            if (in_array($status, ['accepted', 'rejected', 'pending', 'error'])) {
                return $status;
            }
        }

        if (isset($response['cufe']) && !empty($response['cufe'])) {
            return 'accepted';
        }

        return 'pending';
    }
}
