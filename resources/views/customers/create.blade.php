@extends('layouts.app')

@section('title', 'Nuevo Cliente')
@section('header', 'Nuevo Cliente')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header mejorado con gradiente -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center">
                <div class="mr-4 p-3 rounded-lg bg-blue-100 border border-blue-200">
                    <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Nuevo Cliente</h3>
                    <p class="text-sm text-gray-600 mt-1">Registra un nuevo cliente en el sistema con toda su información</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('customers.store') }}" class="p-6 space-y-8" id="customer-form">
            @csrf
            
            <!-- Sección 1: Información Personal -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Información Personal</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-11">
                    <!-- Nombre -->
                    <div class="md:col-span-2">
                        <label for="name" class="form-label">
                            <i class="fas fa-id-card mr-2 text-gray-400"></i>
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="form-input @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" 
                               placeholder="Ej: Juan Pérez García"
                               required>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Nombre completo del cliente para identificación
                        </p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                            Correo electrónico
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="form-input @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" 
                               placeholder="juan.perez@email.com">
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Email para comunicaciones y facturas
                        </p>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Teléfono -->
                    <div>
                        <label for="phone" class="form-label">
                            <i class="fas fa-phone mr-2 text-gray-400"></i>
                            Teléfono
                        </label>
                        <input type="text" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               class="form-input @error('phone') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" 
                               placeholder="+1 (555) 123-4567">
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Número de contacto principal
                        </p>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección 2: Información de Dirección -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-green-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Información de Dirección</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-11">
                    <!-- Dirección -->
                    <div class="md:col-span-2">
                        <label for="address" class="form-label">
                            <i class="fas fa-home mr-2 text-gray-400"></i>
                            Dirección
                        </label>
                        <input type="text" 
                               id="address" 
                               name="address" 
                               value="{{ old('address') }}"
                               class="form-input @error('address') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200" 
                               placeholder="Calle, número, colonia">
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Dirección completa para envíos y facturación
                        </p>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Ciudad -->
                    <div>
                        <label for="city" class="form-label">
                            <i class="fas fa-city mr-2 text-gray-400"></i>
                            Ciudad
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               value="{{ old('city') }}"
                               class="form-input @error('city') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200" 
                               placeholder="Ciudad">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Estado -->
                    <div>
                        <label for="state" class="form-label">
                            <i class="fas fa-flag mr-2 text-gray-400"></i>
                            Estado
                        </label>
                        <input type="text" 
                               id="state" 
                               name="state" 
                               value="{{ old('state') }}"
                               class="form-input @error('state') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200" 
                               placeholder="Estado">
                        @error('state')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Código postal -->
                    <div>
                        <label for="zip_code" class="form-label">
                            <i class="fas fa-mail-bulk mr-2 text-gray-400"></i>
                            Código postal
                        </label>
                        <input type="text" 
                               id="zip_code" 
                               name="zip_code" 
                               value="{{ old('zip_code') }}"
                               class="form-input @error('zip_code') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200" 
                               placeholder="12345">
                        @error('zip_code')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección 3: Información Adicional -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-sticky-note text-purple-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Información Adicional</h4>
                </div>
                
                <div class="pl-11">
                    <!-- Notas -->
                    <div class="mb-6">
                        <label for="notes" class="form-label">
                            <i class="fas fa-comment-alt mr-2 text-gray-400"></i>
                            Notas adicionales
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="3"
                                  class="form-input @error('notes') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                  placeholder="Información adicional sobre el cliente...">{{ old('notes') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Información relevante sobre preferencias o historial del cliente
                        </p>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Estado -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="form-checkbox h-5 w-5 text-green-600 transition duration-150 ease-in-out border-2 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                            <span class="ml-3 text-sm font-medium text-gray-700">Cliente activo</span>
                        </label>
                        <p class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Los clientes inactivos no aparecerán en los formularios de ventas
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('customers.index') }}" 
                   class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-user-plus mr-2"></i>
                    Crear Cliente
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('customer-form');
    const inputs = form.querySelectorAll('input, textarea');
    
    // Validación en tiempo real
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('border-red-300')) {
                validateField(this);
            }
        });
    });
    
    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        
        // Limpiar clases de error
        field.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
        
        // Validaciones específicas
        if (fieldName === 'name' && value.length < 2) {
            showFieldError(field, 'El nombre debe tener al menos 2 caracteres');
            return false;
        }
        
        if (fieldName === 'email' && value && !isValidEmail(value)) {
            showFieldError(field, 'Ingresa un email válido');
            return false;
        }
        
        if (fieldName === 'phone' && value && !isValidPhone(value)) {
            showFieldError(field, 'Ingresa un teléfono válido');
            return false;
        }
        
        return true;
    }
    
    function showFieldError(field, message) {
        field.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
        
        // Remover mensaje de error anterior
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Agregar nuevo mensaje de error
        const errorDiv = document.createElement('p');
        errorDiv.className = 'mt-1 text-sm text-red-600 flex items-center field-error';
        errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;
        field.parentNode.appendChild(errorDiv);
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function isValidPhone(phone) {
        const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
        return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
    }
    
    // Efectos visuales para los campos
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-blue-200', 'ring-opacity-50');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-blue-200', 'ring-opacity-50');
        });
    });
    
    // Animación de entrada para las secciones
    const sections = document.querySelectorAll('.space-y-6');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            section.style.transition = 'all 0.5s ease-out';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, 200 + (index * 150));
    });
    
    // Validación del formulario antes de enviar
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validar campo requerido
        const nameField = document.getElementById('name');
        if (!nameField.value.trim()) {
            showFieldError(nameField, 'El nombre es obligatorio');
            isValid = false;
        }
        
        // Validar todos los campos
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            
            // Mostrar mensaje de error general
            const existingAlert = document.querySelector('.form-alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            const alertDiv = document.createElement('div');
            alertDiv.className = 'form-alert bg-red-50 border border-red-200 rounded-lg p-4 mb-6';
            alertDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                    <div>
                        <h3 class="text-sm font-medium text-red-800">Por favor corrige los errores</h3>
                        <p class="text-sm text-red-600 mt-1">Revisa los campos marcados en rojo antes de continuar</p>
                    </div>
                </div>
            `;
            
            form.insertBefore(alertDiv, form.firstChild);
            
            // Scroll al primer error
            const firstError = form.querySelector('.border-red-300');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
});
</script>
@endpush
@endsection
