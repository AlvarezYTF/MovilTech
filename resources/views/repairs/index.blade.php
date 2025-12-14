@extends('layouts.app')

@section('title', 'Reparaciones')
@section('header', 'Gestión de Reparaciones')

@section('content')
<div class="space-y-6">
    <!-- Header con acciones -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="space-y-2">
                <div class="flex items-center">
                    <div class="mr-4 p-2 rounded-lg bg-gray-50 border border-gray-100">
                        <i class="fas fa-tools text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">Gestión de Reparaciones</h1>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="text-sm font-medium text-gray-600">
                                <span class="text-gray-800 font-semibold">{{ $repairs->total() }}</span> reparaciones registradas
                            </span>
                            <span class="text-gray-400">•</span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-phone-alt mr-1"></i> Servicio técnico
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('repairs.create') }}" 
               class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                <i class="fas fa-plus mr-2 text-gray-500"></i>
                <span>Nueva Reparación</span>
            </a>
        </div>
    </div>
    
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('repairs.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label for="search" class="form-label">Buscar</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                       class="form-input" placeholder="Modelo, IMEI o cliente...">
            </div>
            
            <div>
                <label for="repair_status" class="form-label">Estado</label>
                <select id="repair_status" name="repair_status" class="form-input">
                    <option value="">Todos los estados</option>
                    <option value="pending" {{ request('repair_status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="in_progress" {{ request('repair_status') == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                    <option value="completed" {{ request('repair_status') == 'completed' ? 'selected' : '' }}>Completado</option>
                    <option value="delivered" {{ request('repair_status') == 'delivered' ? 'selected' : '' }}>Entregado</option>
                </select>
            </div>
            
            <div>
                <label for="date_from" class="form-label">Fecha Desde</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" 
                       class="form-input">
            </div>
            
            <div>
                <label for="date_to" class="form-label">Fecha Hasta</label>
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" 
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
    
    <!-- Tabla de reparaciones -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Reparación
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dispositivo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Costo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($repairs as $repair)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-lg bg-orange-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-tools text-orange-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">#{{ $repair->id }}</div>
                                    <div class="text-xs text-gray-500">{{ $repair->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $repair->customer->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $repair->customer->phone ?? 'Sin teléfono' }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class="fas fa-mobile-alt text-gray-400 mr-1"></i>
                                    {{ $repair->phone_model }}
                                </div>
                                <div class="text-xs text-gray-500 font-mono">{{ $repair->imei }}</div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($repair->repair_status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Pendiente
                                </span>
                            @elseif($repair->repair_status === 'in_progress')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-tools mr-1"></i>
                                    En Progreso
                                </span>
                            @elseif($repair->repair_status === 'completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Completado
                                </span>
                            @elseif($repair->repair_status === 'delivered')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-handshake mr-1"></i>
                                    Entregado
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                ${{ number_format($repair->repair_cost, 2) }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $repair->repair_date->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $repair->created_at->format('H:i') }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('repairs.show', $repair) }}" class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('repairs.edit', $repair) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form method="POST" action="{{ route('repairs.destroy', $repair) }}" class="inline" 
                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reparación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center py-8">
                                <i class="fas fa-tools text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium text-gray-500 mb-2">No se encontraron reparaciones</p>
                                <p class="text-sm text-gray-400">Crea tu primera reparación para comenzar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($repairs->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $repairs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
