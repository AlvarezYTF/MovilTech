@extends('layouts.app')

@section('title', 'Nuevo Producto')
@section('header', 'Crear Nuevo Producto')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="mr-3 p-2 rounded-lg bg-blue-50 border border-blue-100">
                    <i class="fas fa-plus text-blue-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Nuevo Producto</h3>
                    <p class="text-sm text-gray-500">Completa la información para crear un nuevo producto</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('products.store') }}" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre del producto -->
                <div class="md:col-span-2">
                    <label for="name" class="form-label">
                        Nombre del producto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="form-input @error('name') border-red-300 @enderror" 
                           placeholder="Ej: iPhone 13 Pro Max 128GB"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="form-label">
                        SKU <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="sku" 
                           name="sku" 
                           value="{{ old('sku') }}"
                           class="form-input @error('sku') border-red-300 @enderror" 
                           placeholder="Ej: IP13PM-128-SLV"
                           required>
                    @error('sku')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categoría -->
                <div>
                    <label for="category_id" class="form-label">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" 
                            name="category_id"
                            class="form-input @error('category_id') border-red-300 @enderror" 
                            required>
                        <option value="">Seleccionar categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                                    <!-- Stock -->
                    <div>
                        <label for="quantity" class="form-label">
                            Stock <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               id="quantity"
                               name="quantity"
                               value="{{ old('quantity', 0) }}"
                               class="form-input @error('quantity') border-red-300 @enderror"
                               min="0"
                               required>
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock bajo -->
                    <div>
                        <label for="low_stock_threshold" class="form-label">
                            Alerta de stock bajo <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               id="low_stock_threshold"
                               name="low_stock_threshold"
                               value="{{ old('low_stock_threshold', 10) }}"
                               class="form-input @error('low_stock_threshold') border-red-300 @enderror"
                               min="0"
                               required>
                        @error('low_stock_threshold')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Se mostrará alerta cuando el stock sea menor o igual a este valor</p>
                    </div>

                <!-- Precio de venta -->
                <div>
                    <label for="price" class="form-label">
                        Precio de venta <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price') }}"
                               class="pl-8 form-input @error('price') border-red-300 @enderror" 
                               step="0.01" 
                               min="0" 
                               placeholder="0.00" 
                               required>
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio de costo -->
                <div>
                    <label for="cost_price" class="form-label">Precio de costo</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input type="number" 
                               id="cost_price" 
                               name="cost_price" 
                               value="{{ old('cost_price') }}"
                               class="pl-8 form-input @error('cost_price') border-red-300 @enderror" 
                               step="0.01" 
                               min="0" 
                               placeholder="0.00">
                    </div>
                    @error('cost_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="status" class="form-label">Estado</label>
                    <select id="status" 
                            name="status"
                            class="form-input @error('status') border-red-300 @enderror">
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Activo</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Descontinuado</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Crear Producto
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Formateo de precios
    const priceInputs = ['price', 'cost_price'];
    priceInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('blur', function() {
                if (this.value) {
                    this.value = parseFloat(this.value).toFixed(2);
                }
            });
        }
    });
</script>
@endpush

@endsection