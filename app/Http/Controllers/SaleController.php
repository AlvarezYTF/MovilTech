<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Sale;
use App\Models\Customer;
use App\Repositories\ProductRepository;
use App\Services\SaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function __construct(
        private readonly SaleService $saleService,
        private readonly ProductRepository $productRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $sales = Sale::with(['customer', 'user', 'saleItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $customers = Customer::active()->orderBy('name')->get();
        $products = $this->productRepository->getActiveProducts();
        
        return view('sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request): RedirectResponse
    {
        try {
            $sale = $this->saleService->createSale($request->validated());

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Venta creada exitosamente.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al crear la venta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale): View
    {
        $sale->load(['customer', 'user', 'saleItems.product']);
        
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale): View
    {
        $customers = Customer::active()->orderBy('name')->get();
        $products = $this->productRepository->getActiveProducts();
        $sale->load(['saleItems.product']);
        
        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale): RedirectResponse
    {
        try {
            $sale = $this->saleService->updateSale($sale, $request->validated());

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Venta actualizada exitosamente.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale): RedirectResponse
    {
        try {
            $this->saleService->deleteSale($sale);

            return redirect()->route('sales.index')
                ->with('success', 'Venta eliminada exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF for the sale.
     */
    public function pdf(Sale $sale)
    {
        $sale->load(['customer', 'user', 'saleItems.product']);
        
        $pdf = Pdf::loadView('sales.pdf', compact('sale'));
        
        return $pdf->download('factura-' . $sale->invoice_number . '.pdf');
    }
}
