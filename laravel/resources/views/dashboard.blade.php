@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Estadísticas principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-boxes text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Productos</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_products'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Ventas</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_sales'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-tools text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Reparaciones Pendientes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_repairs'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Clientes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_customers'] }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información adicional -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ventas del mes -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Ventas del Mes</h3>
            <div class="text-center">
                <p class="text-3xl font-bold text-green-600">${{ number_format($monthlySales, 2) }}</p>
                <p class="text-sm text-gray-600">Ingresos del mes actual</p>
            </div>
        </div>
        
        <!-- Productos con bajo stock -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Productos con Bajo Stock</h3>
            <div class="text-center">
                <p class="text-3xl font-bold text-red-600">{{ $stats['low_stock_products'] }}</p>
                <p class="text-sm text-gray-600">Productos con menos de 10 unidades</p>
            </div>
        </div>
    </div>
    
    <!-- Gráficos y tablas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Productos más vendidos -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Productos Más Vendidos</h3>
            @if($topProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($topProducts as $product)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ $product->name }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $product->total_sold }} unidades</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No hay datos de ventas disponibles</p>
            @endif
        </div>
        
        <!-- Estado de reparaciones -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Estado de Reparaciones</h3>
            @if($repairStatuses->count() > 0)
                <div class="space-y-3">
                    @foreach($repairStatuses as $status)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $status->status) }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $status->total }}</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No hay reparaciones registradas</p>
            @endif
        </div>
    </div>
    
    <!-- Acciones rápidas -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones Rápidas</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @can('create_products')
            <a href="{{ route('products.create') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-plus text-2xl text-blue-600 mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Nuevo Producto</span>
            </a>
            @endcan
            
            @can('create_sales')
            <a href="{{ route('sales.create') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-shopping-cart text-2xl text-green-600 mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Nueva Venta</span>
            </a>
            @endcan
            
            @can('create_repairs')
            <a href="{{ route('repairs.create') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-tools text-2xl text-yellow-600 mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Nueva Reparación</span>
            </a>
            @endcan
            
            @can('view_reports')
            <a href="{{ route('reports.index') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-chart-bar text-2xl text-purple-600 mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Ver Reportes</span>
            </a>
            @endcan
        </div>
    </div>
</div>
@endsection
