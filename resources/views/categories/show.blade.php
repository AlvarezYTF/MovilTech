@extends('layouts.app')

@section('title', 'Detalles de Categoría')
@section('header', 'Detalles de Categoría')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header con acciones -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="flex items-center">
                <div class="mr-4 p-3 rounded-lg flex items-center justify-center" 
                     style="background-color: {{ $category->color }}20;">
                    <i class="fas fa-tag text-2xl" style="color: {{ $category->color }};"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">{{ $category->name }}</h1>
                    <div class="flex items-center space-x-3 mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            <i class="fas {{ $category->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                            {{ $category->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                        <span class="text-gray-400">•</span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-box mr-1"></i>
                            {{ $category->products->count() }} productos
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('categories.edit', $category) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                
                <a href="{{ route('categories.index') }}" 
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
            <!-- Detalles de la categoría -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información de la categoría</h3>
                
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->id }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Color</dt>
                        <dd class="mt-1 flex items-center">
                            <div class="h-6 w-6 rounded-full mr-2 border border-gray-300" 
                                 style="background-color: {{ $category->color }};"></div>
                            <span class="text-sm text-gray-900">{{ $category->color }}</span>
                        </dd>
                    </div>
                    
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $category->description ?: 'Sin descripción' }}
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha de creación</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
            
            <!-- Productos asociados -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Productos asociados</h3>
                </div>
                
                @if($category->products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Producto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        SKU
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stock
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Precio
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($category->products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($product->image)
                                                <img class="h-8 w-8 rounded object-cover mr-3" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <div class="h-8 w-8 rounded bg-gray-200 flex items-center justify-center mr-3">
                                                    <i class="fas fa-box text-gray-400 text-xs"></i>
                                                </div>
                                            @endif
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $product->sku }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $product->quantity }}</div>
                                        @if($product->quantity < 10)
                                            <div class="text-xs text-red-600">Stock bajo</div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($product->price, 2) }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->status == 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Activo
                                            </span>
                                        @elseif($product->status == 'inactive')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Inactivo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Descontinuado
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-8 text-center">
                        <i class="fas fa-box text-4xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-500 mb-2">No hay productos asociados</p>
                        <p class="text-sm text-gray-400">Esta categoría no tiene productos asignados</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Panel lateral -->
        <div class="space-y-6">
            <!-- Estadísticas -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Estadísticas</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Total de productos</span>
                        <span class="text-lg font-semibold text-gray-900">{{ $category->products->count() }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Productos activos</span>
                        <span class="text-lg font-semibold text-green-600">
                            {{ $category->products->where('status', 'active')->count() }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Stock total</span>
                        <span class="text-lg font-semibold text-blue-600">
                            {{ $category->products->sum('quantity') }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Valor total</span>
                        <span class="text-lg font-semibold text-purple-600">
                            ${{ number_format($category->products->sum(function($product) { return $product->quantity * $product->price; }), 2) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Acciones rápidas -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones rápidas</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('products.create', ['category_id' => $category->id]) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Agregar producto
                    </a>
                    
                    <a href="{{ route('products.index', ['category_id' => $category->id]) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        <i class="fas fa-list mr-2"></i>
                        Ver todos los productos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
