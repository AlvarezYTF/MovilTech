@extends('layouts.app')

@section('title', 'Nuevo Producto')
@section('header', 'Crear Nuevo Producto')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre del producto -->
                <div class="col-span-2">
                    <label for="name" class="form-label">Nombre del Producto *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="form-input @error('name') border-red-500 @enderror" 
                           placeholder="Nombre del producto" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="form-label">SKU *</label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku') }}" 
                           class="form-input @error('sku') border-red-500 @enderror" 
                           placeholder="Código único del producto" required>
                    @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categoría -->
                <div>
                    <label for="category_id" class="form-label">Categoría *</label>
                    <select id="category_id" name="category_id" 
                            class="form-input @error('category_id') border-red-500 @enderror" required>
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

                <!-- Proveedor -->
                <div>
                    <label for="supplier_id" class="form-label">Proveedor *</label>
                    <select id="supplier_id" name="supplier_id" 
                            class="form-input @error('supplier_id') border-red-500 @enderror" required>
                        <option value="">Seleccionar proveedor</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cantidad/Stock -->
                <div>
                    <label for="quantity" class="form-label">Stock *</label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 0) }}" 
                           class="form-input @error('quantity') border-red-500 @enderror" 
                           min="0" required>
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio de venta -->
                <div>
                    <label for="price" class="form-label">Precio de Venta *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" 
                               class="form-input pl-8 @error('price') border-red-500 @enderror" 
                               step="0.01" min="0" placeholder="0.00" required>
                    </div>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio de costo -->
                <div>
                    <label for="cost_price" class="form-label">Precio de Costo</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" id="cost_price" name="cost_price" value="{{ old('cost_price') }}" 
                               class="form-input pl-8 @error('cost_price') border-red-500 @enderror" 
                               step="0.01" min="0" placeholder="0.00">
                    </div>
                    @error('cost_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="status" class="form-label">Estado *</label>
                    <select id="status" name="status" 
                            class="form-input @error('status') border-red-500 @enderror" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Activo</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Descontinuado</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Imagen -->
                <div class="col-span-2">
                    <label for="image" class="form-label">Imagen del Producto</label>
                    <input type="file" id="image" name="image" 
                           class="form-input @error('image') border-red-500 @enderror" 
                           accept="image/*">
                    <p class="text-sm text-gray-500 mt-1">Formatos permitidos: JPEG, PNG, JPG, GIF. Máximo 2MB.</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="col-span-2">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea id="description" name="description" rows="4" 
                              class="form-input @error('description') border-red-500 @enderror" 
                              placeholder="Descripción detallada del producto">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Crear Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
