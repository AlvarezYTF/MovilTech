@extends('layouts.app')

@section('title', 'Nuevo Producto')
@section('header', 'Crear Nuevo Producto')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <!-- Form Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="mr-4 p-3 rounded-lg bg-white shadow-sm">
                    <i class="fas fa-box text-gray-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-800">Nuevo Producto</h1>
                    <p class="text-sm text-gray-500">Complete todos los campos requeridos (*) para registrar un nuevo producto</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="p-6 space-y-6 col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre del producto -->
                    <div class="md:col-span-2">
                        <label for="name" class="form-label">Nombre del Producto *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="pl-10 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50 transition duration-150 ease-in-out @error('name') border-red-500 @enderror"
                                placeholder="Ej: iPhone 13 Pro Max 128GB" required>
                        </div>
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div class="md:col-span-2">
                        <label for="sku" class="form-label">SKU *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-barcode text-gray-400"></i>
                            </div>
                            <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                                class="pl-10 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50 transition duration-150 ease-in-out @error('sku') border-red-500 @enderror"
                                placeholder="Ej: IP13PM-128-SLV" required>
                        </div>
                        @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div class="md:col-span-2">
                        <label for="category_id" class="form-label">Categoría *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-folder text-gray-400"></i>
                            </div>
                            <select id="category_id" name="category_id"
                                class="pl-10 form-select block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50 transition duration-150 ease-in-out @error('category_id') border-red-500 @enderror" required>
                                <option value="">Seleccionar categoría</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Cantidad/Stock -->
                    <div class="md:col-span-2">
                        <label for="quantity" class="form-label">Stock *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-boxes text-gray-400"></i>
                            </div>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 0) }}"
                                class="pl-10 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50 transition duration-150 ease-in-out @error('quantity') border-red-500 @enderror"
                                min="0" required>
                        </div>
                        @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Precio de venta -->
                    <div class="md:col-span-2">
                        <label for="price" class="form-label">Precio de Venta *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number" id="price" name="price" value="{{ old('price') }}"
                                class="pl-10 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50 transition duration-150 ease-in-out @error('price') border-red-500 @enderror"
                                step="0.01" min="0" placeholder="0.00" required>
                        </div>
                        @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo oculto para status -->
                    <input type="hidden" name="status" value="active">
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        <i class="fas fa-times mr-2 text-gray-500"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Producto
                    </button>
                </div>
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