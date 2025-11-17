<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SaleService
{
    /**
     * Create a new sale with items.
     *
     * @param array<string, mixed> $data
     * @return Sale
     * @throws \Exception
     */
    public function createSale(array $data): Sale
    {
        return DB::transaction(function () use ($data) {
            // Verify stock availability
            $product = Product::findOrFail($data['product_id']);
            
            if ($product->quantity < $data['quantity']) {
                throw new \Exception('Stock insuficiente. Stock disponible: ' . $product->quantity);
            }

            // Generate invoice number
            $invoiceNumber = $this->generateInvoiceNumber();

            // Create the sale
            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $data['customer_id'],
                'user_id' => Auth::id(),
                'sale_date' => $data['sale_date'],
                'subtotal' => $data['total'],
                'tax_amount' => $data['tax_amount'] ?? 0,
                'discount_amount' => $data['discount_amount'] ?? 0,
                'total' => $data['total'],
                'status' => $data['status'] ?? 'completed',
                'notes' => $data['notes'] ?? null,
            ]);

            // Create sale item
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'unit_price' => $data['unit_price'],
                'total_price' => $data['total'],
            ]);

            // Update product stock
            $product->decrement('quantity', $data['quantity']);

            return $sale->load(['customer', 'user', 'saleItems.product']);
        });
    }

    /**
     * Update an existing sale.
     *
     * @param Sale $sale
     * @param array<string, mixed> $data
     * @return Sale
     * @throws \Exception
     */
    public function updateSale(Sale $sale, array $data): Sale
    {
        return DB::transaction(function () use ($sale, $data) {
            // Get original sale item to restore stock
            $originalItem = $sale->saleItems->first();
            
            if ($originalItem) {
                $originalProduct = Product::findOrFail($originalItem->product_id);
                $originalProduct->increment('quantity', $originalItem->quantity);
            }

            // Verify stock availability for new product
            $newProduct = Product::findOrFail($data['product_id']);
            
            if ($newProduct->quantity < $data['quantity']) {
                throw new \Exception('Stock insuficiente. Stock disponible: ' . $newProduct->quantity);
            }

            // Update the sale
            $sale->update([
                'customer_id' => $data['customer_id'],
                'sale_date' => $data['sale_date'],
                'subtotal' => $data['total'],
                'total' => $data['total'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Update or create sale item
            if ($originalItem) {
                $originalItem->update([
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'unit_price' => $data['unit_price'],
                    'total_price' => $data['total'],
                ]);
            }

            // Update new product stock
            $newProduct->decrement('quantity', $data['quantity']);

            return $sale->fresh(['customer', 'user', 'saleItems.product']);
        });
    }

    /**
     * Delete a sale and restore product stock.
     *
     * @param Sale $sale
     * @return void
     */
    public function deleteSale(Sale $sale): void
    {
        DB::transaction(function () use ($sale) {
            // Restore stock for all products
            foreach ($sale->saleItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('quantity', $item->quantity);
                }
            }

            // Delete sale items
            $sale->saleItems()->delete();

            // Delete the sale
            $sale->delete();
        });
    }

    /**
     * Generate a unique invoice number.
     *
     * @return string
     */
    private function generateInvoiceNumber(): string
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

