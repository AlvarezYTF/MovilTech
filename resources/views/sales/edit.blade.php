@extends('layouts.app')

@section('title', 'Editar Venta')
@section('header', 'Editar Venta')

@section('content')
<div class="max-w-4xl mx-auto space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2.5 sm:p-3 rounded-xl bg-emerald-50 text-emerald-600">
                <i class="fas fa-edit text-lg sm:text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Editar Venta</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Modifica la información de la venta #{{ $sale->invoice_number }}</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('sales.update', $sale) }}" id="sale-form" x-data="{ loading: false }" @submit="loading = true">
        @csrf
        @method('PUT')

        <!-- Información básica -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <i class="fas fa-info text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información básica</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                <!-- Cliente -->
                <div>
                    <label for="customer_id" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Cliente <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400 text-sm"></i>
                        </div>
                        <select name="customer_id" id="customer_id" required
                                class="block w-full pl-10 sm:pl-11 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none bg-white transition-all @error('customer_id') border-red-300 focus:ring-red-500 @enderror">
                            <option value="">Selecciona un cliente</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                        {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}@if($customer->email) - {{ $customer->email }}@endif
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                    @error('customer_id')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Fecha de Venta -->
                <div>
                    <label for="sale_date" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Fecha de Venta <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                        </div>
                        <input type="date" name="sale_date" id="sale_date" required
                               value="{{ old('sale_date', $sale->sale_date ? $sale->sale_date->format('Y-m-d') : $sale->created_at->format('Y-m-d')) }}"
                               class="block w-full pl-10 sm:pl-11 pr-3 sm:pr-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('sale_date') border-red-300 focus:ring-red-500 @enderror">
                    </div>
                    @error('sale_date')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Productos -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-violet-50 text-violet-600">
                    <i class="fas fa-box text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Productos</h2>
            </div>

            <div class="space-y-5 sm:space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                    <!-- Producto -->
                    <div>
                        <label for="product_id" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            Producto <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-box text-gray-400 text-sm"></i>
                            </div>
                            <select name="product_id" id="product_id" required
                                    class="block w-full pl-10 sm:pl-11 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none bg-white transition-all @error('product_id') border-red-300 focus:ring-red-500 @enderror">
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
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        @error('product_id')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Cantidad -->
                    <div>
                        <label for="quantity" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            Cantidad <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="quantity" id="quantity" min="1" required
                                   value="{{ old('quantity', $sale->saleItems->first() ? $sale->saleItems->first()->quantity : 1) }}"
                                   class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('quantity') border-red-300 focus:ring-red-500 @enderror">
                        </div>
                        <div class="mt-1.5 flex items-center space-x-2">
                            <span class="text-xs text-gray-500">Stock disponible:</span>
                            <span id="stock-display" class="text-xs font-semibold text-gray-900">-</span>
                        </div>
                        @error('quantity')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                    <!-- Precio Unitario -->
                    <div>
                        <label for="unit_price" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            Precio Unitario <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">$</span>
                            </div>
                            <input type="number" name="unit_price" id="unit_price" step="0.01" min="0" required
                                   value="{{ old('unit_price', $sale->saleItems->first() ? $sale->saleItems->first()->unit_price : '0.00') }}"
                                   class="block w-full pl-10 sm:pl-11 pr-3 sm:pr-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('unit_price') border-red-300 focus:ring-red-500 @enderror">
                        </div>
                        @error('unit_price')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Total -->
                    <div>
                        <label for="total" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            Total <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">$</span>
                            </div>
                            <input type="number" name="total" id="total" step="0.01" min="0" required readonly
                                   value="{{ old('total', $sale->total) }}"
                                   class="block w-full pl-10 sm:pl-11 pr-3 sm:pr-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 bg-gray-50 focus:outline-none">
                        </div>
                        @error('total')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Notas -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-gray-50 text-gray-600">
                    <i class="fas fa-sticky-note text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información Adicional</h2>
            </div>

            <div>
                <label for="notes" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                    Notas adicionales
                </label>
                <textarea name="notes" id="notes" rows="3"
                          class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none @error('notes') border-red-300 focus:ring-red-500 @enderror"
                          placeholder="Agrega notas adicionales sobre la venta...">{{ old('notes', $sale->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1.5"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-gray-50 text-gray-600">
                    <i class="fas fa-info-circle text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información del Sistema</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-hashtag text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Número de Factura</div>
                            <div class="text-base sm:text-lg font-bold text-gray-900">{{ $sale->invoice_number }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-check-circle text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Estado</div>
                            <div>
                                @if($sale->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                        <i class="fas fa-check-circle mr-1.5"></i>
                                        Completada
                                    </span>
                                @elseif($sale->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                        <i class="fas fa-clock mr-1.5"></i>
                                        Pendiente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                        <i class="fas fa-times-circle mr-1.5"></i>
                                        Cancelada
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-calendar-plus text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Fecha de Creación</div>
                            <div class="text-sm font-semibold text-gray-900">{{ $sale->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-calendar-edit text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Última Actualización</div>
                            <div class="text-sm font-semibold text-gray-900">{{ $sale->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-4 border-t border-gray-100">
            <div class="text-xs sm:text-sm text-gray-500 flex items-center">
                <i class="fas fa-info-circle mr-1.5"></i>
                Los campos marcados con <span class="text-red-500 ml-1">*</span> son obligatorios
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="{{ route('sales.show', $sale) }}"
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-emerald-600 bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 hover:border-emerald-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm hover:shadow-md"
                        :disabled="loading">
                    <template x-if="!loading">
                        <i class="fas fa-save mr-2"></i>
                    </template>
                    <template x-if="loading">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                    </template>
                    <span x-text="loading ? 'Procesando...' : 'Actualizar Venta'">Actualizar Venta</span>
                </button>
            </div>
        </div>
    </form>
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
            const stock = parseInt(selectedOption.dataset.stock);
            stockDisplay.textContent = stock;
            quantityInput.max = stock;

            // Validar cantidad actual si es mayor que el stock
            if (parseInt(quantityInput.value) > stock) {
                quantityInput.value = stock;
                updateTotal();
            }
        } else {
            stockDisplay.textContent = '-';
            quantityInput.removeAttribute('max');
        }
    }

    function updatePrice() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.price) {
            unitPriceInput.value = parseFloat(selectedOption.dataset.price).toFixed(2);
            updateTotal();
        }
    }

    // Event listeners
    if (productSelect) {
        productSelect.addEventListener('change', function() {
            updatePrice();
            updateStock();
        });
    }

    if (quantityInput) {
        quantityInput.addEventListener('input', function() {
            updateTotal();
            // Validar que no exceda el stock disponible
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (selectedOption && selectedOption.dataset.stock) {
                const stock = parseInt(selectedOption.dataset.stock);
                if (parseInt(this.value) > stock) {
                    this.value = stock;
                    updateTotal();
                }
            }
        });
    }

    if (unitPriceInput) {
        unitPriceInput.addEventListener('input', updateTotal);
    }

    // Inicializar
    if (productSelect && productSelect.value) {
        updatePrice();
        updateStock();
    }
    updateTotal();
});
</script>
@endpush
@endsection
