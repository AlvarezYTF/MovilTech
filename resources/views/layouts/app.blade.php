<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MovilTech') - Sistema de Gestión</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 min-h-screen flex-shrink-0">
            <div class="p-4">
                <h1 class="text-2xl font-bold text-center">MovilTech</h1>
                <p class="text-gray-400 text-sm text-center">Sistema de Gestión</p>
            </div>
            
            <nav class="mt-8">
                <div class="px-4 mb-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menú Principal</p>
                </div>
                
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                
                @can('view_products')
                <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('products.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-boxes w-5"></i>
                    <span class="ml-3">Inventario</span>
                </a>
                @endcan
                
                @can('view_categories')
                <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('categories.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-tags w-5"></i>
                    <span class="ml-3">Categorías</span>
                </a>
                @endcan
                
                <a href="{{ route('customers.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('customers.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="ml-3">Clientes</span>
                </a>
                
                @can('view_sales')
                <a href="{{ route('sales.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('sales.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-shopping-cart w-5"></i>
                    <span class="ml-3">Ventas</span>
                </a>
                @endcan
                
                @can('view_repairs')
                <a href="{{ route('repairs.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('repairs.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-tools w-5"></i>
                    <span class="ml-3">Reparaciones</span>
                </a>
                @endcan
                
                @can('view_reports')
                <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('reports.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span class="ml-3">Reportes</span>
                </a>
                @endcan
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            Bienvenido, {{ Auth::user()->name }}
                        </div>
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                    {{ Auth::user()->email }}
                                </div>
                                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                    Rol: {{ Auth::user()->roles->first()->name ?? 'Sin rol' }}
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
