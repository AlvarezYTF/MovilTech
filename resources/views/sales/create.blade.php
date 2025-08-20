@extends('layouts.app')

@section('title', 'Nueva Venta')
@section('header', 'Crear Nueva Venta')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Nueva Venta</h1>
            <p class="text-gray-600">Completa la información para crear una nueva venta</p>
        </div>

        <!-- Mensajes de error -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form action="{{ route('sales.store') }}" method="POST" class="bg-white shadow-sm rounded-lg p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cliente -->
                <div class="col-span-1">
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Cliente <span class="text-red-500">*</span>
                    </label>
                    <select name="customer_id" id="customer_id" required 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecciona un cliente</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} - {{ $customer->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fecha de Venta -->
                <div class="col-span-1">
                    <label for="sale_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha de Venta <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="sale_date" id="sale_date" required
                           value="{{ old('sale_date', date('Y-m-d')) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Producto -->
                <div class="col-span-1">
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Producto <span class="text-red-500">*</span>
                    </label>
                    <select name="product_id" id="product_id" required 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecciona un producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-price="{{ $product->price }}"
                                    data-stock="{{ $product->quantity }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} - Stock: {{ $product->quantity }} - ${{ number_format($product->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Cantidad -->
                <div class="col-span-1">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Cantidad <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="quantity" id="quantity" min="1" required
                           value="{{ old('quantity', 1) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Stock disponible: <span id="stock-display">-</span></p>
                </div>

                <!-- Precio Unitario -->
                <div class="col-span-1">
                    <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Precio Unitario <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" name="unit_price" id="unit_price" step="0.01" min="0" required
                               value="{{ old('unit_price', '0.00') }}"
                               class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Total -->
                <div class="col-span-1">
                    <label for="total" class="block text-sm font-medium text-gray-700 mb-2">
                        Total <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" name="total" id="total" step="0.01" min="0" required readonly
                               value="{{ old('total', '0.00') }}"
                               class="w-full pl-8 bg-gray-100 border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Notas -->
            <div class="mt-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notas (opcional)
                </label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Agrega notas adicionales sobre la venta...">{{ old('notes') }}</textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('sales.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                    <i class="fas fa-save mr-2"></i>Crear Venta
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
