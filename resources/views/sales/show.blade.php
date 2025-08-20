@extends('layouts.app')

@section('title', 'Detalles de Venta')
@section('header', 'Detalles de Venta')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header con botones de acción -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Venta #{{ $sale->invoice_number }}</h1>
                <p class="text-gray-600">Detalles completos de la venta</p>
            </div>
            
            <div class="flex space-x-3">
                @can('edit_sales')
                <a href="{{ route('sales.edit', $sale) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                @endcan
                
                <a href="{{ route('sales.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Información principal de la venta -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Información de la Venta</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Número de Factura</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $sale->invoice_number }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Estado</label>
                        <div class="mt-1">
                            @if($sale->status === 'completed')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>Completada
                                </span>
                            @elseif($sale->status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-2"></i>Pendiente
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-2"></i>Cancelada
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Fecha de Venta</label>
                        <p class="text-gray-900">{{ $sale->sale_date ? $sale->sale_date->format('d/m/Y') : $sale->created_at->format('d/m/Y') }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Vendedor</label>
                        <p class="text-gray-900">{{ $sale->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $sale->user->email }}</p>
                    </div>
                </div>
                
                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Cliente</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $sale->customer->name }}</p>
                        <p class="text-gray-600">{{ $sale->customer->email }}</p>
                        <p class="text-sm text-gray-500">{{ $sale->customer->phone }}</p>
                        @if($sale->customer->address)
                            <p class="text-sm text-gray-500">{{ $sale->customer->address }}</p>
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Fecha de Creación</label>
                        <p class="text-gray-900">{{ $sale->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    @if($sale->updated_at != $sale->created_at)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Última Actualización</label>
                        <p class="text-gray-900">{{ $sale->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detalles de productos -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Productos Vendidos</h2>
            
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
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
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

        <!-- Resumen financiero -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Resumen Financiero</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <label class="block text-sm font-medium text-gray-500">Subtotal</label>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($sale->subtotal, 2) }}</p>
                </div>
                
                <div class="text-center">
                    <label class="block text-sm font-medium text-gray-500">Impuestos</label>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($sale->tax_amount, 2) }}</p>
                </div>
                
                <div class="text-center">
                    <label class="block text-sm font-medium text-gray-500">Descuentos</label>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($sale->discount_amount, 2) }}</p>
                </div>
            </div>
            
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="text-center">
                    <label class="block text-sm font-medium text-gray-500">Total Final</label>
                    <p class="text-3xl font-bold text-blue-600">${{ number_format($sale->total, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Notas -->
        @if($sale->notes)
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Notas</h2>
            <p class="text-gray-700">{{ $sale->notes }}</p>
        </div>
        @endif

        <!-- Botones de acción adicionales -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h2>
            
            <div class="flex flex-wrap gap-3">
                @can('delete_sales')
                <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline" 
                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta venta? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-trash mr-2"></i>Eliminar Venta
                    </button>
                </form>
                @endcan
                
                <!-- Aquí se pueden agregar más acciones como generar factura, enviar por email, etc. -->
            </div>
        </div>
    </div>
</div>
@endsection
