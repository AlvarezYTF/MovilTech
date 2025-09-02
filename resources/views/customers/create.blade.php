@extends('layouts.app')

@section('title', 'Nuevo Cliente')
@section('header', 'Nuevo Cliente')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="mr-3 p-2 rounded-lg bg-blue-50 border border-blue-100">
                    <i class="fas fa-user-plus text-blue-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Nuevo Cliente</h3>
                    <p class="text-sm text-gray-500">Registra un nuevo cliente en el sistema</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('customers.store') }}" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información básica -->
                <div class="md:col-span-2">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Información básica</h4>
                </div>
                
                <!-- Nombre -->
                <div class="md:col-span-2">
                    <label for="name" class="form-label">
                        Nombre completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="form-input @error('name') border-red-300 @enderror" 
                           placeholder="Ej: Juan Pérez García"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="form-input @error('email') border-red-300 @enderror" 
                           placeholder="juan.perez@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Teléfono -->
                <div>
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="text" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           class="form-input @error('phone') border-red-300 @enderror" 
                           placeholder="+1 (555) 123-4567">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Dirección -->
                <div class="md:col-span-2">
                    <h4 class="text-md font-medium text-gray-900 mb-4 mt-6">Dirección</h4>
                </div>
                
                <div class="md:col-span-2">
                    <label for="address" class="form-label">Dirección</label>
                    <input type="text" 
                           id="address" 
                           name="address" 
                           value="{{ old('address') }}"
                           class="form-input @error('address') border-red-300 @enderror" 
                           placeholder="Calle, número, colonia">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Ciudad -->
                <div>
                    <label for="city" class="form-label">Ciudad</label>
                    <input type="text" 
                           id="city" 
                           name="city" 
                           value="{{ old('city') }}"
                           class="form-input @error('city') border-red-300 @enderror" 
                           placeholder="Ciudad">
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Estado -->
                <div>
                    <label for="state" class="form-label">Estado</label>
                    <input type="text" 
                           id="state" 
                           name="state" 
                           value="{{ old('state') }}"
                           class="form-input @error('state') border-red-300 @enderror" 
                           placeholder="Estado">
                    @error('state')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Código postal -->
                <div>
                    <label for="zip_code" class="form-label">Código postal</label>
                    <input type="text" 
                           id="zip_code" 
                           name="zip_code" 
                           value="{{ old('zip_code') }}"
                           class="form-input @error('zip_code') border-red-300 @enderror" 
                           placeholder="12345">
                    @error('zip_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Notas -->
                <div class="md:col-span-2">
                    <label for="notes" class="form-label">Notas adicionales</label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="3"
                              class="form-input @error('notes') border-red-300 @enderror" 
                              placeholder="Información adicional sobre el cliente...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Estado -->
                <div class="md:col-span-2">
                    <label class="form-label">Estado del cliente</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
                            <span class="ml-2 text-sm text-gray-700">Cliente activo</span>
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Los clientes inactivos no aparecerán en los formularios de ventas</p>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('customers.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Crear Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
