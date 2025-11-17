@extends('layouts.app')

@section('title', 'Editar Venta')
@section('header', 'Editar Venta')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="mr-3 p-2 rounded-lg bg-indigo-50 border border-indigo-100">
                    <i class="fas fa-edit text-indigo-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Editar Venta</h3>
                    <p class="text-sm text-gray-500">Modifica la información de la venta #{{ $sale->invoice_number }}</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('sales.update', $sale) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información básica -->
                <div class="md:col-span-2">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Información básica</h4>
                </div>
                
                <!-- Cliente -->
                <div>
                    <label for="customer_id" class="form-label">
                        Cliente <span class="text-red-500">*</span>
                    </label>
                    <select name="customer_id" id="customer_id" required 
                            class="form-input @error('customer_id') border-red-300 @enderror">
                        <option value="">Selecciona un cliente</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" 
                                    {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} - {{ $customer->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha de Venta -->
                <div>
                    <label for="sale_date" class="form-label">
                        Fecha de Venta <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="sale_date" id="sale_date" required
                           value="{{ old('sale_date', $sale->sale_date ? $sale->sale_date->format('Y-m-d') : $sale->created_at->format('Y-m-d')) }}"
                           class="form-input @error('sale_date') border-red-300 @enderror">
                    @error('sale_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Productos -->
                <div class="md:col-span-2">
                    <h4 class="text-md font-medium text-gray-900 mb-4 mt-6">Productos</h4>
                </div>

                <!-- Producto -->
                <div>
                    <label for="product_id" class="form-label">
                        Producto <span class="text-red-500">*</span>
                    </label>
                    <select name="product_id" id="product_id" required 
                            class="form-input @error('product_id') border-red-300 @enderror">
                        <option value="">Selecciona un producto</option>
                        @foreach($products as $product)
                            @php
                                $currentSaleItem = $sale->saleItems->first();
                                $isCurrentProduct = $currentSaleItem && $currentSaleItem->product_id == $product->id;
                                // Para productos que no son el actual, agregar el stock que ya se vendió
                                $availableStock = $isCurrentProduct ? 
                                    $product->quantity + ($currentSaleItem ? $currentSaleItem->quantity : 0) : 
                                    $product->quantity;
                            @endphp
                            <option value="{{ $product->id }}" 
                                    data-price="{{ $product->price }}"
                                    data-stock="{{ $availableStock }}"
                                    {{ old('product_id', $currentSaleItem ? $currentSaleItem->product_id : '') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} - Stock: {{ $availableStock }} - ${{ number_format($product->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cantidad -->
                <div>
                    <label for="quantity" class="form-label">
                        Cantidad <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="quantity" id="quantity" min="1" required
                           value="{{ old('quantity', $sale->saleItems->first() ? $sale->saleItems->first()->quantity : 1) }}"
                           class="form-input @error('quantity') border-red-300 @enderror">
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Stock disponible: <span id="stock-display" class="font-medium">-</span></p>
                </div>

                <!-- Precio Unitario -->
                <div>
                    <label for="unit_price" class="form-label">
                        Precio Unitario <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" name="unit_price" id="unit_price" step="0.01" min="0" required
                               value="{{ old('unit_price', $sale->saleItems->first() ? $sale->saleItems->first()->unit_price : '0.00') }}"
                               class="form-input pl-8 @error('unit_price') border-red-300 @enderror">
                    </div>
                    @error('unit_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total -->
                <div>
                    <label for="total" class="form-label">
                        Total <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" name="total" id="total" step="0.01" min="0" required readonly
                               value="{{ old('total', $sale->total) }}"
                               class="form-input pl-8 bg-gray-100">
                    </div>
                    @error('total')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notas -->
                <div class="md:col-span-2">
                    <label for="notes" class="form-label">Notas adicionales</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="form-input @error('notes') border-red-300 @enderror"
                              placeholder="Agrega notas adicionales sobre la venta...">{{ old('notes', $sale->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Información adicional</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Número de factura:</span> {{ $sale->invoice_number }}
                    </div>
                    <div>
                        <span class="font-medium">Estado:</span> 
                        @if($sale->status === 'completed')
                            <span class="text-green-600">Completada</span>
                        @elseif($sale->status === 'pending')
                            <span class="text-yellow-600">Pendiente</span>
                        @else
                            <span class="text-red-600">Cancelada</span>
                        @endif
                    </div>
                    <div>
                        <span class="font-medium">Creada:</span> {{ $sale->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div>
                        <span class="font-medium">Última actualización:</span> {{ $sale->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('sales.show', $sale) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar Venta
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const totalInput = document.getElementById('total');
    const stockDisplay = document.getElementById('stock-display');

    function updateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalInput.value = total.toFixed(2);
    }

    function updateStock() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.stock) {
            stockDisplay.textContent = selectedOption.dataset.stock;
            quantityInput.max = selectedOption.dataset.stock;
        } else {
            stockDisplay.textContent = '-';
            quantityInput.removeAttribute('max');
        }
    }

    function updatePrice() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.price) {
            unitPriceInput.value = selectedOption.dataset.price;
            updateTotal();
        }
    }

    // Event listeners
    productSelect.addEventListener('change', function() {
        updatePrice();
        updateStock();
    });

    quantityInput.addEventListener('input', updateTotal);
    unitPriceInput.addEventListener('input', updateTotal);

    // Inicializar
    updatePrice();
    updateStock();
    updateTotal();
});
</script>
@endpush
@endsection
