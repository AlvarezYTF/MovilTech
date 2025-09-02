@extends('layouts.app')

@section('title', 'Detalle de Reparación')
@section('header', 'Detalle de Reparación')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header con acciones -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="flex items-center">
                <div class="mr-4 p-3 rounded-lg flex items-center justify-center bg-orange-50 border border-orange-100">
                    <i class="fas fa-tools text-2xl text-orange-600"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Reparación #{{ $repair->id }}</h1>
                    <div class="flex items-center space-x-3 mt-1">
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
                        <span class="text-gray-400">•</span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-mobile-alt mr-1"></i>
                            {{ $repair->phone_model }}
                        </span>
                        <span class="text-gray-400">•</span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-dollar-sign mr-1"></i>
                            ${{ number_format($repair->repair_cost, 2) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('repairs.edit', $repair) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                
                <a href="{{ route('repairs.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información principal de la reparación -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detalles de la reparación -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información de la reparación</h3>
                
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">ID de la reparación</dt>
                        <dd class="mt-1 text-sm text-gray-900">#{{ $repair->id }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                        <dd class="mt-1">
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
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha de reparación</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $repair->repair_date->format('d/m/Y') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha de creación</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $repair->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    
                    @if($repair->updated_at != $repair->created_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $repair->updated_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Información del dispositivo -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información del dispositivo</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Modelo del teléfono</dt>
                        <dd class="mt-1 text-lg font-medium text-gray-900">{{ $repair->phone_model }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Número IMEI</dt>
                        <dd class="mt-1 text-lg font-mono text-gray-900">{{ $repair->imei }}</dd>
                    </div>
                </div>
            </div>

            <!-- Descripción del problema -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Descripción del problema</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700 leading-relaxed">{{ $repair->issue_description }}</p>
                </div>
            </div>

            <!-- Notas adicionales -->
            @if($repair->notes)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Notas adicionales</h3>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-gray-700 leading-relaxed">{{ $repair->notes }}</p>
                </div>
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
                        <span class="text-sm text-gray-500">Costo de reparación</span>
                        <span class="text-2xl font-bold text-orange-600">
                            ${{ number_format($repair->repair_cost, 2) }}
                        </span>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-medium text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-orange-600">
                                ${{ number_format($repair->repair_cost, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Información del cliente -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Cliente</h3>
                
                <div class="flex items-center mb-4">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-900">{{ $repair->customer->name }}</div>
                        @if($repair->customer->phone)
                            <div class="text-sm text-gray-500">{{ $repair->customer->phone }}</div>
                        @endif
                    </div>
                </div>
                
                <dl class="grid grid-cols-1 gap-4">
                    @if($repair->customer->email)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="mailto:{{ $repair->customer->email }}" class="text-blue-600 hover:text-blue-800">
                                {{ $repair->customer->email }}
                            </a>
                        </dd>
                    </div>
                    @endif
                    
                    @if($repair->customer->address)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $repair->customer->address }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
            
            <!-- Acciones rápidas -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones rápidas</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('repairs.edit', $repair) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Editar reparación
                    </a>
                    
                    <form method="POST" action="{{ route('repairs.destroy', $repair) }}" 
                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reparación? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar reparación
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
