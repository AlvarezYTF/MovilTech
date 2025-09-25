@extends('layouts.app')

@section('title', 'Reportes')
@section('header', 'Centro de Reportes')

@section('content')
<div class="space-y-6">
    <!-- Header con acciones -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="space-y-2">
                <div class="flex items-center">
                    <div class="mr-4 p-2 rounded-lg bg-gray-50 border border-gray-100">
                        <i class="fas fa-chart-pie text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">Centro de Reportes</h1>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="text-sm font-medium text-gray-600">
                                <i class="fas fa-info-circle mr-1"></i> Análisis y estadísticas
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-download mr-2 text-gray-500"></i>
                    Exportar
                </button>
            </div>
        </div>
    </div>

    <!-- Reportes disponibles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
        <!-- Reporte de Ventas -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Ventas</span>
            </div>

            <h3 class="text-xl font-semibold text-gray-900 mb-2">Reporte de Ventas</h3>
            <p class="text-gray-600 text-sm mb-4">
                Visualiza todas las ventas realizadas con filtros por fecha, cliente y producto.
                Incluye totales y análisis detallado.
            </p>

            <div class="flex items-center justify-between">
                <div class="text-xs text-gray-500">
                    <i class="fas fa-filter mr-1"></i>
                    Fecha, Cliente, Producto
                </div>
                <a href="{{ route('reports.sales') }}" class="btn btn-primary">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Reporte
                </a>
            </div>
        </div>

        <!-- Reporte de Reparaciones -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tools text-blue-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Reparaciones</span>
            </div>

            <h3 class="text-xl font-semibold text-gray-900 mb-2">Reporte de Reparaciones</h3>
            <p class="text-gray-600 text-sm mb-4">
                Analiza todas las reparaciones de teléfonos con filtros por fecha, estado y cliente.
                Incluye ingresos totales.
            </p>

            <div class="flex items-center justify-between">
                <div class="text-xs text-gray-500">
                    <i class="fas fa-filter mr-1"></i>
                    Fecha, Estado, Cliente
                </div>
                <a href="{{ route('reports.repairs') }}" class="btn btn-primary">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Reporte
                </a>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-pie text-purple-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Resumen</span>
            </div>

            <h3 class="text-xl font-semibold text-gray-900 mb-2">Vista General</h3>
            <p class="text-gray-600 text-sm mb-4">
                Resumen rápido de las métricas más importantes de tu negocio en tiempo real.
            </p>

            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Ventas del Mes:</span>
                    <span class="font-semibold text-green-600">
                        @php
                            $monthlySales = App\Models\Sale::whereMonth('sale_date', date('m'))
                                                           ->whereYear('sale_date', date('Y'))
                                                           ->sum('total');
                        @endphp
                        ${{ number_format($monthlySales, 2) }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Reparaciones Activas:</span>
                    <span class="font-semibold text-blue-600">
                        @php
                            $activeRepairs = App\Models\Repair::whereIn('repair_status', ['pending', 'in_progress'])->count();
                        @endphp
                        {{ $activeRepairs }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="bg-gray-50 rounded-lg p-6 max-w-4xl mx-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Accesos Rápidos</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('sales.index') }}" class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-shopping-cart text-green-600 mr-3"></i>
                <span class="text-gray-700">Gestionar Ventas</span>
            </a>
            <a href="{{ route('repairs.index') }}" class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-tools text-blue-600 mr-3"></i>
                <span class="text-gray-700">Gestionar Reparaciones</span>
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-boxes text-purple-600 mr-3"></i>
                <span class="text-gray-700">Inventario</span>
            </a>
        </div>
    </div>
</div>
@endsection
