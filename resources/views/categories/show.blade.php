@extends('layouts.app')

@section('title', 'Detalles de Categoría')
@section('header', 'Detalles de Categoría')

@section('content')
<div class="max-w-7xl mx-auto space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-start space-x-3 sm:space-x-4 flex-1 min-w-0">
                <div class="p-3 sm:p-4 rounded-xl shadow-sm border border-gray-200 flex-shrink-0"
                     data-color="{{ $category->color }}">
                    <i class="fas fa-tag text-2xl sm:text-3xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-2">
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 truncate">{{ $category->name }}</h1>
                        @if($category->is_active)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                <i class="fas fa-check-circle mr-1.5"></i>
                                Activo
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                <i class="fas fa-pause-circle mr-1.5"></i>
                                Inactivo
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs sm:text-sm">
                        <div class="flex items-center space-x-1.5 text-gray-600">
                            <i class="fas fa-hashtag text-gray-400"></i>
                            <span class="font-medium text-gray-900">ID: #{{ $category->id }}</span>
                        </div>
                        <div class="flex items-center space-x-1.5 text-gray-600">
                            <i class="fas fa-palette text-gray-400"></i>
                            <span class="font-medium text-gray-900">Color:</span>
                            <div class="h-4 w-4 rounded-full border-2 border-gray-200 shadow-sm" 
                                 data-color-circle="{{ $category->color }}"></div>
                            <span class="font-mono text-gray-900">{{ $category->color }}</span>
                        </div>
                        <div class="flex items-center space-x-1.5 text-gray-600">
                            <i class="fas fa-boxes text-gray-400"></i>
                            <span class="font-medium text-gray-900">{{ $category->products->count() }} productos</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                @can('edit_categories')
                <a href="{{ route('categories.edit', $category) }}"
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Categoría
                </a>
                @endcan
                
                <a href="{{ route('categories.index') }}"
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-violet-600 bg-violet-600 text-white text-sm font-semibold hover:bg-violet-700 hover:border-violet-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 shadow-sm hover:shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Información principal -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Información básica -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                        <i class="fas fa-info text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información Básica</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-hashtag text-gray-400 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">ID de la Categoría</div>
                                <div class="text-base font-semibold text-gray-900">#{{ $category->id }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-palette text-gray-400 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Color de la Categoría</div>
                                <div class="flex items-center space-x-2">
                                    <div class="h-6 w-6 rounded-full border-2 border-gray-200 shadow-sm" 
                                         data-color-circle="{{ $category->color }}"></div>
                                    <span class="text-sm font-semibold text-gray-900 font-mono">{{ $category->color }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-plus text-gray-400 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Fecha de Creación</div>
                                <div class="text-sm text-gray-900">{{ $category->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-edit text-gray-400 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Última Actualización</div>
                                <div class="text-sm text-gray-900">{{ $category->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($category->description)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="flex items-start space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-align-left text-gray-400 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Descripción</div>
                            <div class="text-sm text-gray-700 leading-relaxed">{{ $category->description }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Productos asociados -->
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <div class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                                <i class="fas fa-boxes text-sm"></i>
                            </div>
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Productos Asociados</h2>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                            {{ $category->products->count() }} productos
                        </span>
                    </div>
                </div>
                
                @if($category->products->count() > 0)
                    <!-- Tabla Desktop -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Producto
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        SKU
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Stock
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Precio
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($category->products as $product)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-xl bg-gray-50 flex items-center justify-center mr-3 flex-shrink-0">
                                                <i class="fas fa-box text-gray-400 text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5">ID: #{{ $product->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-mono">{{ $product->sku }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <div class="text-sm font-semibold text-gray-900">{{ $product->quantity }}</div>
                                            @if($product->hasLowStock())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Bajo
                                                </span>
                                            @elseif($product->quantity == 0)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    Sin stock
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-emerald-600">${{ number_format($product->price, 2) }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->status == 'active')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                                <i class="fas fa-check-circle mr-1.5"></i>
                                                Activo
                                            </span>
                                        @elseif($product->status == 'inactive')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                <i class="fas fa-pause-circle mr-1.5"></i>
                                                Inactivo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                                <i class="fas fa-times-circle mr-1.5"></i>
                                                Descontinuado
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('products.show', $product) }}"
                                               class="text-blue-600 hover:text-blue-700 transition-colors"
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('edit_products')
                                            <a href="{{ route('products.edit', $product) }}"
                                               class="text-indigo-600 hover:text-indigo-700 transition-colors"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Cards Mobile -->
                    <div class="lg:hidden divide-y divide-gray-100">
                        @foreach($category->products as $product)
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3 flex-1 min-w-0">
                                    <div class="h-10 w-10 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-box text-gray-400 text-sm"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">SKU: {{ $product->sku }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col items-end space-y-1">
                                    @if($product->status == 'active')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Activo
                                        </span>
                                    @elseif($product->status == 'inactive')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                            <i class="fas fa-pause-circle mr-1"></i>
                                            Inactivo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Descontinuado
                                        </span>
                                    @endif
                                    <div class="text-sm font-bold text-emerald-600">
                                        ${{ number_format($product->price, 2) }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Stock</p>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-semibold text-gray-900">{{ $product->quantity }}</span>
                                        @if($product->hasLowStock())
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-amber-50 text-amber-700">
                                                <i class="fas fa-exclamation-triangle text-xs mr-0.5"></i>
                                                Bajo
                                            </span>
                                        @elseif($product->quantity == 0)
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-red-50 text-red-700">
                                                <i class="fas fa-times-circle text-xs mr-0.5"></i>
                                                Sin stock
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">ID</p>
                                    <span class="text-sm text-gray-900">#{{ $product->id }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-gray-100">
                                <a href="{{ route('products.show', $product) }}"
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Ver">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                @can('edit_products')
                                <a href="{{ route('products.edit', $product) }}"
                                   class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                   title="Editar">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                @endcan
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-4 sm:px-6 py-12 text-center">
                        <div class="mx-auto h-16 w-16 rounded-full bg-gray-50 flex items-center justify-center mb-4">
                            <i class="fas fa-box text-2xl text-gray-300"></i>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">No hay productos asociados</h3>
                        <p class="text-sm text-gray-500 mb-6">Esta categoría no tiene productos asignados aún</p>
                        @can('create_products')
                        <a href="{{ route('products.create', ['category_id' => $category->id]) }}"
                           class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-violet-600 bg-violet-600 text-white text-sm font-semibold hover:bg-violet-700 hover:border-violet-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 shadow-sm hover:shadow-md">
                            <i class="fas fa-plus mr-2"></i>
                            Agregar primer producto
                        </a>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Panel lateral -->
        <div class="space-y-4 sm:space-y-6">
            <!-- Estadísticas -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-violet-50 text-violet-600">
                        <i class="fas fa-chart-bar text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Estadísticas</h2>
                </div>
                
                <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
                    <!-- Total de productos -->
                    <div class="text-center p-3 sm:p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl bg-blue-100 flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-boxes text-blue-600 text-sm sm:text-base"></i>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-blue-600">{{ $category->products->count() }}</div>
                        <div class="text-xs sm:text-sm font-medium text-gray-500 mt-1">Total de Productos</div>
                    </div>
                    
                    <!-- Productos activos -->
                    <div class="text-center p-3 sm:p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-check-circle text-emerald-600 text-sm sm:text-base"></i>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-emerald-600">
                            {{ $category->products->where('status', 'active')->count() }}
                        </div>
                        <div class="text-xs sm:text-sm font-medium text-gray-500 mt-1">Productos Activos</div>
                    </div>
                    
                    <!-- Stock total -->
                    <div class="text-center p-3 sm:p-4 bg-amber-50 rounded-xl border border-amber-100">
                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl bg-amber-100 flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-warehouse text-amber-600 text-sm sm:text-base"></i>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-amber-600">
                            {{ $category->products->sum('quantity') }}
                        </div>
                        <div class="text-xs sm:text-sm font-medium text-gray-500 mt-1">Stock Total</div>
                    </div>
                    
                    <!-- Valor total -->
                    <div class="text-center p-3 sm:p-4 bg-violet-50 rounded-xl border border-violet-100">
                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl bg-violet-100 flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-dollar-sign text-violet-600 text-sm sm:text-base"></i>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-violet-600">
                            ${{ number_format($category->products->sum(function($product) { return $product->quantity * $product->price; }), 0) }}
                        </div>
                        <div class="text-xs sm:text-sm font-medium text-gray-500 mt-1">Valor Total</div>
                    </div>
                </div>
            </div>
            
            <!-- Estado de la categoría -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                        <i class="fas fa-info-circle text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Estado</h2>
                </div>
                
                <div class="space-y-4">
                    @if($category->is_active)
                        <div class="p-3 sm:p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-emerald-600 mr-3 text-sm"></i>
                                <div>
                                    <div class="text-sm font-semibold text-emerald-800">Categoría Activa</div>
                                    <div class="text-xs text-emerald-600 mt-0.5">Aparece en formularios de productos</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-3 sm:p-4 bg-gray-50 border border-gray-200 rounded-xl">
                            <div class="flex items-center">
                                <i class="fas fa-pause-circle text-gray-500 mr-3 text-sm"></i>
                                <div>
                                    <div class="text-sm font-semibold text-gray-800">Categoría Inactiva</div>
                                    <div class="text-xs text-gray-600 mt-0.5">No aparece en formularios de productos</div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="pt-4 border-t border-gray-100">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Color de la categoría</div>
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-8 rounded-xl border-2 border-gray-200 shadow-sm" 
                                 data-color-circle="{{ $category->color }}"></div>
                            <span class="text-sm font-semibold text-gray-900 font-mono">{{ $category->color }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Acciones rápidas -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-violet-50 text-violet-600">
                        <i class="fas fa-bolt text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Acciones Rápidas</h2>
                </div>
                
                <div class="space-y-3">
                    @can('create_products')
                    <a href="{{ route('products.create', ['category_id' => $category->id]) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl border-2 border-violet-600 bg-violet-600 text-white text-sm font-semibold hover:bg-violet-700 hover:border-violet-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 shadow-sm hover:shadow-md">
                        <i class="fas fa-plus mr-2"></i>
                        Agregar Producto
                    </a>
                    @endcan
                    
                    <a href="{{ route('products.index', ['category_id' => $category->id]) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-list mr-2"></i>
                        Ver Todos los Productos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aplicar colores a los elementos de categoría
    document.querySelectorAll('[data-color]').forEach(function(element) {
        const color = element.getAttribute('data-color');
        if (color && element.querySelector('i')) {
            element.style.backgroundColor = color + '20';
            element.querySelector('i').style.color = color;
        }
    });
    
    // Aplicar colores a los círculos de color
    document.querySelectorAll('[data-color-circle]').forEach(function(element) {
        const color = element.getAttribute('data-color-circle');
        if (color) {
            element.style.backgroundColor = color;
        }
    });
});
</script>
@endpush
@endsection
