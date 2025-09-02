@extends('layouts.app')

@section('title', 'Editar Producto')
@section('header', 'Editar Producto')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <!-- Header mejorado -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
            <div class="flex items-center">
                <div class="mr-4 p-3 rounded-lg bg-indigo-100 border border-indigo-200">
                    <i class="fas fa-edit text-indigo-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Editar Producto</h3>
                    <p class="text-sm text-gray-600 mt-1">Modifica la información del producto: <span class="font-medium">{{ $product->name }}</span></p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('products.update', $product) }}" class="p-6 space-y-8" id="product-form">
            @csrf
            @method('PUT')
            
            <!-- Sección 1: Información Básica -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-info text-blue-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Información Básica</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-11">
                    <!-- Nombre del producto -->
                    <div class="md:col-span-2">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag mr-2 text-gray-400"></i>
                            Nombre del producto <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $product->name) }}" 
                               class="form-input @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" 
                               placeholder="Ej: iPhone 13 Pro Max 128GB - Negro"
                               required>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Incluye marca, modelo, capacidad y color para mejor identificación
                        </p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div>
                        <label for="sku" class="form-label">
                            <i class="fas fa-barcode mr-2 text-gray-400"></i>
                            Código SKU <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="sku" 
                               name="sku" 
                               value="{{ old('sku', $product->sku) }}" 
                               class="form-input @error('sku') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" 
                               placeholder="Ej: IP13PM-128-SLV"
                               required>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Código único para identificar el producto (máx. 50 caracteres)
                        </p>
                        @error('sku')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label for="category_id" class="form-label">
                            <i class="fas fa-folder mr-2 text-gray-400"></i>
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" 
                                name="category_id" 
                                class="form-input @error('category_id') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" 
                                required>
                            <option value="">Seleccionar categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Organiza tus productos por tipo o marca
                        </p>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                </div>
            </div>

            <!-- Sección 2: Gestión de Stock -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-boxes text-green-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Gestión de Stock</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-11">
                    <!-- Stock actual -->
                    <div>
                        <label for="quantity" class="form-label">
                            <i class="fas fa-warehouse mr-2 text-gray-400"></i>
                            Stock actual <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               id="quantity"
                               name="quantity"
                               value="{{ old('quantity', $product->quantity) }}"
                               class="form-input @error('quantity') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200"
                               min="0"
                               required>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Cantidad de unidades disponibles actualmente
                        </p>
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Alerta de stock bajo -->
                    <div>
                        <label for="low_stock_threshold" class="form-label">
                            <i class="fas fa-exclamation-triangle mr-2 text-gray-400"></i>
                            Alerta de stock bajo <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               id="low_stock_threshold"
                               name="low_stock_threshold"
                               value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}"
                               class="form-input @error('low_stock_threshold') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200"
                               min="0"
                               required>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Se mostrará alerta cuando el stock sea menor o igual a este valor
                        </p>
                        @error('low_stock_threshold')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección 3: Precios -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-yellow-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Precios</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-11">
                    <!-- Precio de venta -->
                    <div>
                        <label for="price" class="form-label">
                            <i class="fas fa-tag mr-2 text-gray-400"></i>
                            Precio de venta <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">$</span>
                            </div>
                            <input type="number" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price', $product->price) }}" 
                                   class="pl-8 form-input @error('price') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200" 
                                   step="0.01" 
                                   min="0" 
                                   placeholder="0.00" 
                                   required>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Precio al que se venderá el producto al cliente
                        </p>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Precio de costo -->
                    <div>
                        <label for="cost_price" class="form-label">
                            <i class="fas fa-shopping-cart mr-2 text-gray-400"></i>
                            Precio de costo
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">$</span>
                            </div>
                            <input type="number" 
                                   id="cost_price" 
                                   name="cost_price" 
                                   value="{{ old('cost_price', $product->cost_price) }}" 
                                   class="pl-8 form-input @error('cost_price') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200" 
                                   step="0.01" 
                                   min="0" 
                                   placeholder="0.00">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Precio al que se compró el producto (opcional, para calcular ganancias)
                        </p>
                        @error('cost_price')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <!-- Cálculo de margen -->
                <div class="pl-11">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h5 class="text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calculator mr-2"></i>
                            Cálculo de ganancia
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="text-center">
                                <div class="text-gray-500">Precio de venta</div>
                                <div class="font-semibold text-gray-900" id="display-price">$0.00</div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500">Precio de costo</div>
                                <div class="font-semibold text-gray-900" id="display-cost">$0.00</div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500">Ganancia</div>
                                <div class="font-semibold text-green-600" id="display-profit">$0.00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección 4: Estado del Producto -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-toggle-on text-purple-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Estado del Producto</h4>
                </div>
                
                <div class="pl-11">
                    <div>
                        <label for="status" class="form-label">
                            <i class="fas fa-power-off mr-2 text-gray-400"></i>
                            Estado
                        </label>
                        <select id="status" 
                                name="status" 
                                class="form-input @error('status') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>
                                Activo
                            </option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                Inactivo
                            </option>
                            <option value="discontinued" {{ old('status', $product->status) == 'discontinued' ? 'selected' : '' }}>
                                Descontinuado
                            </option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Los productos inactivos no aparecerán en las ventas
                        </p>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-info-circle text-gray-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Información del Sistema</h4>
                </div>
                
                <div class="pl-11">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">ID del producto:</span>
                                <span class="text-gray-900 ml-2">{{ $product->id }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">SKU actual:</span>
                                <span class="text-gray-900 ml-2">{{ $product->sku }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Fecha de creación:</span>
                                <span class="text-gray-900 ml-2">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Última actualización:</span>
                                <span class="text-gray-900 ml-2">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex items-center justify-between pt-8 border-t border-gray-200 bg-gray-50 -mx-6 px-6 py-4 rounded-b-lg">
                <div class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Los campos marcados con <span class="text-red-500">*</span> son obligatorios
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al inventario
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Producto
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del formulario
    const priceInput = document.getElementById('price');
    const costPriceInput = document.getElementById('cost_price');
    const displayPrice = document.getElementById('display-price');
    const displayCost = document.getElementById('display-cost');
    const displayProfit = document.getElementById('display-profit');
    
    // Función para formatear moneda
    function formatCurrency(value) {
        return '$' + parseFloat(value || 0).toFixed(2);
    }
    
    // Función para calcular y mostrar ganancia
    function updateProfitCalculation() {
        const price = parseFloat(priceInput.value) || 0;
        const cost = parseFloat(costPriceInput.value) || 0;
        const profit = price - cost;
        
        displayPrice.textContent = formatCurrency(price);
        displayCost.textContent = formatCurrency(cost);
        displayProfit.textContent = formatCurrency(profit);
        
        // Cambiar color según la ganancia
        if (profit > 0) {
            displayProfit.className = 'font-semibold text-green-600';
        } else if (profit < 0) {
            displayProfit.className = 'font-semibold text-red-600';
        } else {
            displayProfit.className = 'font-semibold text-gray-600';
        }
    }
    
    // Event listeners para cálculos automáticos
    priceInput.addEventListener('input', updateProfitCalculation);
    costPriceInput.addEventListener('input', updateProfitCalculation);
    
    // Formateo de precios al perder el foco
    [priceInput, costPriceInput].forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
                updateProfitCalculation();
            }
        });
    });
    
    // Validación en tiempo real
    const form = document.getElementById('product-form');
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('border-red-300');
            } else {
                this.classList.remove('border-red-300');
            }
        });
    });
    
    // Inicializar cálculo
    updateProfitCalculation();
});
</script>
@endpush

@endsection
