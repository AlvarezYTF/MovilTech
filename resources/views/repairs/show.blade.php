@extends('layouts.app')

@section('title', 'Detalle de Reparación')
@section('header', 'Detalle de la Reparación')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header con acciones -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Reparación #{{ $repair->id }}</h1>
            <p class="text-gray-600">{{ $repair->phone_model }} - {{ $repair->customer->name }}</p>
        </div>
        
        <div class="flex space-x-3">
            <a href="{{ route('repairs.edit', $repair) }}" class="btn btn-primary">
                <i class="fas fa-edit mr-2"></i>
                Editar
            </a>
            
            <form method="POST" action="{{ route('repairs.destroy', $repair) }}" class="inline" 
                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reparación?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash mr-2"></i>
                    Eliminar
                </button>
            </form>
            
            <a href="{{ route('repairs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información principal de la reparación -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información del dispositivo -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Dispositivo</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Modelo del Teléfono</label>
                        <p class="text-lg font-medium text-gray-900">{{ $repair->phone_model }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Número IMEI</label>
                        <p class="text-lg font-mono text-gray-900">{{ $repair->imei }}</p>
                    </div>
                </div>
            </div>

            <!-- Descripción del problema -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Descripción del Problema</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700 leading-relaxed">{{ $repair->issue_description }}</p>
                </div>
            </div>

            <!-- Notas adicionales -->
            @if($repair->notes)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notas Adicionales</h3>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-gray-700 leading-relaxed">{{ $repair->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar con información adicional -->
        <div class="space-y-6">
            <!-- Estado y costo -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estado y Costo</h3>
                
                <!-- Estado -->
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-600">Estado de la Reparación</label>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $repair->status_color }}">
                            @if($repair->repair_status == 'pending')
                                <i class="fas fa-clock mr-2"></i>
                            @elseif($repair->repair_status == 'in_progress')
                                <i class="fas fa-tools mr-2"></i>
                            @elseif($repair->repair_status == 'completed')
                                <i class="fas fa-check-circle mr-2"></i>
                            @elseif($repair->repair_status == 'delivered')
                                <i class="fas fa-handshake mr-2"></i>
                            @endif
                            {{ $repair->status_display }}
                        </span>
                    </div>
                </div>

                <!-- Costo -->
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-600">Costo de la Reparación</label>
                    <div class="mt-1">
                        <span class="text-2xl font-bold text-green-600">${{ number_format($repair->repair_cost, 2) }}</span>
                    </div>
                </div>

                <!-- Fecha -->
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-600">Fecha de la Reparación</label>
                    <div class="mt-1">
                        <span class="text-lg font-medium text-gray-900">{{ $repair->repair_date->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Información del cliente -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Cliente</h3>
                
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">{{ $repair->customer->name }}</h4>
                        @if($repair->customer->phone)
                            <p class="text-sm text-gray-600">{{ $repair->customer->phone }}</p>
                        @endif
                    </div>
                </div>

                @if($repair->customer->email)
                <div class="mb-3">
                    <label class="text-sm font-medium text-gray-600">Email</label>
                    <p class="text-sm text-gray-900">{{ $repair->customer->email }}</p>
                </div>
                @endif

                @if($repair->customer->address)
                <div class="mb-3">
                    <label class="text-sm font-medium text-gray-600">Dirección</label>
                    <p class="text-sm text-gray-900">{{ $repair->customer->address }}</p>
                </div>
                @endif
            </div>

            <!-- Información del sistema -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Sistema</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID de la Reparación:</span>
                        <span class="font-medium text-gray-900">#{{ $repair->id }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Creado:</span>
                        <span class="font-medium text-gray-900">{{ $repair->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Última actualización:</span>
                        <span class="font-medium text-gray-900">{{ $repair->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
