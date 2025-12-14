@extends('layouts.app')

@section('title', 'Venta #' . $sale->invoice_number)
@section('header', 'Detalles de Venta')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-receipt text-lg sm:text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-2">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">Venta #{{ $sale->invoice_number }}</h1>
                        @if($sale->status === 'completed')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                <i class="fas fa-check-circle mr-1.5"></i>
                                Completada
                            </span>
                        @elseif($sale->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                <i class="fas fa-clock mr-1.5"></i>
                                Pendiente
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                <i class="fas fa-times-circle mr-1.5"></i>
                                Cancelada
                            </span>
                        @endif
                    </div>
                    <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs sm:text-sm text-gray-500">
                        <div class="flex items-center space-x-1.5">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $sale->sale_date ? $sale->sale_date->format('d/m/Y') : $sale->created_at->format('d/m/Y') }}</span>
                        </div>
                        <span class="hidden sm:inline text-gray-300">•</span>
                        <div class="flex items-center space-x-1.5">
                            <i class="fas fa-dollar-sign"></i>
                            <span class="font-semibold text-gray-900">${{ number_format($sale->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                @can('edit_sales')
                <a href="{{ route('sales.edit', $sale) }}"
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    <i class="fas fa-edit mr-2"></i>
                    <span>Editar</span>
                </a>
                @endcan
                
                <a href="{{ route('sales.index') }}"
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-emerald-600 bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 hover:border-emerald-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm hover:shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span>Volver</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Contenido Principal -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Información de la Venta -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-3 mb-4 sm:mb-6">
                    <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600">
                        <i class="fas fa-info-circle text-lg"></i>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Información de la Venta</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Número de Factura
                        </label>
                        <div class="flex items-center space-x-2 text-sm text-gray-900">
                            <i class="fas fa-hashtag text-gray-400"></i>
                            <span class="font-mono font-semibold">{{ $sale->invoice_number }}</span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Estado
                        </label>
                        <div>
                            @if($sale->status === 'completed')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                    <i class="fas fa-check-circle mr-1.5"></i>
                                    Completada
                                </span>
                            @elseif($sale->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                    <i class="fas fa-clock mr-1.5"></i>
                                    Pendiente
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                    <i class="fas fa-times-circle mr-1.5"></i>
                                    Cancelada
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Fecha de Venta
                        </label>
                        <div class="flex items-center space-x-2 text-sm text-gray-900">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                            <span>{{ $sale->sale_date ? $sale->sale_date->format('d/m/Y') : $sale->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Vendedor
                        </label>
                        <div class="flex items-center space-x-2 text-sm text-gray-900">
                            <i class="fas fa-user text-gray-400"></i>
                            <span>{{ $sale->user->name }}</span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Fecha de Creación
                        </label>
                        <div class="flex items-center space-x-2 text-sm text-gray-900">
                            <i class="fas fa-calendar-plus text-gray-400"></i>
                            <span>{{ $sale->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    
                    @if($sale->updated_at != $sale->created_at)
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Última Actualización
                        </label>
                        <div class="flex items-center space-x-2 text-sm text-gray-900">
                            <i class="fas fa-calendar-edit text-gray-400"></i>
                            <span>{{ $sale->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Información del Cliente -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-3 mb-4 sm:mb-6">
                    <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600">
                        <i class="fas fa-user text-lg"></i>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Cliente</h2>
                </div>
                
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-base font-semibold shadow-sm flex-shrink-0">
                        {{ strtoupper(substr($sale->customer->name, 0, 1)) }}
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <div class="text-base sm:text-lg font-semibold text-gray-900 truncate">{{ $sale->customer->name }}</div>
                        @if($sale->customer->email)
                        <div class="text-sm text-gray-500 truncate">{{ $sale->customer->email }}</div>
                        @endif
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($sale->customer->phone)
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Teléfono
                        </label>
                        <div class="flex items-center space-x-2 text-sm">
                            <i class="fas fa-phone text-gray-400"></i>
                            <a href="tel:{{ $sale->customer->phone }}" class="text-emerald-600 hover:text-emerald-700 hover:underline">
                                {{ $sale->customer->phone }}
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($sale->customer->address)
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Dirección
                        </label>
                        <div class="flex items-start space-x-2 text-sm text-gray-900">
                            <i class="fas fa-map-marker-alt text-gray-400 mt-0.5"></i>
                            <span>{{ $sale->customer->address }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Productos Vendidos -->
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                                <i class="fas fa-boxes text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-lg sm:text-xl font-bold text-gray-900">Productos Vendidos</h2>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $sale->saleItems->count() }} producto(s)</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabla Desktop -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Precio Unitario
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($sale->saleItems as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 sm:px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-xl bg-gray-100 flex items-center justify-center mr-3 flex-shrink-0">
                                            <i class="fas fa-box text-gray-600 text-sm"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="text-sm font-semibold text-gray-900 truncate">{{ $item->product->name }}</div>
                                            <div class="text-xs text-gray-500 font-mono mt-0.5">{{ $item->product->sku }}</div>
                                            @if($item->product->category)
                                                <div class="text-xs text-gray-400 mt-0.5">{{ $item->product->category->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 text-sm font-semibold">
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                                    <span class="text-sm font-bold text-emerald-600">
                                        ${{ number_format($item->total_price, 2) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Cards Mobile/Tablet -->
                <div class="lg:hidden divide-y divide-gray-100">
                    @foreach($sale->saleItems as $item)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3 flex-1 min-w-0">
                                <div class="h-10 w-10 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-box text-gray-600 text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-semibold text-gray-900 truncate">{{ $item->product->name }}</div>
                                    <div class="text-xs text-gray-500 font-mono mt-0.5">{{ $item->product->sku }}</div>
                                    @if($item->product->category)
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $item->product->category->name }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Cantidad</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-lg bg-gray-100 text-gray-700 text-sm font-semibold">
                                    {{ $item->quantity }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Precio Unit.</p>
                                <p class="text-sm text-gray-900">${{ number_format($item->unit_price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total</p>
                                <p class="text-sm font-bold text-emerald-600">${{ number_format($item->total_price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Notas -->
            @if($sale->notes)
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2 rounded-xl bg-amber-50 text-amber-600">
                        <i class="fas fa-sticky-note text-lg"></i>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Notas</h2>
                </div>
                <div class="flex items-start space-x-2 text-sm text-gray-700 leading-relaxed">
                    <i class="fas fa-quote-left text-gray-300 mt-0.5"></i>
                    <p class="flex-1">{{ $sale->notes }}</p>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Panel Lateral -->
        <div class="space-y-4 sm:space-y-6">
            <!-- Resumen Financiero -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-violet-50 text-violet-600">
                        <i class="fas fa-calculator text-lg"></i>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Resumen Financiero</h2>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Subtotal</span>
                        <span class="text-sm font-semibold text-gray-900">
                            ${{ number_format($sale->subtotal, 2) }}
                        </span>
                    </div>
                    
                    @if($sale->tax_amount > 0)
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Impuestos</span>
                        <span class="text-sm font-semibold text-gray-900">
                            ${{ number_format($sale->tax_amount, 2) }}
                        </span>
                    </div>
                    @endif
                    
                    @if($sale->discount_amount > 0)
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Descuentos</span>
                        <span class="text-sm font-semibold text-emerald-600">
                            -${{ number_format($sale->discount_amount, 2) }}
                        </span>
                    </div>
                    @endif
                    
                    <div class="pt-3 border-t-2 border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-base font-bold text-gray-900">Total</span>
                            <span class="text-2xl sm:text-3xl font-bold text-emerald-600">
                                ${{ number_format($sale->total, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Estadísticas -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                        <i class="fas fa-chart-bar text-lg"></i>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Estadísticas</h2>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-boxes text-gray-400"></i>
                            <span class="text-sm text-gray-600">Productos</span>
                        </div>
                        <span class="text-lg font-bold text-blue-600">
                            {{ $sale->saleItems->count() }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-layer-group text-gray-400"></i>
                            <span class="text-sm text-gray-600">Cantidad Total</span>
                        </div>
                        <span class="text-lg font-bold text-violet-600">
                            {{ $sale->saleItems->sum('quantity') }}
                        </span>
                    </div>
                    
                    @if($sale->saleItems->sum('quantity') > 0)
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-chart-line text-gray-400"></i>
                            <span class="text-sm text-gray-600">Promedio/Unidad</span>
                        </div>
                        <span class="text-lg font-bold text-amber-600">
                            ${{ number_format($sale->total / $sale->saleItems->sum('quantity'), 2) }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-indigo-50 text-indigo-600">
                        <i class="fas fa-bolt text-lg"></i>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Acciones Rápidas</h2>
                </div>
                
                <div class="space-y-3">
                    @if(route('sales.pdf', $sale))
                    <a href="{{ route('sales.pdf', $sale) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl border-2 border-red-600 bg-red-600 text-white text-sm font-semibold hover:bg-red-700 hover:border-red-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm hover:shadow-md">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Descargar PDF
                    </a>
                    @endif
                    
                    @can('edit_sales')
                    <a href="{{ route('sales.edit', $sale) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Venta
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
