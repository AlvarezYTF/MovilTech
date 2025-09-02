@extends('layouts.app')

@section('title', $product->name)
@section('header', 'Detalles del Producto')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header con acciones -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="flex items-center">
                <div class="mr-4 p-3 rounded-lg flex items-center justify-center bg-gray-50 border border-gray-100">
                    <i class="fas fa-box text-2xl text-gray-600"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-3 mt-1">
                        <span class="text-lg font-semibold text-green-600">${{ number_format($product->price, 2) }}</span>
                        <span class="text-gray-400">•</span>
                        <span class="text-sm text-gray-500">SKU: {{ $product->sku }}</span>
                        <span class="text-gray-400">•</span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-boxes mr-1"></i>
                            {{ $product->quantity }} en stock
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('products.edit', $product) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detalles del producto -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información del producto</h3>
                
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->id }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">SKU</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->sku }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Categoría</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                  style="background-color: {{ $product->category->color }}20; color: {{ $product->category->color }};">
                                {{ $product->category->name }}
                            </span>
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                        <dd class="mt-1">
                            @if($product->status == 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Activo
                                </span>
                            @elseif($product->status == 'inactive')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-pause-circle mr-1"></i>
                                    Inactivo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Descontinuado
                                </span>
                            @endif
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Precio de venta</dt>
                        <dd class="mt-1 text-sm font-semibold text-green-600">${{ number_format($product->price, 2) }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Precio de costo</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $product->cost_price ? '$' . number_format($product->cost_price, 2) : 'No especificado' }}
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha de creación</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->updated_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    

                </dl>
            </div>
        </div>
        
        <!-- Panel lateral -->
        <div class="space-y-6">
            <!-- Stock y disponibilidad -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Stock y disponibilidad</h3>
                
                <div class="space-y-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900 mb-2">{{ $product->quantity }}</div>
                        <div class="text-sm text-gray-500">Unidades en stock</div>
                    </div>
                    
                    @php
                        $stockPercentage = $product->quantity > 0 ? min(100, ($product->quantity / 100) * 100) : 0;
                        $stockColor = $stockPercentage > 50 ? 'bg-green-500' : ($stockPercentage > 20 ? 'bg-yellow-500' : 'bg-red-500');
                    @endphp
                    
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full {{ $stockColor }}" style="width: {{ $stockPercentage }}%"></div>
                    </div>
                    
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Disponibilidad</span>
                        <span>{{ $stockPercentage }}%</span>
                    </div>
                    
                    @if($product->quantity < 10 && $product->quantity > 0)
                        <div class="text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Stock bajo
                            </span>
                        </div>
                    @elseif($product->quantity == 0)
                        <div class="text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>
                                Sin stock
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Acciones rápidas -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones rápidas</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('products.edit', $product) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Editar producto
                    </a>
                    
                    <form method="POST" action="{{ route('products.destroy', $product) }}" 
                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar producto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
