@extends('layouts.app')

@section('title', 'Editar Cliente')
@section('header', 'Editar Cliente')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="mr-3 p-2 rounded-lg bg-indigo-50 border border-indigo-100">
                    <i class="fas fa-user-edit text-indigo-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Editar Cliente</h3>
                    <p class="text-sm text-gray-500">Modifica la información del cliente</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('customers.update', $customer) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
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
                           value="{{ old('name', $customer->name) }}"
                           class="form-input @error('name') border-red-300 @enderror" 
                           placeholder="Nombre completo del cliente"
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
                           value="{{ old('email', $customer->email) }}"
                           class="form-input @error('email') border-red-300 @enderror" 
                           placeholder="correo@ejemplo.com">
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
                           value="{{ old('phone', $customer->phone) }}"
                           class="form-input @error('phone') border-red-300 @enderror" 
                           placeholder="Número de teléfono">
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
                           value="{{ old('address', $customer->address) }}"
                           class="form-input @error('address') border-red-300 @enderror" 
                           placeholder="Dirección completa">
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
                           value="{{ old('city', $customer->city) }}"
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
                           value="{{ old('state', $customer->state) }}"
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
                           value="{{ old('zip_code', $customer->zip_code) }}"
                           class="form-input @error('zip_code') border-red-300 @enderror" 
                           placeholder="Código postal">
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
                              placeholder="Información adicional sobre el cliente...">{{ old('notes', $customer->notes) }}</textarea>
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
                                   {{ old('is_active', $customer->is_active) ? 'checked' : '' }}
                                   class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
                            <span class="ml-2 text-sm text-gray-700">Cliente activo</span>
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Los clientes inactivos no aparecerán en los formularios de ventas</p>
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Información adicional</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">ID:</span> {{ $customer->id }}
                    </div>
                    <div>
                        <span class="font-medium">Ventas:</span> {{ $customer->sales_count ?? 0 }}
                    </div>
                    <div>
                        <span class="font-medium">Reparaciones:</span> {{ $customer->repairs_count ?? 0 }}
                    </div>
                    <div>
                        <span class="font-medium">Creado:</span> {{ $customer->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div>
                        <span class="font-medium">Última actualización:</span> {{ $customer->updated_at->format('d/m/Y H:i') }}
                    </div>
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
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
