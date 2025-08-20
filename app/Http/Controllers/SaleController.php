<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['customer', 'user', 'saleItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::active()->orderBy('name')->get();
        $products = Product::active()->inStock()->orderBy('name')->get();
        
        return view('sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            // Verificar stock disponible
            $product = Product::find($request->product_id);
            if ($product->quantity < $request->quantity) {
                return back()->withInput()
                    ->with('error', 'Stock insuficiente. Stock disponible: ' . $product->quantity);
            }

            // Crear la venta
            $sale = Sale::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'customer_id' => $request->customer_id,
                'user_id' => Auth::id(),
                'sale_date' => $request->sale_date,
                'subtotal' => $request->total,
                'tax_amount' => 0, // Por defecto 0, se puede modificar después
                'discount_amount' => 0, // Por defecto 0, se puede modificar después
                'total' => $request->total,
                'status' => 'completed',
                'notes' => $request->notes,
            ]);

            // Crear el item de venta
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total_price' => $request->total,
            ]);

            // Actualizar stock del producto
            $product->decrement('quantity', $request->quantity);

            DB::commit();

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Venta creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear la venta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load(['customer', 'user', 'saleItems.product']);
        
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $customers = Customer::active()->orderBy('name')->get();
        $products = Product::active()->orderBy('name')->get();
        $sale->load(['saleItems.product']);
        
        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            // Obtener el item de venta original para restaurar stock
            $originalItem = $sale->saleItems->first();
            if ($originalItem) {
                $originalProduct = Product::find($originalItem->product_id);
                $originalProduct->increment('quantity', $originalItem->quantity);
            }

            // Verificar stock disponible para el nuevo producto
            $newProduct = Product::find($request->product_id);
            if ($newProduct->quantity < $request->quantity) {
                return back()->withInput()
                    ->with('error', 'Stock insuficiente. Stock disponible: ' . $newProduct->quantity);
            }

            // Actualizar la venta
            $sale->update([
                'customer_id' => $request->customer_id,
                'sale_date' => $request->sale_date,
                'subtotal' => $request->total,
                'total' => $request->total,
                'notes' => $request->notes,
            ]);

            // Actualizar o crear el item de venta
            if ($originalItem) {
                $originalItem->update([
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'unit_price' => $request->unit_price,
                    'total_price' => $request->total,
                ]);
            }

            // Actualizar stock del nuevo producto
            $newProduct->decrement('quantity', $request->quantity);

            DB::commit();

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Venta actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        try {
            DB::beginTransaction();

            // Restaurar stock de los productos
            foreach ($sale->saleItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('quantity', $item->quantity);
                }
            }

            // Eliminar items de venta
            $sale->saleItems()->delete();

            // Eliminar la venta
            $sale->delete();

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Venta eliminada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Generate a unique invoice number.
     */
    private function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $year = date('Y');
        $month = date('m');
        
        $lastSale = Sale::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastSale) {
            $lastNumber = (int) substr($lastSale->invoice_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
