<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Repair;
use App\Models\Product;
use App\Models\Customer;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller
{
    /**
     * Display a listing of available reports.
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Show sales report with filters.
     */
    public function salesReport(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'customer_id' => 'nullable|exists:customers,id',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $query = Sale::with(['customer', 'saleItems.product']);

        // Filtros
        if ($request->filled('date_from')) {
            $query->whereDate('sale_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('sale_date', '<=', $request->date_to);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('product_id')) {
            $query->whereHas('saleItems', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }

        $sales = $query->orderBy('sale_date', 'desc')->get();

        // Obtener datos para los filtros
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        // Calcular totales
        $totalSales = $sales->sum('total');
        $totalCount = $sales->count();

        return view('reports.sales', compact('sales', 'customers', 'products', 'totalSales', 'totalCount'));
    }

    /**
     * Show repairs report with filters.
     */
    public function repairsReport(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'repair_status' => 'nullable|in:pending,in_progress,completed,delivered',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $query = Repair::with('customer');

        // Filtros
        if ($request->filled('date_from')) {
            $query->whereDate('repair_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('repair_date', '<=', $request->date_to);
        }

        if ($request->filled('repair_status')) {
            $query->where('repair_status', $request->repair_status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $repairs = $query->orderBy('repair_date', 'desc')->get();

        // Obtener datos para los filtros
        $customers = Customer::orderBy('name')->get();

        // Calcular totales
        $totalRevenue = $repairs->sum('repair_cost');
        $totalCount = $repairs->count();

        return view('reports.repairs', compact('repairs', 'customers', 'totalRevenue', 'totalCount'));
    }

    /**
     * Generate PDF report.
     */
    public function generatePDF(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:sales,repairs',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'customer_id' => 'nullable|exists:customers,id',
            'product_id' => 'nullable|exists:products,id',
            'repair_status' => 'nullable|in:pending,in_progress,completed,delivered',
        ]);

        $data = [];
        $fileName = '';

        if ($request->report_type === 'sales') {
            $query = Sale::with(['customer', 'saleItems.product']);

            // Aplicar filtros
            if ($request->filled('date_from')) {
                $query->whereDate('sale_date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('sale_date', '<=', $request->date_to);
            }

            if ($request->filled('customer_id')) {
                $query->where('customer_id', $request->customer_id);
            }

            if ($request->filled('product_id')) {
                $query->whereHas('saleItems', function($q) use ($request) {
                    $q->where('product_id', $request->product_id);
                });
            }

            $sales = $query->orderBy('sale_date', 'desc')->get();
            $data = [
                'sales' => $sales,
                'totalSales' => $sales->sum('total'),
                'totalCount' => $sales->count(),
                'filters' => $request->all(),
            ];
            $fileName = 'reporte_ventas_' . date('Y-m-d') . '.pdf';
            $view = 'reports.pdf.sales';

        } else {
            $query = Repair::with('customer');

            // Aplicar filtros
            if ($request->filled('date_from')) {
                $query->whereDate('repair_date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('repair_date', '<=', $request->date_to);
            }

            if ($request->filled('repair_status')) {
                $query->where('repair_status', $request->repair_status);
            }

            if ($request->filled('customer_id')) {
                $query->where('customer_id', $request->customer_id);
            }

            $repairs = $query->orderBy('repair_date', 'desc')->get();
            $data = [
                'repairs' => $repairs,
                'totalRevenue' => $repairs->sum('repair_cost'),
                'totalCount' => $repairs->count(),
                'filters' => $request->all(),
            ];
            $fileName = 'reporte_reparaciones_' . date('Y-m-d') . '.pdf';
            $view = 'reports.pdf.repairs';
        }

        // Configurar opciones de PDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Crear instancia de Dompdf
        $dompdf = new Dompdf($options);

        // Generar HTML
        $html = view($view, $data)->render();

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Configurar tamaño de papel
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar PDF
        $dompdf->render();

        // Descargar PDF
        return $dompdf->stream($fileName);
    }
}
