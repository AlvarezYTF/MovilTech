@extends('layouts.app')

@section('title', $product->name)
@section('header', 'Detalles del Producto')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-4">
    <!-- Header compacto -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6 overflow-hidden">
        <div class="p-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-box text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-3 text-sm text-gray-600">
                        <span class="font-semibold">${{ number_format($product->price, 2) }}</span>
                        <span>•</span>
                        <span>SKU: {{ $product->sku }}</span>
                        <span>•</span>
                        <span class="flex items-center">
                            <i class="fas fa-cubes mr-1"></i>
                            {{ $product->quantity }} en stock
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('products.index') }}"
                    class="px-4 py-2 text-sm border rounded-md hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
        <!-- Información principal del producto -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <!-- Información Básica -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-xs font-medium text-gray-500 mb-3 uppercase tracking-wider">Información General</h3>
                                @if($product->description)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-700">{{ $product->description }}</p>
                                </div>
                                @endif
                                <dl class="space-y-2">
                                    <div class="flex justify-between py-1 border-b border-gray-100">
                                        <dt class="text-sm text-gray-600">SKU</dt>
                                        <dd class="text-sm font-medium text-gray-900">{{ $product->sku }}</dd>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-gray-100">
                                        <dt class="text-sm text-gray-600">Categoría</dt>
                                        <dd class="text-sm">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
                                                style="background-color: {{ $product->category->color }}15; color: {{ $product->category->color }};">
                                                {{ $product->category->name }}
                                            </span>
                                        </dd>
                                    </div>

                                    <!-- Estado -->
                                    <div class="flex justify-between py-1 border-b border-gray-100">
                                        <dt class="text-sm text-gray-600">Estado</dt>
                                        <dd class="text-sm">
                                            @if($product->status == 'active')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Activo
                                            </span>
                                            @elseif($product->status == 'inactive')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-pause-circle mr-1"></i>
                                                Inactivo
                                            </span>
                                            @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Descontinuado
                                            </span>
                                            @endif
                                        </dd>
                                    </div>

                                    <!-- Stock -->
                                    <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                        <dt class="text-sm text-gray-600">Stock</dt>
                                        <dd class="text-sm font-medium">
                                            @if($product->quantity > 0)
                                            <span class="text-gray-900">{{ $product->quantity }} unidades</span>
                                            @if($product->quantity < 10)
                                                <span class="ml-2 px-1.5 py-0.5 rounded text-xs bg-yellow-100 text-yellow-700">
                                                <i class="fas fa-exclamation-circle mr-0.5"></i> Bajo
                                                </span>
                                                @endif
                                                @else
                                                <span class="text-red-600">Sin stock</span>
                                                @endif
                                        </dd>
                                    </div>

                                    <!-- Nivel de Stock -->
                                    <div class="pt-2">
                                        @php
                                        $stockPercentage = $product->quantity > 0 ? min(100, ($product->quantity / 100) * 100) : 0;
                                        $stockColor = $stockPercentage > 50 ? 'bg-green-500' : ($stockPercentage > 20 ? 'bg-yellow-500' : 'bg-red-500');
                                        @endphp
                                        <div class="w-full bg-gray-100 rounded-full h-1.5 mb-1">
                                            <div class="h-1.5 rounded-full {{ $stockColor }}" style="width: {{ $stockPercentage }}%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-500">
                                            <span>Disponibilidad</span>
                                            <span>{{ $stockPercentage }}%</span>
                                        </div>
                                    </div>
                                </dl>
                            </div>
                            <!-- Acciones -->
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <div class="flex space-x-3">
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
                                        <i class="fas fa-pencil-alt mr-1.5 text-sm"></i>
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" class="flex-1"
                                        onsubmit="return confirm('¿Está seguro de que desea eliminar este producto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition duration-200">
                                            <i class="fas fa-trash mr-1.5 text-sm"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
