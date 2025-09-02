@extends('layouts.app')

@section('title', $customer->name)
@section('header', 'Detalles del Cliente')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header mejorado con gradiente -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-gray-200 rounded-xl shadow-sm p-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
            <div class="flex items-start space-x-4">
                <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100">
                    <i class="fas fa-user text-3xl text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $customer->name }}</h1>
                        @if($customer->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Activo
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-pause-circle mr-1"></i>
                                Inactivo
                            </span>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-hashtag text-gray-400"></i>
                            <span class="text-gray-600">ID:</span>
                            <span class="font-medium text-gray-900">#{{ $customer->id }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shopping-cart text-gray-400"></i>
                            <span class="text-gray-600">Ventas:</span>
                            <span class="font-medium text-gray-900">{{ $customer->sales_count ?? 0 }} ventas</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-tools text-gray-400"></i>
                            <span class="text-gray-600">Reparaciones:</span>
                            <span class="font-medium text-gray-900">{{ $customer->repairs_count ?? 0 }} reparaciones</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('customers.edit', $customer) }}" 
                   class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Cliente
                </a>
                
                <a href="{{ route('customers.index') }}" 
                   class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a Clientes
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información básica -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-info text-blue-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Información Personal</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-hashtag text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">ID del Cliente</div>
                                <div class="text-lg font-semibold text-gray-900">#{{ $customer->id }}</div>
                            </div>
                        </div>
                        
                        @if($customer->email)
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-envelope text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Correo Electrónico</div>
                                <div class="text-sm text-gray-900">
                                    <a href="mailto:{{ $customer->email }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        {{ $customer->email }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($customer->phone)
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-phone text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Teléfono</div>
                                <div class="text-sm text-gray-900">
                                    <a href="tel:{{ $customer->phone }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        {{ $customer->phone }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-calendar-plus text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Fecha de Registro</div>
                                <div class="text-sm text-gray-900">{{ $customer->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-calendar-edit text-gray-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Última Actualización</div>
                                <div class="text-sm text-gray-900">{{ $customer->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($customer->address || $customer->city || $customer->state || $customer->zip_code)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-start space-x-3">
                        <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-gray-600"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-2">Dirección</div>
                            <div class="text-sm text-gray-900">
                                @if($customer->address)
                                    <div>{{ $customer->address }}</div>
                                @endif
                                @if($customer->city || $customer->state || $customer->zip_code)
                                    <div class="text-gray-600">
                                        {{ $customer->city }}{{ $customer->city && $customer->state ? ', ' : '' }}{{ $customer->state }}{{ ($customer->city || $customer->state) && $customer->zip_code ? ' ' : '' }}{{ $customer->zip_code }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($customer->notes)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-start space-x-3">
                        <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-sticky-note text-gray-600"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-2">Notas Adicionales</div>
                            <div class="text-sm text-gray-900 leading-relaxed">{{ $customer->notes }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Historial de ventas -->
            @if($customer->sales->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-green-600 text-sm"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Historial de Ventas</h3>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            {{ $customer->sales->count() }} ventas
                        </span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID Venta
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($customer->sales as $sale)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $sale->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                    #{{ $sale->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                    ${{ number_format($sale->total, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Completada
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('sales.show', $sale) }}" 
                                       class="text-blue-600 hover:text-blue-900 mr-3" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sales.pdf', $sale) }}" 
                                       class="text-red-600 hover:text-red-900" title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            <!-- Historial de reparaciones -->
            @if($customer->repairs->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-8 rounded-full bg-orange-100 flex items-center justify-center">
                                <i class="fas fa-tools text-orange-600 text-sm"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Historial de Reparaciones</h3>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                            {{ $customer->repairs->count() }} reparaciones
                        </span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID Reparación
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dispositivo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Costo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($customer->repairs as $repair)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $repair->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                    #{{ $repair->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $repair->device_type }}</div>
                                    <div class="text-xs text-gray-500">{{ $repair->device_model }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-orange-600">
                                    ${{ number_format($repair->cost, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($repair->status == 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Completada
                                        </span>
                                    @elseif($repair->status == 'in_progress')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            En Progreso
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-hourglass-half mr-1"></i>
                                            Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('repairs.show', $repair) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Panel lateral -->
        <div class="space-y-6">
            <!-- Estadísticas mejoradas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-chart-bar text-purple-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Estadísticas</h3>
                </div>
                
                <div class="space-y-6">
                    <!-- Total de ventas -->
                    <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-shopping-cart text-green-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-green-600">{{ $customer->sales_count ?? 0 }}</div>
                        <div class="text-sm font-medium text-gray-500">Total de Ventas</div>
                    </div>
                    
                    <!-- Total gastado -->
                    <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-dollar-sign text-blue-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-blue-600">
                            ${{ number_format($customer->total_spent, 0) }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">Total Gastado</div>
                    </div>
                    
                    <!-- Reparaciones -->
                    <div class="text-center p-4 bg-orange-50 rounded-lg border border-orange-200">
                        <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-tools text-orange-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-orange-600">
                            {{ $customer->repairs_count ?? 0 }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">Reparaciones</div>
                    </div>
                    
                    <!-- Cliente desde -->
                    <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                        <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-calendar text-purple-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-purple-600">
                            {{ $customer->created_at->format('M Y') }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">Cliente Desde</div>
                    </div>
                </div>
            </div>
            
            <!-- Estado del cliente -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-info-circle text-green-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Estado del Cliente</h3>
                </div>
                
                <div class="space-y-4">
                    @if($customer->is_active)
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-green-800">Cliente Activo</div>
                                    <div class="text-xs text-green-600">Aparece en formularios de ventas</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-pause-circle text-gray-500 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-gray-800">Cliente Inactivo</div>
                                    <div class="text-xs text-gray-600">No aparece en formularios de ventas</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Acciones rápidas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-bolt text-indigo-600 text-sm"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Acciones Rápidas</h3>
                </div>
                
                <div class="space-y-3">
                    <a href="{{ route('customers.edit', $customer) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Cliente
                    </a>
                    
                    <a href="{{ route('sales.create', ['customer_id' => $customer->id]) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Nueva Venta
                    </a>
                    
                    <a href="{{ route('repairs.create', ['customer_id' => $customer->id]) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-tools mr-2"></i>
                        Nueva Reparación
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Agregar efectos hover a las tarjetas
    const cards = document.querySelectorAll('.bg-white.rounded-xl');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease-in-out';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Animación de entrada para las estadísticas
    const statsCards = document.querySelectorAll('.text-center.p-4');
    statsCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 200 + (index * 100));
    });
    
    // Animación de entrada para la tabla de ventas
    const salesRows = document.querySelectorAll('tbody tr');
    salesRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease-out';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, 300 + (index * 50));
    });
    
    // Efectos de hover mejorados para las filas de la tabla
    salesRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f9fafb';
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'all 0.2s ease-in-out';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = 'scale(1)';
        });
    });
    
    // Animación de números para las estadísticas
    const statNumbers = document.querySelectorAll('.text-2xl.font-bold');
    statNumbers.forEach(number => {
        const finalValue = number.textContent;
        if (finalValue.includes('$')) {
            // Para valores monetarios
            const numericValue = parseFloat(finalValue.replace(/[$,]/g, ''));
            if (!isNaN(numericValue)) {
                animateNumber(number, 0, numericValue, 1500, '$');
            }
        } else if (!isNaN(parseInt(finalValue))) {
            // Para números enteros
            const numericValue = parseInt(finalValue);
            animateNumber(number, 0, numericValue, 1000);
        }
    });
    
    // Animación de entrada para las secciones principales
    const sections = document.querySelectorAll('.space-y-6 > div');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            section.style.transition = 'all 0.5s ease-out';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, 100 + (index * 150));
    });
});

function animateNumber(element, start, end, duration, prefix = '') {
    const startTime = performance.now();
    
    function updateNumber(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        const current = Math.floor(start + (end - start) * progress);
        element.textContent = prefix + current.toLocaleString();
        
        if (progress < 1) {
            requestAnimationFrame(updateNumber);
        }
    }
    
    requestAnimationFrame(updateNumber);
}
</script>
@endpush
@endsection
