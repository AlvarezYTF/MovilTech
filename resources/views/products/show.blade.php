@extends('layouts.app')

@section('title', $product->name)
@section('header', 'Detalle del Producto')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header con acciones -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
            <p class="text-gray-600">SKU: {{ $product->sku }}</p>
        </div>
        
        <div class="flex space-x-3">
            @can('edit_products')
            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                <i class="fas fa-edit mr-2"></i>
                Editar
            </a>
            @endcan
            
            @can('delete_products')
            <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline" 
                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash mr-2"></i>
                    Eliminar
                </button>
            </form>
            @endcan
            
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información principal del producto -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Imagen del producto -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagen del Producto</h3>
                @if($product->image)
                    <div class="flex justify-center">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" 
                             class="max-w-md h-auto rounded-lg shadow-lg">
                    </div>
                @else
                    <div class="flex justify-center items-center h-64 bg-gray-100 rounded-lg">
                        <div class="text-center">
                            <i class="fas fa-box text-6xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500">Sin imagen</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Descripción -->
            @if($product->description)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Descripción</h3>
                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
            </div>
            @endif

            <!-- Información de ventas -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de Ventas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-blue-600">Precio de Venta</div>
                        <div class="text-2xl font-bold text-blue-900">${{ number_format($product->price, 2) }}</div>
                    </div>
                    
                    @if($product->cost_price)
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-green-600">Precio de Costo</div>
                        <div class="text-2xl font-bold text-green-900">${{ number_format($product->cost_price, 2) }}</div>
                    </div>
                    @endif
                    
                    @if($product->cost_price && $product->cost_price > 0)
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-purple-600">Margen de Ganancia</div>
                        <div class="text-2xl font-bold text-purple-900">{{ number_format($product->profit_margin, 1) }}%</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar con información adicional -->
        <div class="space-y-6">
            <!-- Estado y stock -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estado y Stock</h3>
                
                <!-- Estado -->
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-600">Estado</label>
                    <div class="mt-1">
                        @if($product->status == 'active')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                Activo
                            </span>
                        @elseif($product->status == 'inactive')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-pause-circle mr-2"></i>
                                Inactivo
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-2"></i>
                                Descontinuado
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Stock -->
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-600">Stock Disponible</label>
                    <div class="mt-1">
                        @if($product->quantity > 0)
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-gray-900 mr-2">{{ $product->quantity }}</span>
                                @if($product->quantity < 10)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Stock bajo
                                    </span>
                                @endif
                            </div>
                        @else
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-red-600 mr-2">0</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Sin stock
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Indicador de stock -->
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-600">Nivel de Stock</label>
                    <div class="mt-2">
                        @php
                            $stockPercentage = $product->quantity > 0 ? min(100, ($product->quantity / 100) * 100) : 0;
                            $stockColor = $stockPercentage > 50 ? 'bg-green-500' : ($stockPercentage > 20 ? 'bg-yellow-500' : 'bg-red-500');
                        @endphp
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="{{ $stockColor }} h-2 rounded-full" style="width: {{ $stockPercentage }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $stockPercentage }}% del stock máximo</p>
                    </div>
                </div>
            </div>

            <!-- Categoría y proveedor -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Clasificación</h3>
                
                <!-- Categoría -->
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-600">Categoría</label>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                              style="background-color: {{ $product->category->color }}20; color: {{ $product->category->color }};">
                            {{ $product->category->name }}
                        </span>
                    </div>
                </div>

                <!-- Proveedor -->
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-600">Proveedor</label>
                    <div class="mt-1">
                        <span class="text-sm text-gray-900">{{ $product->supplier->name }}</span>
                        @if($product->supplier->email)
                            <p class="text-xs text-gray-500">{{ $product->supplier->email }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información del sistema -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Sistema</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID del Producto:</span>
                        <span class="font-medium text-gray-900">#{{ $product->id }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Creado:</span>
                        <span class="font-medium text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Última actualización:</span>
                        <span class="font-medium text-gray-900">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
