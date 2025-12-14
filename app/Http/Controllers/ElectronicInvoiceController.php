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

    public function index(Request $request)
    {
        $query = ElectronicInvoice::with(['customer.taxProfile', 'sale', 'documentType', 'operationType', 'paymentMethod', 'paymentForm'])
            ->orderBy('created_at', 'desc');

        // Filtro por número de documento
        if ($request->filled('filter_number')) {
            $query->where('document', 'like', '%' . $request->input('filter_number') . '%');
        }

        // Filtro por código de referencia
        if ($request->filled('filter_reference_code')) {
            $query->where('reference_code', 'like', '%' . $request->input('filter_reference_code') . '%');
        }

        // Filtro por estado
        if ($request->filled('filter_status')) {
            $statusMap = [
                '1' => 'accepted',
                '0' => 'pending',
            ];
            $status = $statusMap[$request->input('filter_status')] ?? $request->input('filter_status');
            if (in_array($status, ['pending', 'sent', 'accepted', 'rejected', 'cancelled'])) {
                $query->where('status', $status);
            }
        }

        // Filtro por identificación del cliente
        if ($request->filled('filter_identification')) {
            $query->whereHas('customer.taxProfile', function ($q) use ($request) {
                $q->where('identification', 'like', '%' . $request->input('filter_identification') . '%');
            });
        }

        // Filtro por nombre del cliente
        if ($request->filled('filter_names')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('filter_names') . '%');
            });
        }

        // Filtro por prefijo (del número de documento)
        if ($request->filled('filter_prefix')) {
            $query->where('document', 'like', $request->input('filter_prefix') . '%');
        }

        $invoices = $query->paginate(15)->withQueryString();

        return view('electronic-invoices.index', [
            'invoices' => $invoices,
            'filters' => $request->only([
                'filter_identification',
                'filter_names',
                'filter_number',
                'filter_prefix',
                'filter_reference_code',
                'filter_status',
            ]),
        ]);
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

        // Determinar la ruta de retorno
        $returnUrl = null;
        
        // Si hay un parámetro return_to=sale, volver a la venta
        if (request()->get('return_to') === 'sale' && $electronicInvoice->sale) {
            $returnUrl = route('sales.show', $electronicInvoice->sale);
        } elseif (request()->get('return_to') === 'index') {
            // Si viene del índice, volver al índice preservando los filtros
            $queryParams = request()->except(['return_to']);
            $returnUrl = route('electronic-invoices.index', $queryParams);
        } else {
            // Intentar obtener la URL anterior
            $referer = request()->header('referer');
            
            if ($referer) {
                // Verificar si viene del listado de facturas electrónicas
                if (str_contains($referer, route('electronic-invoices.index'))) {
                    // Preservar los filtros de búsqueda si existen
                    $queryParams = parse_url($referer, PHP_URL_QUERY);
                    $returnUrl = route('electronic-invoices.index') . ($queryParams ? '?' . $queryParams : '');
                }
                // Verificar si viene de una venta específica
                elseif (str_contains($referer, '/sales/') && $electronicInvoice->sale) {
                    $returnUrl = route('sales.show', $electronicInvoice->sale);
                }
            }
            
            // Si no se determinó una URL de retorno, usar el listado de facturas como default
            if (!$returnUrl) {
                $returnUrl = route('electronic-invoices.index');
            }
        }

        return view('electronic-invoices.show', compact('electronicInvoice', 'returnUrl'));
    }

    public function refreshStatus(ElectronicInvoice $electronicInvoice, \App\Services\FactusApiService $factusApi)
    {
        try {
            // Intentar buscar por número de documento, CUFE, o reference_code
            $bill = null;
            $searchNumber = $electronicInvoice->document;
            
            // Si tenemos CUFE, intentar buscar por ese campo primero
            if ($electronicInvoice->cufe) {
                try {
                    $bills = $factusApi->getBills(['cufe' => $electronicInvoice->cufe], 1, 1);
                    // La respuesta puede tener estructura: ['data' => ['data' => [...]]] o ['data' => [...]]
                    $data = $bills['data']['data'] ?? $bills['data'] ?? [];
                    if (is_array($data) && !empty($data) && isset($data[0])) {
                        $bill = $data[0];
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning('Error al buscar factura por CUFE', [
                        'cufe' => $electronicInvoice->cufe,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
            
            // Si no se encontró por CUFE y tenemos número de documento, buscar por número
            if (!$bill && $searchNumber) {
                try {
                    $bill = $factusApi->getBillByNumber($searchNumber);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning('Error al buscar factura por número', [
                        'number' => $searchNumber,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
            
            // Si aún no se encontró, intentar por reference_code
            if (!$bill && $electronicInvoice->reference_code) {
                try {
                    $bills = $factusApi->getBills(['reference_code' => $electronicInvoice->reference_code], 1, 1);
                    // La respuesta puede tener estructura: ['data' => ['data' => [...]]] o ['data' => [...]]
                    $data = $bills['data']['data'] ?? $bills['data'] ?? [];
                    if (is_array($data) && !empty($data) && isset($data[0])) {
                        $bill = $data[0];
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning('Error al buscar factura por reference_code', [
                        'reference_code' => $electronicInvoice->reference_code,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
            
            if (!$bill) {
                \Illuminate\Support\Facades\Log::warning('No se pudo encontrar factura en Factus', [
                    'invoice_id' => $electronicInvoice->id,
                    'document' => $electronicInvoice->document,
                    'cufe' => $electronicInvoice->cufe,
                    'reference_code' => $electronicInvoice->reference_code,
                ]);
                
                return redirect()->route('electronic-invoices.show', $electronicInvoice)
                    ->with('warning', 'No se pudo encontrar la factura en Factus. Verifica que esté generada correctamente. Si la factura fue rechazada o está en estado pendiente, puede que aún no esté disponible en Factus.');
            }

            // Mapear estado desde la respuesta de Factus
            $status = 'pending';
            if (isset($bill['status'])) {
                $status = strtolower($bill['status']);
            } elseif (isset($bill['cufe']) && !empty($bill['cufe'])) {
                $status = 'accepted';
            }

            $updateData = [
                'status' => $status,
            ];

            if (isset($bill['cufe']) && !empty($bill['cufe'])) {
                $updateData['cufe'] = $bill['cufe'];
            }

            if (isset($bill['qr']) && !empty($bill['qr'])) {
                $updateData['qr'] = $bill['qr'];
            }

            if (isset($bill['pdf_url']) && !empty($bill['pdf_url'])) {
                $updateData['pdf_url'] = $bill['pdf_url'];
            }

            if (isset($bill['xml_url']) && !empty($bill['xml_url'])) {
                $updateData['xml_url'] = $bill['xml_url'];
            }

            // Actualizar el número de documento si viene en la respuesta
            if (isset($bill['number']) && !empty($bill['number'])) {
                $updateData['document'] = $bill['number'];
            }

            $electronicInvoice->update($updateData);

            $statusMessages = [
                'accepted' => 'Factura actualizada: Estado cambiado a Aceptada',
                'rejected' => 'Factura actualizada: Estado cambiado a Rechazada',
                'sent' => 'Factura actualizada: Estado cambiado a Enviada',
                'pending' => 'Factura actualizada: Estado sigue Pendiente',
            ];

            $message = $statusMessages[$status] ?? 'Estado de la factura actualizado';

            return redirect()->route('electronic-invoices.show', $electronicInvoice)
                ->with('success', $message);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al actualizar estado de factura electrónica', [
                'invoice_id' => $electronicInvoice->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('electronic-invoices.show', $electronicInvoice)
                ->with('error', 'Error al actualizar estado: ' . $e->getMessage());
        }
    }

    public function downloadPdf(ElectronicInvoice $electronicInvoice, \App\Services\FactusApiService $factusApi)
    {
        try {
            // Si ya tiene PDF URL guardada localmente, usar esa
            if ($electronicInvoice->pdf_url) {
                return redirect($electronicInvoice->pdf_url);
            }

            // Si no, descargar desde Factus
            $response = $factusApi->downloadPdf($electronicInvoice->document);

            if (!isset($response['pdf_base_64_encoded']) || !isset($response['file_name'])) {
                throw new \Exception('Respuesta inválida de Factus: falta pdf_base_64_encoded o file_name');
            }

            $pdfContent = base64_decode($response['pdf_base_64_encoded']);
            
            if ($pdfContent === false) {
                throw new \Exception('Error al decodificar el PDF desde Base64');
            }

            $fileName = $response['file_name'] . '.pdf';

            return response($pdfContent, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
                ->header('Content-Length', strlen($pdfContent));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al descargar PDF de factura electrónica', [
                'invoice_id' => $electronicInvoice->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('electronic-invoices.show', $electronicInvoice)
                ->with('error', 'Error al descargar PDF: ' . $e->getMessage());
        }
    }
}
