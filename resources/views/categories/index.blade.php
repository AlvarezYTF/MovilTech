@extends('layouts.app')

@section('title', 'Categorías')
@section('header', 'Gestión de Categorías')

@section('content')
<div class="space-y-6">
    <!-- Header con acciones -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="space-y-2">
                <div class="flex items-center">
                    <div class="mr-4 p-2 rounded-lg bg-gray-50 border border-gray-100">
                        <i class="fas fa-tags text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">Gestión de Categorías</h1>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="text-sm font-medium text-gray-600">
                                <span class="text-gray-800 font-semibold">{{ $categories->total() }}</span> categorías registradas
                            </span>
                            <span class="text-gray-400">•</span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-chart-line mr-1"></i> Panel de administración
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('categories.create') }}" 
               class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                <i class="fas fa-plus mr-2 text-gray-500"></i>
                <span>Nueva Categoría</span>
            </a>
        </div>
    </div>
    
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('categories.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="form-label">Buscar</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                       class="form-input" placeholder="Nombre o descripción...">
            </div>
            
            <div>
                <label for="status" class="form-label">Estado</label>
                <select id="status" name="status" class="form-input">
                    <option value="">Todos los estados</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary w-full">
                    <i class="fas fa-search mr-2"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>
    
    <!-- Tabla de categorías -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Categoría
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descripción
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Color
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Productos
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
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-lg flex items-center justify-center mr-3" 
                                     style="background-color: {{ $category->color }}20;">
                                    <i class="fas fa-tag" style="color: {{ $category->color }};"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $category->id }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $category->description ? Str::limit($category->description, 50) : 'Sin descripción' }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-6 w-6 rounded-full mr-2 border border-gray-300" 
                                     style="background-color: {{ $category->color }};"></div>
                                <span class="text-sm text-gray-600">{{ $category->color }}</span>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $category->products_count ?? $category->products->count() }}</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($category->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Inactivo
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('categories.show', $category) }}" class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline" 
                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta categoría?')">
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
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center py-8">
                                <i class="fas fa-tags text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium text-gray-500 mb-2">No se encontraron categorías</p>
                                <p class="text-sm text-gray-400">Crea tu primera categoría para comenzar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($categories->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
