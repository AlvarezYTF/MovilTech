@extends('layouts.app')

@section('title', 'Detalles de Categoría')
@section('header', 'Detalles de Categoría')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header mejorado con gradiente -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-gray-200 rounded-xl shadow-sm p-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
            <div class="flex items-start space-x-4">
                <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100" 
                     data-color="{{ $category->color }}">
                    <i class="fas fa-tag text-3xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                        @if($category->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Activo
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-pause-circle mr-1"></i>
                                Inactivo
                            </span>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-hashtag text-gray-400"></i>
                            <span class="text-gray-600">ID:</span>
                            <span class="font-medium text-gray-900">#{{ $category->id }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-palette text-gray-400"></i>
                            <span class="text-gray-600">Color:</span>
                            <span class="font-medium text-gray-900">{{ $category->color }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-boxes text-gray-400"></i>
                            <span class="text-gray-600">Productos:</span>
                            <span class="font-medium text-gray-900">{{ $category->products->count() }} productos</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('categories.edit', $category) }}" 
                   class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Categoría
                </a>
                
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a Categorías
                </a>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información básica -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-info text-blue-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Información Básica</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-hashtag text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">ID de la Categoría</div>
                                <div class="text-lg font-semibold text-gray-900">#{{ $category->id }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-palette text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Color de la Categoría</div>
                                <div class="flex items-center space-x-2">
                                    <div class="h-6 w-6 rounded-full border-2 border-gray-300" 
                                         data-color="{{ $category->color }}"></div>
                                    <span class="text-sm font-medium text-gray-900">{{ $category->color }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-calendar-plus text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Fecha de Creación</div>
                                <div class="text-sm text-gray-900">{{ $category->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-calendar-edit text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Última Actualización</div>
                                <div class="text-sm text-gray-900">{{ $category->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($category->description)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-start space-x-3">
                        <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-align-left text-gray-600"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-2">Descripción</div>
                            <div class="text-sm text-gray-900 leading-relaxed">{{ $category->description }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Productos asociados -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-boxes text-green-600 text-sm"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Productos Asociados</h3>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $category->products->count() }} productos
                        </span>
                    </div>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($category->products as $product)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-box text-gray-600"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500">ID: #{{ $product->id }}</div>
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
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Bajo
                                                </span>
                                            @elseif($product->quantity == 0)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    Sin stock
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-green-600">${{ number_format($product->price, 2) }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('products.show', $product) }}" 
                                           class="text-blue-600 hover:text-blue-900 mr-3" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}" 
                                           class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <div class="mx-auto h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                            <i class="fas fa-box text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay productos asociados</h3>
                        <p class="text-sm text-gray-500 mb-6">Esta categoría no tiene productos asignados aún</p>
                        <a href="{{ route('products.create', ['category_id' => $category->id]) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Agregar primer producto
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Panel lateral -->
        <div class="space-y-6">
            <!-- Estadísticas mejoradas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-chart-bar text-purple-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Estadísticas</h3>
                </div>
                
                <div class="space-y-6">
                    <!-- Total de productos -->
                    <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-boxes text-blue-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-blue-600">{{ $category->products->count() }}</div>
                        <div class="text-sm font-medium text-gray-500">Total de Productos</div>
                    </div>
                    
                    <!-- Productos activos -->
                    <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-green-600">
                            {{ $category->products->where('status', 'active')->count() }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">Productos Activos</div>
                    </div>
                    
                    <!-- Stock total -->
                    <div class="text-center p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-warehouse text-yellow-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-yellow-600">
                            {{ $category->products->sum('quantity') }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">Stock Total</div>
                    </div>
                    
                    <!-- Valor total -->
                    <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                        <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-dollar-sign text-purple-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-purple-600">
                            ${{ number_format($category->products->sum(function($product) { return $product->quantity * $product->price; }), 0) }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">Valor Total</div>
                    </div>
                </div>
            </div>
            
            <!-- Estado de la categoría -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-info-circle text-green-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Estado de la Categoría</h3>
                </div>
                
                <div class="space-y-4">
                    @if($category->is_active)
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-green-800">Categoría Activa</div>
                                    <div class="text-xs text-green-600">Aparece en formularios de productos</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-pause-circle text-gray-500 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-gray-800">Categoría Inactiva</div>
                                    <div class="text-xs text-gray-600">No aparece en formularios de productos</div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-500 mb-2">Color de la categoría:</div>
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-8 rounded-lg border-2 border-gray-300" 
                                 data-color="{{ $category->color }}"></div>
                            <span class="text-sm font-medium text-gray-900">{{ $category->color }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Acciones rápidas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-bolt text-indigo-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Acciones Rápidas</h3>
                </div>
                
                <div class="space-y-3">
                    <a href="{{ route('products.create', ['category_id' => $category->id]) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Agregar Producto
                    </a>
                    
                    <a href="{{ route('products.index', ['category_id' => $category->id]) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-list mr-2"></i>
                        Ver Todos los Productos
                    </a>
                    
                    <a href="{{ route('categories.edit', $category) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Categoría
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
        if (color) {
            if (element.querySelector('i')) {
                // Es el ícono principal
                element.style.backgroundColor = color + '20';
                element.querySelector('i').style.color = color;
            } else {
                // Es el círculo de color
                element.style.backgroundColor = color;
            }
        }
    });
    
    // Agregar efectos hover a las tarjetas
    const cards = document.querySelectorAll('.bg-white.rounded-xl');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease-in-out';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Animación de entrada para las estadísticas
    const statsCards = document.querySelectorAll('.text-center.p-4');
    statsCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 200 + (index * 100));
    });
    
    // Animación de entrada para la tabla de productos
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease-out';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, 300 + (index * 50));
    });
    
    // Efectos de hover mejorados para las filas de la tabla
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f9fafb';
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'all 0.2s ease-in-out';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = 'scale(1)';
        });
    });
    
    // Animación de números para las estadísticas
    const statNumbers = document.querySelectorAll('.text-2xl.font-bold');
    statNumbers.forEach(number => {
        const finalValue = number.textContent;
        if (finalValue.includes('$')) {
            // Para valores monetarios
            const numericValue = parseFloat(finalValue.replace(/[$,]/g, ''));
            if (!isNaN(numericValue)) {
                animateNumber(number, 0, numericValue, 1500, '$');
            }
        } else if (!isNaN(parseInt(finalValue))) {
            // Para números enteros
            const numericValue = parseInt(finalValue);
            animateNumber(number, 0, numericValue, 1000);
        }
    });
});

function animateNumber(element, start, end, duration, prefix = '') {
    const startTime = performance.now();
    
    function updateNumber(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        const current = Math.floor(start + (end - start) * progress);
        element.textContent = prefix + current.toLocaleString();
        
        if (progress < 1) {
            requestAnimationFrame(updateNumber);
        }
    }
    
    requestAnimationFrame(updateNumber);
}
</script>
@endpush
@endsection
