<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\ElectronicInvoice;
use App\Services\ElectronicInvoiceService;
use Illuminate\Http\Request;

class ElectronicInvoiceController extends Controller
{
    public function __construct(
        private ElectronicInvoiceService $invoiceService
    ) {}

    public function generate(Sale $sale)
    {
        try {
            $invoice = $this->invoiceService->createFromSale($sale);
            
            return redirect()->route('sales.show', $sale)
                ->with('success', 'Factura electrónica generada exitosamente. CUFE: ' . ($invoice->cufe ?? 'Pendiente'));
        } catch (\Exception $e) {
            return redirect()->route('sales.show', $sale)
                ->with('error', 'Error al generar factura electrónica: ' . $e->getMessage());
        }
    }

    public function show(ElectronicInvoice $electronicInvoice)
    {
        $electronicInvoice->load([
            'sale',
            'customer.taxProfile',
            'numberingRange',
            'documentType',
            'operationType',
            'paymentMethod',
            'paymentForm',
            'items.unitMeasure',
        ]);

        return view('electronic-invoices.show', compact('electronicInvoice'));
    }
}
