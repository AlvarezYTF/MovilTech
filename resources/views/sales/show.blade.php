@extends('layouts.app')

@section('title', 'Venta #' . $sale->invoice_number)
@section('header', 'Detalles de Venta')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header con acciones -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="flex items-center">
                <div class="mr-4 p-3 rounded-lg flex items-center justify-center bg-green-50 border border-green-100">
                    <i class="fas fa-receipt text-2xl text-green-600"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Venta #{{ $sale->invoice_number }}</h1>
                    <div class="flex items-center space-x-3 mt-1">
                        @if($sale->status === 'completed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Completada
                            </span>
                        @elseif($sale->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>
                                Pendiente
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>
                                Cancelada
                            </span>
                        @endif
                        <span class="text-gray-400">•</span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $sale->sale_date ? $sale->sale_date->format('d/m/Y') : $sale->created_at->format('d/m/Y') }}
                        </span>
                        <span class="text-gray-400">•</span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-dollar-sign mr-1"></i>
                            ${{ number_format($sale->total, 2) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-3">
                @can('edit_sales')
                <a href="{{ route('sales.edit', $sale) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                @endcan
                
                <a href="{{ route('sales.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detalles de la venta -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información de la venta</h3>
                
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Número de factura</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sale->invoice_number }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                        <dd class="mt-1">
                            @if($sale->status === 'completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Completada
                                </span>
                            @elseif($sale->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Pendiente
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Cancelada
                                </span>
                            @endif
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha de venta</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $sale->sale_date ? $sale->sale_date->format('d/m/Y') : $sale->created_at->format('d/m/Y') }}
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Vendedor</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sale->user->name }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha de creación</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sale->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    
                    @if($sale->updated_at != $sale->created_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sale->updated_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
            
            <!-- Información del cliente -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Cliente</h3>
                
                <div class="flex items-center mb-4">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-900">{{ $sale->customer->name }}</div>
                        <div class="text-sm text-gray-500">{{ $sale->customer->email }}</div>
                    </div>
                </div>
                
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($sale->customer->phone)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="tel:{{ $sale->customer->phone }}" class="text-blue-600 hover:text-blue-800">
                                {{ $sale->customer->phone }}
                            </a>
                        </dd>
                    </div>
                    @endif
                    
                    @if($sale->customer->address)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sale->customer->address }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Productos vendidos -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Productos vendidos</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Precio Unitario
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sale->saleItems as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-box text-gray-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->product->sku }}</div>
                                            @if($item->product->category)
                                                <div class="text-xs text-gray-400">{{ $item->product->category->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ${{ number_format($item->total_price, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Notas -->
            @if($sale->notes)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Notas</h3>
                <p class="text-gray-700">{{ $sale->notes }}</p>
            </div>
            @endif
        </div>
        
        <!-- Panel lateral -->
        <div class="space-y-6">
            <!-- Resumen financiero -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Resumen financiero</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Subtotal</span>
                        <span class="text-lg font-semibold text-gray-900">
                            ${{ number_format($sale->subtotal, 2) }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Impuestos</span>
                        <span class="text-lg font-semibold text-gray-900">
                            ${{ number_format($sale->tax_amount, 2) }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Descuentos</span>
                        <span class="text-lg font-semibold text-green-600">
                            -${{ number_format($sale->discount_amount, 2) }}
                        </span>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-medium text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-green-600">
                                ${{ number_format($sale->total, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Estadísticas -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Estadísticas</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Productos vendidos</span>
                        <span class="text-lg font-semibold text-blue-600">
                            {{ $sale->saleItems->count() }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Cantidad total</span>
                        <span class="text-lg font-semibold text-purple-600">
                            {{ $sale->saleItems->sum('quantity') }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Promedio por producto</span>
                        <span class="text-lg font-semibold text-orange-600">
                            ${{ number_format($sale->total / $sale->saleItems->sum('quantity'), 2) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Acciones rápidas -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones rápidas</h3>
                
                <div class="space-y-3">
                    @can('edit_sales')
                    <a href="{{ route('sales.edit', $sale) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Editar venta
                    </a>
                    @endcan
                    
                    @can('delete_sales')
                    <form method="POST" action="{{ route('sales.destroy', $sale) }}" 
                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta venta? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar venta
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
