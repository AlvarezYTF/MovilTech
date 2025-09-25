@extends('layouts.app')

@section('title', $product->name)
@section('header', 'Detalles del Producto')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header mejorado con gradiente -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-gray-200 rounded-xl shadow-sm p-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
            <div class="flex items-start space-x-4">
                <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100">
                    <i class="fas fa-box text-3xl text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                        @if($product->status == 'active')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Activo
                            </span>
                        @elseif($product->status == 'inactive')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-pause-circle mr-1"></i>
                                Inactivo
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>
                                Descontinuado
                            </span>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-barcode text-gray-400"></i>
                            <span class="text-gray-600">SKU:</span>
                            <span class="font-medium text-gray-900">{{ $product->sku }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-tag text-gray-400"></i>
                            <span class="text-gray-600">Precio:</span>
                            <span class="font-bold text-green-600 text-lg">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-warehouse text-gray-400"></i>
                            <span class="text-gray-600">Stock:</span>
                            <span class="font-medium text-gray-900">{{ $product->quantity }} unidades</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('products.edit', $product) }}" 
                   class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Producto
                </a>
                
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Inventario
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
                                <i class="fas fa-barcode text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Código SKU</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $product->sku }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-folder text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Categoría</div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                                      data-color="{{ $product->category->color }}">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-hashtag text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">ID del Producto</div>
                                <div class="text-lg font-semibold text-gray-900">#{{ $product->id }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-calendar text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Creado</div>
                                <div class="text-sm text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información financiera -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-yellow-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Información Financiera</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-tag text-green-600"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-500 mb-1">Precio de Venta</div>
                        <div class="text-2xl font-bold text-green-600">${{ number_format($product->price, 2) }}</div>
                    </div>
                    
                    <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-shopping-cart text-blue-600"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-500 mb-1">Precio de Costo</div>
                        <div class="text-2xl font-bold text-blue-600">
                            {{ $product->cost_price ? '$' . number_format($product->cost_price, 2) : 'No especificado' }}
                        </div>
                    </div>
                    
                    @if($product->cost_price)
                    <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                        <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-chart-line text-purple-600"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-500 mb-1">Ganancia</div>
                        <div class="text-2xl font-bold text-purple-600">
                            ${{ number_format($product->price - $product->cost_price, 2) }}
                        </div>
                    </div>
                    @else
                    <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-percentage text-gray-600"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-500 mb-1">Margen</div>
                        <div class="text-lg font-semibold text-gray-600">No calculable</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Panel lateral -->
        <div class="space-y-6">
            <!-- Estado del Stock -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-boxes text-green-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Estado del Stock</h3>
                </div>
                
                <div class="space-y-6">
                    <!-- Número principal de stock -->
                    <div class="text-center">
                        <div class="text-4xl font-bold text-gray-900 mb-2">{{ $product->quantity }}</div>
                        <div class="text-sm text-gray-500">Unidades disponibles</div>
                    </div>
                    
                    <!-- Barra de progreso mejorada -->
                    @php
                        $maxStock = max(100, $product->quantity * 2); // Escala dinámica
                        $stockPercentage = $product->quantity > 0 ? min(100, ($product->quantity / $maxStock) * 100) : 0;
                        $stockColor = $product->quantity > $product->low_stock_threshold ? 'bg-green-500' : ($product->quantity > 0 ? 'bg-yellow-500' : 'bg-red-500');
                    @endphp
                    
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Nivel de stock</span>
                            <span class="font-medium text-gray-900">{{ $stockPercentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full {{ $stockColor }} transition-all duration-300" 
                                 data-width="{{ $stockPercentage }}"></div>
                        </div>
                    </div>
                    
                    <!-- Alertas de stock -->
                    @if($product->quantity == 0)
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-red-800">Sin stock</div>
                                    <div class="text-xs text-red-600">El producto no está disponible</div>
                                </div>
                            </div>
                        </div>
                    @elseif($product->hasLowStock())
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-yellow-800">Stock bajo</div>
                                    <div class="text-xs text-yellow-600">Quedan {{ $product->quantity }} unidades (límite: {{ $product->low_stock_threshold }})</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-green-800">Stock suficiente</div>
                                    <div class="text-xs text-green-600">Disponible para ventas</div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Información adicional -->
                    <div class="pt-4 border-t border-gray-200">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-500">Límite de alerta</div>
                                <div class="font-medium text-gray-900">{{ $product->low_stock_threshold }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500">Stock inicial</div>
                                <div class="font-medium text-gray-900">{{ $product->initial_stock }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Estadísticas del Producto -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-chart-bar text-purple-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Estadísticas</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-shopping-cart text-blue-600"></i>
                            <span class="text-sm text-gray-600">Vendido</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ $product->sold_quantity }} unidades</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-warehouse text-green-600"></i>
                            <span class="text-sm text-gray-600">Stock inicial</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ $product->initial_stock }} unidades</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-percentage text-purple-600"></i>
                            <span class="text-sm text-gray-600">Tasa de venta</span>
                        </div>
                        <span class="font-semibold text-gray-900">
                            {{ $product->initial_stock > 0 ? round(($product->sold_quantity / $product->initial_stock) * 100, 1) : 0 }}%
                        </span>
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
                    <a href="{{ route('products.edit', $product) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Producto
                    </a>
                    
                    <a href="{{ route('sales.create') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Crear Venta
                    </a>
                    
                    <form method="POST" action="{{ route('products.destroy', $product) }}" 
                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 shadow-sm">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar Producto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aplicar colores a las etiquetas de categoría
    document.querySelectorAll('[data-color]').forEach(function(element) {
        const color = element.getAttribute('data-color');
        if (color) {
            element.style.backgroundColor = color + '20';
            element.style.color = color;
        }
    });
    
    // Aplicar ancho a la barra de progreso con animación
    document.querySelectorAll('[data-width]').forEach(function(element) {
        const width = element.getAttribute('data-width');
        if (width) {
            // Animar la barra de progreso
            setTimeout(() => {
                element.style.width = width + '%';
            }, 100);
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
    
    // Animación de entrada para los números principales
    const numbers = document.querySelectorAll('.text-4xl, .text-2xl');
    numbers.forEach(number => {
        const finalValue = number.textContent;
        if (finalValue.includes('$')) {
            // Para precios, animar el número
            const numericValue = parseFloat(finalValue.replace(/[$,]/g, ''));
            if (!isNaN(numericValue)) {
                animateNumber(number, 0, numericValue, 1000, '$');
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
