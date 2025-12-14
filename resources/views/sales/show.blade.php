@extends('layouts.app')

@section('title', 'Venta #' . $sale->invoice_number)
@section('header', 'Detalles de Venta')

@section('content')
<div class="space-y-4 sm:space-y-6" 
     x-data="electronicInvoiceModal({{ $sale->customer_id }}, {{ $sale->id }}, {{ $sale->customer->requires_electronic_invoice ? 'true' : 'false' }})">
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
                
                @if($sale->hasElectronicInvoice())
                    <a href="{{ route('electronic-invoices.show', $sale->electronicInvoice) }}?return_to=sale" 
                       class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-green-600 bg-green-600 text-white text-sm font-semibold hover:bg-green-700 hover:border-green-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm hover:shadow-md">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                        <span>Ver Factura Electrónica</span>
                    </a>
                @else
                    <button type="button"
                            @click="openElectronicInvoiceModal()"
                            class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-blue-600 bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 hover:border-blue-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm hover:shadow-md">
                        <i class="fas fa-file-invoice mr-2"></i>
                        <span>Generar Factura Electrónica</span>
                    </button>
                @endif
                
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

    <!-- Modal para Configurar Facturación Electrónica -->
    <div x-show="modalOpen"
         x-cloak
         @keydown.escape.window="closeModal()"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title"
         role="dialog"
         aria-modal="true"
         style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="modalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                 @click="closeModal()"></div>

            <!-- Center modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="modalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            
            <!-- Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                            <i class="fas fa-file-invoice text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900" id="modal-title">
                                Configurar Facturación Electrónica
                            </h3>
                            <p class="text-sm text-gray-500 mt-0.5">
                                Complete los datos fiscales del cliente para generar facturas electrónicas
                            </p>
                        </div>
                    </div>
                    <button type="button"
                            @click="closeModal()"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="bg-white px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                <form @submit.prevent="saveTaxProfile">
                    <div class="space-y-6">
                        <!-- Toggle para activar facturación electrónica -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-sm font-semibold text-gray-900">Activar Facturación Electrónica</label>
                                    <p class="text-xs text-gray-500 mt-1">Activa esta opción para habilitar la facturación electrónica para este cliente</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox"
                                           x-model="formData.requires_electronic_invoice"
                                           @change="toggleElectronicInvoice"
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>

                        <!-- Campos DIAN -->
                        <div x-show="formData.requires_electronic_invoice"
                             x-transition
                             class="space-y-5 border-t border-gray-200 pt-6">
                            
                            <!-- Mensaje informativo -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                                    <div class="text-sm text-blue-800">
                                        <p class="font-semibold mb-1">Campos Obligatorios para Facturación Electrónica</p>
                                        <p class="text-xs">Complete todos los campos marcados con <span class="text-red-500 font-bold">*</span> para poder generar facturas electrónicas válidas según la normativa DIAN.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tipo de Documento -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                                        Tipo de Documento <span class="text-red-500">*</span>
                                    </label>
                                    <select x-model="formData.identification_document_id"
                                            @change="updateRequiredFields"
                                            class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            :required="formData.requires_electronic_invoice">
                                        <option value="">Seleccione...</option>
                                        <template x-for="doc in catalogs.identification_documents" :key="doc.id">
                                            <option :value="doc.id" 
                                                    :data-code="doc.code"
                                                    :data-requires-dv="doc.requires_dv"
                                                    x-text="doc.name + (doc.code ? ' (' + doc.code + ')' : '')">
                                            </option>
                                        </template>
                                    </select>
                                </div>

                                <!-- Identificación -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                                        Número de Identificación <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           x-model="formData.identification"
                                           @input="calculateDV"
                                           class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           :required="formData.requires_electronic_invoice">
                                </div>
                            </div>

                            <!-- Dígito Verificador -->
                            <div x-show="requiresDV" 
                                 x-transition
                                 class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                                        Dígito Verificador (DV) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           x-model="formData.dv"
                                           maxlength="1"
                                           class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           :required="requiresDV">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Se calcula automáticamente para NIT
                                    </p>
                                </div>
                            </div>

                            <!-- Razón Social / Nombre Comercial -->
                            <div x-show="isJuridicalPerson" 
                                 x-transition
                                 class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                                        Razón Social / Empresa <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           x-model="formData.company"
                                           class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           :required="isJuridicalPerson">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                                        Nombre Comercial
                                    </label>
                                    <input type="text"
                                           x-model="formData.trade_name"
                                           class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <!-- Nombres (solo para personas naturales) -->
                            <div x-show="!isJuridicalPerson" 
                                 x-transition
                                 class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                                        Nombres
                                    </label>
                                    <input type="text"
                                           x-model="formData.names"
                                           class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Nombres completos de la persona natural">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Solo aplica para personas naturales
                                    </p>
                                </div>
                            </div>

                            <!-- Tipo de Organización Legal -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Tipo de Organización Legal
                                </label>
                                <select x-model="formData.legal_organization_id"
                                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Seleccione...</option>
                                    <template x-for="org in catalogs.legal_organizations" :key="org.id">
                                        <option :value="org.id" x-text="org.name"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Municipio -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Municipio <span class="text-red-500">*</span>
                                </label>
                                <select x-model="formData.municipality_id"
                                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        :required="formData.requires_electronic_invoice">
                                    <option value="">Seleccione un municipio...</option>
                                    <template x-for="(municipalities, department) in catalogs.municipalities" :key="department">
                                        <optgroup :label="department">
                                            <template x-for="municipality in municipalities" :key="municipality.factus_id">
                                                <option :value="municipality.factus_id" x-text="municipality.name"></option>
                                            </template>
                                        </optgroup>
                                    </template>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">
                                    Seleccione el municipio según el departamento
                                </p>
                            </div>

                            <!-- Régimen Tributario -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Régimen Tributario
                                </label>
                                <select x-model="formData.tribute_id"
                                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Seleccione...</option>
                                    <template x-for="tribute in catalogs.tributes" :key="tribute.id">
                                        <option :value="tribute.id" x-text="tribute.name + ' (' + tribute.code + ')'"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Información de Contacto Adicional -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                                        Dirección Fiscal
                                    </label>
                                    <input type="text"
                                           x-model="formData.address"
                                           class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Dirección para facturación">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                                        Email Fiscal
                                    </label>
                                    <input type="email"
                                           x-model="formData.email"
                                           class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="email@ejemplo.com">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Email para envío de facturas electrónicas
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Teléfono Fiscal
                                </label>
                                <input type="text"
                                       x-model="formData.phone"
                                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Número de teléfono">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-end space-x-3">
                <button type="button"
                        @click="closeModal()"
                        class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancelar
                </button>
                <button type="button"
                        @click="saveTaxProfile"
                        :disabled="saving"
                        class="px-4 py-2 rounded-lg border border-blue-600 bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!saving">Guardar y Generar Factura</span>
                    <span x-show="saving" x-cloak><i class="fas fa-spinner fa-spin mr-2"></i>Guardando...</span>
                </button>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    window.electronicInvoiceModal = function(customerId, saleId, currentRequiresElectronicInvoice) {
    const requiresElectronicInvoice = currentRequiresElectronicInvoice === 'true' || currentRequiresElectronicInvoice === true;
    
    return {
        modalOpen: false,
        loading: false,
        saving: false,
        customerId: customerId,
        saleId: saleId,
        catalogs: {
            identification_documents: [],
            legal_organizations: [],
            tributes: [],
            municipalities: {},
        },
        formData: {
            requires_electronic_invoice: requiresElectronicInvoice,
            identification_document_id: null,
            identification: '',
            dv: '',
            legal_organization_id: null,
            company: '',
            trade_name: '',
            names: '',
            address: '',
            email: '',
            phone: '',
            tribute_id: null,
            municipality_id: null,
        },
        requiresDV: false,
        isJuridicalPerson: false,

        async openElectronicInvoiceModal() {
            this.modalOpen = true;
            if (!this.loading) {
                await this.loadCustomerData();
            }
        },

        closeModal() {
            this.modalOpen = false;
        },

        async loadCustomerData() {
            if (this.loading) return;
            
            this.loading = true;
            try {
                const response = await fetch(`/api/customers/${this.customerId}/tax-profile`, {
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.message || data.error || 'Error al cargar datos del cliente');
                }
                
                if (data.error) {
                    throw new Error(data.message || 'Error al cargar datos del cliente');
                }
                
                this.catalogs = data.catalogs;
                
                if (data.customer.tax_profile) {
                    this.formData.requires_electronic_invoice = data.customer.requires_electronic_invoice;
                    this.formData.identification_document_id = data.customer.tax_profile.identification_document_id;
                    this.formData.identification = data.customer.tax_profile.identification || '';
                    this.formData.dv = data.customer.tax_profile.dv || '';
                    this.formData.legal_organization_id = data.customer.tax_profile.legal_organization_id;
                    this.formData.company = data.customer.tax_profile.company || '';
                    this.formData.trade_name = data.customer.tax_profile.trade_name || '';
                    this.formData.names = data.customer.tax_profile.names || '';
                    this.formData.address = data.customer.tax_profile.address || '';
                    this.formData.email = data.customer.tax_profile.email || '';
                    this.formData.phone = data.customer.tax_profile.phone || '';
                    this.formData.tribute_id = data.customer.tax_profile.tribute_id;
                    this.formData.municipality_id = data.customer.tax_profile.municipality_id;
                }
                
                this.updateRequiredFields();
            } catch (error) {
                console.error('Error:', error);
                alert('Error al cargar los datos del cliente. Por favor, recarga la página.');
            } finally {
                this.loading = false;
            }
        },

        updateRequiredFields() {
            if (!this.formData.identification_document_id) {
                this.requiresDV = false;
                this.isJuridicalPerson = false;
                return;
            }

            const doc = this.catalogs.identification_documents.find(d => d.id == this.formData.identification_document_id);
            if (doc) {
                this.requiresDV = doc.requires_dv === true || doc.requires_dv === 1;
                this.isJuridicalPerson = doc.code === 'NIT';
                
                if (this.requiresDV && this.isJuridicalPerson && this.formData.identification) {
                    this.calculateDV();
                }
            }
        },

        calculateDV() {
            if (this.requiresDV && this.isJuridicalPerson && this.formData.identification && this.formData.identification.length >= 9) {
                const nit = this.formData.identification.replace(/\D/g, '');
                // Basic DV calculation for NIT (simplified - you might want to implement the full algorithm)
                // For now, we'll leave it empty to be filled manually
            }
        },

        toggleElectronicInvoice() {
            if (!this.formData.requires_electronic_invoice) {
                // Reset form if disabling
                this.formData.identification_document_id = null;
                this.formData.identification = '';
                this.formData.dv = '';
                this.requiresDV = false;
                this.isJuridicalPerson = false;
            }
        },

        async saveTaxProfile() {
            if (this.saving) return;
            
            // Validate required fields if electronic invoice is enabled
            if (this.formData.requires_electronic_invoice) {
                if (!this.formData.identification_document_id || !this.formData.identification || !this.formData.municipality_id) {
                    alert('Por favor, complete todos los campos obligatorios marcados con *.');
                    return;
                }
                
                if (this.requiresDV && !this.formData.dv) {
                    alert('Por favor, complete el dígito verificador (DV).');
                    return;
                }
                
                if (this.isJuridicalPerson && !this.formData.company) {
                    alert('Por favor, complete la razón social / empresa.');
                    return;
                }
            }

            this.saving = true;
            try {
                const response = await fetch(`/api/customers/${this.customerId}/tax-profile`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    },
                    body: JSON.stringify(this.formData),
                });

                if (!response.ok) {
                    const error = await response.json();
                    throw new Error(error.message || 'Error al guardar la configuración fiscal');
                }

                const data = await response.json();
                
                if (data.success) {
                    this.closeModal();
                    // Submit form to generate electronic invoice
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/sales/${this.saleId}/electronic-invoice/generate`;
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                    form.appendChild(csrfInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message || 'Error al guardar la configuración. Por favor, intenta nuevamente.');
            } finally {
                this.saving = false;
            }
        },
    };
    };
})();
</script>
@endpush
