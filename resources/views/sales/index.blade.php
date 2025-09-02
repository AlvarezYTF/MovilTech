@extends('layouts.app')

@section('title', 'Ventas')
@section('header', 'Gestión de Ventas')

@section('content')
<div class="space-y-6">
    <!-- Header con acciones -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="space-y-2">
                <div class="flex items-center">
                    <div class="mr-4 p-2 rounded-lg bg-gray-50 border border-gray-100">
                        <i class="fas fa-shopping-cart text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">Gestión de Ventas</h1>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="text-sm font-medium text-gray-600">
                                <span class="text-gray-800 font-semibold">{{ $sales->total() }}</span> ventas registradas
                            </span>
                            <span class="text-gray-400">•</span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-chart-line mr-1"></i> Panel de ventas
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            @can('create_sales')
            <a href="{{ route('sales.create') }}" 
               class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                <i class="fas fa-plus mr-2 text-gray-500"></i>
                <span>Nueva Venta</span>
            </a>
            @endcan
        </div>
    </div>
    
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('sales.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="form-label">Buscar</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                       class="form-input" placeholder="Número de factura, cliente...">
            </div>
            
            <div>
                <label for="status" class="form-label">Estado</label>
                <select id="status" name="status" class="form-input">
                    <option value="">Todos los estados</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completada</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            
            <div>
                <label for="date_from" class="form-label">Desde</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" 
                       class="form-input">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary w-full">
                    <i class="fas fa-search mr-2"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de ventas -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Factura
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Productos
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vendedor
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-receipt text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $sale->invoice_number }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $sale->id }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $sale->customer->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $sale->customer->email }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $sale->sale_date ? $sale->sale_date->format('d/m/Y') : $sale->created_at->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $sale->created_at->format('H:i') }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class="fas fa-box text-gray-400 mr-1"></i>
                                    {{ $sale->saleItems->count() }} producto{{ $sale->saleItems->count() !== 1 ? 's' : '' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    Cantidad total: {{ $sale->saleItems->sum('quantity') }}
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                ${{ number_format($sale->total, 2) }}
                            </div>
                            @if($sale->discount_amount > 0)
                                <div class="text-xs text-green-600">
                                    -${{ number_format($sale->discount_amount, 2) }} desc.
                                </div>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
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
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-6 w-6 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                                    <i class="fas fa-user-tie text-purple-600 text-xs"></i>
                                </div>
                                <div class="text-sm text-gray-900">{{ $sale->user->name }}</div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                @can('view_sales')
                                <a href="{{ route('sales.show', $sale) }}" class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan
                                
                                @can('edit_sales')
                                <a href="{{ route('sales.edit', $sale) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                
                                @can('delete_sales')
                                <form method="POST" action="{{ route('sales.destroy', $sale) }}" class="inline" 
                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta venta?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center py-8">
                                <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium text-gray-500 mb-2">No se encontraron ventas</p>
                                <p class="text-sm text-gray-400">Crea tu primera venta para comenzar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($sales->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $sales->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
