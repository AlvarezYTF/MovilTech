@extends('layouts.app')

@section('title', 'Ventas')
@section('header', 'Gestión de Ventas')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2.5 sm:p-3 rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="fas fa-shopping-cart text-lg sm:text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Gestión de Ventas</h1>
                    <div class="flex items-center space-x-2 mt-1">
                        <span class="text-xs sm:text-sm text-gray-500">
                            <span class="font-semibold text-gray-900">{{ $sales->total() }}</span> ventas registradas
                        </span>
                        <span class="text-gray-300 hidden sm:inline">•</span>
                        <span class="text-xs sm:text-sm text-gray-500 hidden sm:inline">
                            <i class="fas fa-chart-line mr-1"></i> Panel de ventas
                        </span>
                    </div>
                </div>
            </div>
            
            @can('create_sales')
            <a href="{{ route('sales.create') }}"
               class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-emerald-600 bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 hover:border-emerald-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm hover:shadow-md">
                <i class="fas fa-plus mr-2"></i>
                <span>Nueva Venta</span>
            </a>
            @endcan
        </div>
    </div>
    
    <!-- Filtros -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <form method="GET" action="{{ route('sales.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                        Buscar
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-sm"></i>
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                               placeholder="Número de factura, cliente...">
                    </div>
                </div>
                
                <div>
                    <label for="status" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                        Estado
                    </label>
                    <div class="relative">
                        <select id="status" name="status"
                                class="block w-full pl-3 sm:pl-4 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none bg-white">
                            <option value="">Todos los estados</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completada</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="date_from" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                        Desde
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                        </div>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                    </div>
                </div>
                
                <div class="flex items-end">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-filter mr-2"></i>
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Tabla de ventas - Desktop -->
    <div class="hidden lg:block bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Factura
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Productos
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Vendedor
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mr-3 shadow-sm">
                                    <i class="fas fa-receipt text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $sale->invoice_number }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">ID: {{ $sale->id }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xs font-semibold shadow-sm mr-3 flex-shrink-0">
                                    {{ strtoupper(substr($sale->customer->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-gray-900 truncate">{{ $sale->customer->name }}</div>
                                    @if($sale->customer->email)
                                        <div class="text-xs text-gray-500 truncate">{{ $sale->customer->email }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $sale->sale_date ? $sale->sale_date->format('d/m/Y') : $sale->created_at->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $sale->created_at->format('H:i') }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="p-1.5 rounded-lg bg-blue-50 text-blue-600 mr-2">
                                    <i class="fas fa-box text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $sale->saleItems->count() }} producto{{ $sale->saleItems->count() !== 1 ? 's' : '' }}</div>
                                    <div class="text-xs text-gray-500">Total: {{ $sale->saleItems->sum('quantity') }} unidades</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">
                                ${{ number_format($sale->total, 2) }}
                            </div>
                            @if(isset($sale->discount_amount) && $sale->discount_amount > 0)
                                <div class="text-xs text-emerald-600 font-medium">
                                    -${{ number_format($sale->discount_amount, 2) }} desc.
                                </div>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
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
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-violet-50 text-violet-600 flex items-center justify-center mr-2 shadow-sm">
                                    <i class="fas fa-user-tie text-xs"></i>
                                </div>
                                <div class="text-sm text-gray-900 truncate max-w-xs">{{ $sale->user->name }}</div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('sales.pdf', $sale) }}"
                                   class="text-red-600 hover:text-red-700 transition-colors"
                                   title="Descargar PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                
                                @can('view_sales')
                                <a href="{{ route('sales.show', $sale) }}"
                                   class="text-blue-600 hover:text-blue-700 transition-colors"
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan
                                
                                @can('edit_sales')
                                <a href="{{ route('sales.edit', $sale) }}"
                                   class="text-indigo-600 hover:text-indigo-700 transition-colors"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                
                                @can('delete_sales')
                                <button type="button"
                                        onclick="openDeleteModal({{ $sale->id }}, {{ json_encode($sale->invoice_number) }}, {{ json_encode($sale->customer->name) }}, {{ $sale->total }})"
                                        class="text-red-600 hover:text-red-700 transition-colors"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                                <p class="text-base font-semibold text-gray-500 mb-1">No se encontraron ventas</p>
                                <p class="text-sm text-gray-400">Crea tu primera venta para comenzar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación Desktop -->
        @if($sales->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-100">
            {{ $sales->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
    
    <!-- Cards de ventas - Mobile/Tablet -->
    <div class="lg:hidden space-y-4">
        @forelse($sales as $sale)
        <div class="bg-white rounded-xl border border-gray-100 p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3 flex-1 min-w-0">
                    <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm flex-shrink-0">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $sale->invoice_number }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">ID: {{ $sale->id }}</p>
                    </div>
                </div>
                
                <div class="flex flex-col items-end space-y-1">
                    @if($sale->status === 'completed')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                            <i class="fas fa-check-circle mr-1"></i>
                            Completada
                        </span>
                    @elseif($sale->status === 'pending')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                            <i class="fas fa-clock mr-1"></i>
                            Pendiente
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                            <i class="fas fa-times-circle mr-1"></i>
                            Cancelada
                        </span>
                    @endif
                    <div class="text-sm font-bold text-gray-900">
                        ${{ number_format($sale->total, 2) }}
                    </div>
                </div>
            </div>
            
            <div class="space-y-3 mb-4">
                <!-- Cliente -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cliente</p>
                    <div class="flex items-center space-x-2">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xs font-semibold shadow-sm flex-shrink-0">
                            {{ strtoupper(substr($sale->customer->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-semibold text-gray-900 truncate">{{ $sale->customer->name }}</div>
                            @if($sale->customer->email)
                                <div class="text-xs text-gray-500 truncate">{{ $sale->customer->email }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Información de la venta -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Fecha</p>
                        <div class="text-sm text-gray-900">
                            {{ $sale->sale_date ? $sale->sale_date->format('d/m/Y') : $sale->created_at->format('d/m/Y') }}
                        </div>
                        <div class="text-xs text-gray-500">{{ $sale->created_at->format('H:i') }}</div>
                    </div>
                    
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Productos</p>
                        <div class="flex items-center">
                            <div class="p-1 rounded-lg bg-blue-50 text-blue-600 mr-2">
                                <i class="fas fa-box text-xs"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $sale->saleItems->count() }}</div>
                                <div class="text-xs text-gray-500">{{ $sale->saleItems->sum('quantity') }} unidades</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Vendedor -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Vendedor</p>
                    <div class="flex items-center space-x-2">
                        <div class="h-7 w-7 rounded-full bg-violet-50 text-violet-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-user-tie text-xs"></i>
                        </div>
                        <div class="text-sm text-gray-900 truncate">{{ $sale->user->name }}</div>
                    </div>
                </div>
                
                @if(isset($sale->discount_amount) && $sale->discount_amount > 0)
                <div class="bg-emerald-50 rounded-lg p-2 border border-emerald-100">
                    <div class="text-xs text-emerald-700 font-semibold">
                        <i class="fas fa-tag mr-1"></i>
                        Descuento: -${{ number_format($sale->discount_amount, 2) }}
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Acciones -->
            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-gray-100">
                <a href="{{ route('sales.pdf', $sale) }}"
                   class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                   title="PDF">
                    <i class="fas fa-file-pdf text-sm"></i>
                </a>
                
                @can('view_sales')
                <a href="{{ route('sales.show', $sale) }}"
                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                   title="Ver">
                    <i class="fas fa-eye text-sm"></i>
                </a>
                @endcan
                
                @can('edit_sales')
                <a href="{{ route('sales.edit', $sale) }}"
                   class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                   title="Editar">
                    <i class="fas fa-edit text-sm"></i>
                </a>
                @endcan
                
                @can('delete_sales')
                <button type="button"
                        onclick="openDeleteModal({{ $sale->id }}, {{ json_encode($sale->invoice_number) }}, {{ json_encode($sale->customer->name) }}, {{ $sale->total }})"
                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                        title="Eliminar">
                    <i class="fas fa-trash text-sm"></i>
                </button>
                @endcan
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-gray-100 p-12 text-center">
            <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
            <p class="text-base font-semibold text-gray-500 mb-1">No se encontraron ventas</p>
            <p class="text-sm text-gray-400">Crea tu primera venta para comenzar</p>
        </div>
        @endforelse
        
        <!-- Paginación Mobile -->
        @if($sales->hasPages())
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            {{ $sales->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50" style="display: none;">
    <div class="relative top-10 sm:top-20 mx-auto p-4 sm:p-6 border w-11/12 sm:w-96 shadow-xl rounded-xl bg-white max-h-[90vh] overflow-y-auto">
        <div class="mt-3">
            <!-- Header del modal -->
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="p-2.5 rounded-xl bg-red-50 text-red-600">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900">Eliminar Venta</h3>
                </div>
                <button type="button" onclick="closeDeleteModal()"
                        class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Contenido del modal -->
            <div class="mb-6">
                <p class="text-sm text-gray-600 mb-4">
                    ¿Estás seguro de que deseas eliminar esta venta? Esta acción no se puede deshacer.
                </p>
                
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 rounded-lg bg-red-100 text-red-600 flex-shrink-0">
                            <i class="fas fa-receipt text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-900 mb-1" id="delete-sale-invoice"></div>
                            <div class="text-xs text-gray-600 mb-2" id="delete-sale-customer"></div>
                            <div class="text-xs font-semibold text-gray-700" id="delete-sale-total"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <form id="delete-form" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeDeleteModal()"
                            class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-red-600 bg-red-600 text-white text-sm font-semibold hover:bg-red-700 hover:border-red-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm hover:shadow-md">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar Venta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openDeleteModal(saleId, invoiceNumber, customerName, total) {
    const modal = document.getElementById('delete-modal');
    const form = document.getElementById('delete-form');
    const invoiceElement = document.getElementById('delete-sale-invoice');
    const customerElement = document.getElementById('delete-sale-customer');
    const totalElement = document.getElementById('delete-sale-total');
    
    // Establecer la acción del formulario
    form.action = '{{ route("sales.destroy", ":id") }}'.replace(':id', saleId);
    
    // Establecer los datos de la venta
    invoiceElement.textContent = 'Factura: ' + invoiceNumber;
    customerElement.textContent = 'Cliente: ' + customerName;
    totalElement.textContent = 'Total: $' + parseFloat(total).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    
    // Mostrar el modal
    modal.classList.remove('hidden');
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal al hacer clic fuera
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Cerrar modal con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('delete-modal');
        if (!modal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    }
});
</script>
@endpush
@endsection
