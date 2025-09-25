@extends('layouts.app')

@section('title', 'Reporte de Reparaciones')
@section('header', 'Reporte de Reparaciones')

@section('content')
<div class="space-y-6">
    <!-- Header con acciones -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reporte de Reparaciones</h1>
            <p class="text-gray-600">Análisis detallado de las reparaciones realizadas</p>
        </div>
        
        <div class="flex space-x-3">
            <form method="POST" action="{{ route('reports.pdf') }}" class="inline">
                @csrf
                <input type="hidden" name="report_type" value="repairs">
                <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                <input type="hidden" name="repair_status" value="{{ request('repair_status') }}">
                <input type="hidden" name="customer_id" value="{{ request('customer_id') }}">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Exportar PDF
                </button>
            </form>
            
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
        </div>
    </div>
    
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('reports.repairs') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                <label for="customer_id" class="form-label">Cliente</label>
                <select id="customer_id" name="customer_id" class="form-input">
                    <option value="">Todos los clientes</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="md:col-span-4 flex justify-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search mr-2"></i>
                    Filtrar Resultados
                </button>
            </div>
        </form>
    </div>
    
    <!-- Resumen -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Ingresos Totales</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-tools text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Reparaciones</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalCount }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Precio Promedio</p>
                    <p class="text-2xl font-bold text-purple-600">
                        ${{ $totalCount > 0 ? number_format($totalRevenue / $totalCount, 2) : '0.00' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tabla de reparaciones -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Teléfono
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Costo
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
                            <div class="text-sm font-medium text-gray-900">#{{ $repair->id }}</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $repair->customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $repair->customer->phone ?? 'Sin teléfono' }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $repair->phone_model }}</div>
                            <div class="text-sm text-gray-500 font-mono">{{ $repair->imei }}</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $repair->repair_date->format('d/m/Y') }}</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $repair->status_color }}">
                                {{ $repair->status_display }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${{ number_format($repair->repair_cost, 2) }}</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('repairs.show', $repair) }}" class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No se encontraron reparaciones con los filtros aplicados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
