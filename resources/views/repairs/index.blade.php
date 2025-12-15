@extends('layouts.app')

@section('title', 'Reparaciones')
@section('header', 'Gestión de Reparaciones')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2.5 sm:p-3 rounded-xl bg-amber-50 text-amber-600">
                    <i class="fas fa-tools text-lg sm:text-xl"></i>
                    </div>
                    <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Gestión de Reparaciones</h1>
                    <div class="flex items-center space-x-2 mt-1">
                        <span class="text-xs sm:text-sm text-gray-500">
                            <span class="font-semibold text-gray-900">{{ $repairs->total() }}</span> reparaciones registradas
                            </span>
                        <span class="text-gray-300 hidden sm:inline">•</span>
                        <span class="text-xs sm:text-sm text-gray-500 hidden sm:inline">
                                <i class="fas fa-phone-alt mr-1"></i> Servicio técnico
                            </span>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('repairs.create') }}" 
               class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-amber-600 bg-amber-600 text-white text-sm font-semibold hover:bg-amber-700 hover:border-amber-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 shadow-sm hover:shadow-md">
                <i class="fas fa-plus mr-2"></i>
                <span>Nueva Reparación</span>
            </a>
        </div>
    </div>
    
    <!-- Filtros -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <form method="GET" action="{{ route('repairs.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                    <label for="search" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                        Buscar
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-sm"></i>
                        </div>
                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all"
                               placeholder="Modelo, IMEI o cliente...">
                    </div>
            </div>
            
            <div>
                    <label for="repair_status" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                        Estado
                    </label>
                    <div class="relative">
                        <select id="repair_status" name="repair_status"
                                class="block w-full pl-3 sm:pl-4 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent appearance-none bg-white">
                    <option value="">Todos los estados</option>
                    <option value="pending" {{ request('repair_status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="in_progress" {{ request('repair_status') == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                    <option value="completed" {{ request('repair_status') == 'completed' ? 'selected' : '' }}>Completado</option>
                    <option value="delivered" {{ request('repair_status') == 'delivered' ? 'selected' : '' }}>Entregado</option>
                </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
            </div>
            
            <div>
                    <label for="date_from" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                        Fecha Desde
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                        </div>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" 
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                    </div>
            </div>
            
            <div>
                    <label for="date_to" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                        Fecha Hasta
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                        </div>
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" 
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                    </div>
            </div>
            
            <div class="flex items-end">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        <i class="fas fa-filter mr-2"></i>
                    Filtrar
                </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Tabla de reparaciones - Desktop -->
    <div class="hidden lg:block bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Reparación
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Dispositivo
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Costo
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($repairs as $repair)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mr-3 shadow-sm">
                                    <i class="fas fa-tools text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">#{{ $repair->id }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $repair->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-xs font-semibold shadow-sm mr-3 flex-shrink-0">
                                    {{ strtoupper(substr($repair->customer->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-gray-900 truncate">{{ $repair->customer->name }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ $repair->customer->phone ?? 'Sin teléfono' }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                                <div class="flex items-center">
                                <div class="p-1.5 rounded-lg bg-blue-50 text-blue-600 mr-2">
                                    <i class="fas fa-mobile-alt text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $repair->phone_model }}</div>
                                    @if($repair->imei)
                                        <div class="text-xs text-gray-500 font-mono mt-0.5">{{ $repair->imei }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($repair->repair_status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                    <i class="fas fa-clock mr-1.5"></i>
                                    Pendiente
                                </span>
                            @elseif($repair->repair_status === 'in_progress')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                    <i class="fas fa-tools mr-1.5"></i>
                                    En Progreso
                                </span>
                            @elseif($repair->repair_status === 'completed')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                    <i class="fas fa-check-circle mr-1.5"></i>
                                    Completado
                                </span>
                            @elseif($repair->repair_status === 'delivered')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-violet-50 text-violet-700">
                                    <i class="fas fa-handshake mr-1.5"></i>
                                    Entregado
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">
                                ${{ number_format($repair->repair_cost, 2) }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $repair->repair_date->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $repair->created_at->format('H:i') }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('repairs.show', $repair) }}"
                                   class="text-blue-600 hover:text-blue-700 transition-colors"
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('repairs.edit', $repair) }}"
                                   class="text-indigo-600 hover:text-indigo-700 transition-colors"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <button type="button"
                                        onclick="openDeleteModal({{ $repair->id }}, {{ json_encode($repair->customer->name) }}, {{ json_encode($repair->phone_model) }})"
                                        class="text-red-600 hover:text-red-700 transition-colors"
                                        title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-tools text-4xl text-gray-300 mb-4"></i>
                                <p class="text-base font-semibold text-gray-500 mb-1">No se encontraron reparaciones</p>
                                <p class="text-sm text-gray-400">Crea tu primera reparación para comenzar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación Desktop -->
        @if($repairs->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-100">
            {{ $repairs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
    
    <!-- Cards de reparaciones - Mobile/Tablet -->
    <div class="lg:hidden space-y-4">
        @forelse($repairs as $repair)
        <div class="bg-white rounded-xl border border-gray-100 p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3 flex-1 min-w-0">
                    <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-sm flex-shrink-0">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-semibold text-gray-900">#{{ $repair->id }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $repair->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                
                <div class="flex flex-col items-end space-y-1">
                    @if($repair->repair_status === 'pending')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                            <i class="fas fa-clock mr-1"></i>
                            Pendiente
                        </span>
                    @elseif($repair->repair_status === 'in_progress')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                            <i class="fas fa-tools mr-1"></i>
                            En Progreso
                        </span>
                    @elseif($repair->repair_status === 'completed')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                            <i class="fas fa-check-circle mr-1"></i>
                            Completado
                        </span>
                    @elseif($repair->repair_status === 'delivered')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-violet-50 text-violet-700">
                            <i class="fas fa-handshake mr-1"></i>
                            Entregado
                        </span>
                    @endif
                    <div class="text-sm font-bold text-gray-900">
                        ${{ number_format($repair->repair_cost, 2) }}
                    </div>
                </div>
            </div>
            
            <div class="space-y-3 mb-4">
                <!-- Cliente -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cliente</p>
                    <div class="flex items-center space-x-2">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-xs font-semibold shadow-sm flex-shrink-0">
                            {{ strtoupper(substr($repair->customer->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-semibold text-gray-900 truncate">{{ $repair->customer->name }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ $repair->customer->phone ?? 'Sin teléfono' }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Dispositivo -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Dispositivo</p>
                    <div class="flex items-center space-x-2">
                        <div class="p-1.5 rounded-lg bg-blue-50 text-blue-600">
                            <i class="fas fa-mobile-alt text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-900 truncate">{{ $repair->phone_model }}</div>
                            @if($repair->imei)
                                <div class="text-xs text-gray-500 font-mono truncate">{{ $repair->imei }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Fecha -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Fecha de reparación</p>
                    <div class="text-sm text-gray-900">
                        {{ $repair->repair_date->format('d/m/Y') }}
                    </div>
                    <div class="text-xs text-gray-500">{{ $repair->created_at->format('H:i') }}</div>
                </div>
            </div>
            
            <!-- Acciones -->
            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-gray-100">
                <a href="{{ route('repairs.show', $repair) }}"
                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                   title="Ver">
                    <i class="fas fa-eye text-sm"></i>
                </a>
                
                <a href="{{ route('repairs.edit', $repair) }}"
                   class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                   title="Editar">
                    <i class="fas fa-edit text-sm"></i>
                </a>
                
                <button type="button"
                        onclick="openDeleteModal({{ $repair->id }}, {{ json_encode($repair->customer->name) }}, {{ json_encode($repair->phone_model) }})"
                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                        title="Eliminar">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-gray-100 p-12 text-center">
            <i class="fas fa-tools text-4xl text-gray-300 mb-4"></i>
            <p class="text-base font-semibold text-gray-500 mb-1">No se encontraron reparaciones</p>
            <p class="text-sm text-gray-400">Crea tu primera reparación para comenzar</p>
        </div>
        @endforelse
        
        <!-- Paginación Mobile -->
        @if($repairs->hasPages())
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            {{ $repairs->appends(request()->query())->links() }}
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
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900">Eliminar Reparación</h3>
                </div>
                <button type="button" onclick="closeDeleteModal()"
                        class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Contenido del modal -->
            <div class="mb-6">
                <p class="text-sm text-gray-600 mb-4">
                    ¿Estás seguro de que deseas eliminar esta reparación? Esta acción no se puede deshacer.
                </p>
                
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 rounded-lg bg-red-100 text-red-600 flex-shrink-0">
                            <i class="fas fa-tools text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-900 mb-1" id="delete-repair-id"></div>
                            <div class="text-xs text-gray-600 mb-1" id="delete-repair-customer"></div>
                            <div class="text-xs text-gray-600" id="delete-repair-device"></div>
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
                        Eliminar Reparación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openDeleteModal(repairId, customerName, phoneModel) {
    const modal = document.getElementById('delete-modal');
    const form = document.getElementById('delete-form');
    const idElement = document.getElementById('delete-repair-id');
    const customerElement = document.getElementById('delete-repair-customer');
    const deviceElement = document.getElementById('delete-repair-device');
    
    // Establecer la acción del formulario
    form.action = '{{ route("repairs.destroy", ":id") }}'.replace(':id', repairId);
    
    // Establecer los datos de la reparación
    idElement.textContent = 'Reparación #' + repairId;
    customerElement.textContent = 'Cliente: ' + customerName;
    deviceElement.textContent = 'Dispositivo: ' + phoneModel;
    
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
