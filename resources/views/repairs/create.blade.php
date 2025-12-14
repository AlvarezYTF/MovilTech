@extends('layouts.app')

@section('title', 'Nueva Reparación')
@section('header', 'Nueva Reparación')

@section('content')
<div class="max-w-4xl mx-auto space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2.5 sm:p-3 rounded-xl bg-amber-50 text-amber-600">
                <i class="fas fa-tools text-lg sm:text-xl"></i>
                </div>
                <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Nueva Reparación</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Registra una nueva reparación en el sistema</p>
                </div>
            </div>
        </div>
        
    <form method="POST" action="{{ route('repairs.store') }}" id="repair-form" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            
                <!-- Información básica -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <i class="fas fa-info text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información básica</h2>
                </div>
                
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                <!-- Cliente -->
                <div>
                    <label for="customer_id" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Cliente <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400 text-sm"></i>
                            </div>
                        <select id="customer_id" name="customer_id" 
                                    class="block w-full pl-10 sm:pl-11 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent appearance-none bg-white transition-all @error('customer_id') border-red-300 focus:ring-red-500 @enderror"
                                    required>
                            <option value="">Seleccionar cliente</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}@if($customer->phone) - {{ $customer->phone }}@endif
                                </option>
                            @endforeach
                        </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        <button type="button" id="add-customer-btn" 
                                class="inline-flex items-center justify-center px-3 sm:px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                                title="Agregar nuevo cliente">
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </div>
                    @error('customer_id')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Estado de la reparación -->
                <div>
                    <label for="repair_status" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Estado de la Reparación <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-info-circle text-gray-400 text-sm"></i>
                        </div>
                    <select id="repair_status" name="repair_status" 
                                class="block w-full pl-10 sm:pl-11 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent appearance-none bg-white transition-all @error('repair_status') border-red-300 focus:ring-red-500 @enderror"
                                required>
                        <option value="pending" {{ old('repair_status', 'pending') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_progress" {{ old('repair_status') == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completed" {{ old('repair_status') == 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="delivered" {{ old('repair_status') == 'delivered' ? 'selected' : '' }}>Entregado</option>
                    </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                    @error('repair_status')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
                </div>

                <!-- Información del dispositivo -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-violet-50 text-violet-600">
                    <i class="fas fa-mobile-alt text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información del dispositivo</h2>
                </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                <!-- Modelo del teléfono -->
                <div>
                    <label for="phone_model" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Modelo del Teléfono <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-mobile-alt text-gray-400 text-sm"></i>
                        </div>
                    <input type="text" id="phone_model" name="phone_model" value="{{ old('phone_model') }}" 
                               class="block w-full pl-10 sm:pl-11 pr-3 sm:pr-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all @error('phone_model') border-red-300 focus:ring-red-500 @enderror"
                               placeholder="Ej: iPhone 12, Samsung Galaxy S21"
                               required>
                    </div>
                    @error('phone_model')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- IMEI -->
                <div>
                    <label for="imei" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        IMEI <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-fingerprint text-gray-400 text-sm"></i>
                        </div>
                    <input type="text" id="imei" name="imei" value="{{ old('imei') }}" 
                               class="block w-full pl-10 sm:pl-11 pr-3 sm:pr-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all font-mono @error('imei') border-red-300 focus:ring-red-500 @enderror"
                               placeholder="Número IMEI del dispositivo"
                               required>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500">
                        Número único de identificación del dispositivo
                    </p>
                    @error('imei')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
                </div>

                <!-- Información financiera -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="fas fa-dollar-sign text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información financiera</h2>
                </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                <!-- Costo de la reparación -->
                <div>
                    <label for="repair_cost" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Costo de la Reparación <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-sm">$</span>
                        </div>
                        <input type="number" id="repair_cost" name="repair_cost" value="{{ old('repair_cost') }}" 
                               class="block w-full pl-10 sm:pl-11 pr-3 sm:pr-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all @error('repair_cost') border-red-300 focus:ring-red-500 @enderror"
                               step="0.01" min="0" placeholder="0.00"
                               required>
                    </div>
                    @error('repair_cost')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Fecha de la reparación -->
                <div>
                    <label for="repair_date" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Fecha de la Reparación <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                        </div>
                    <input type="date" id="repair_date" name="repair_date" value="{{ old('repair_date', date('Y-m-d')) }}" 
                               class="block w-full pl-10 sm:pl-11 pr-3 sm:pr-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all @error('repair_date') border-red-300 focus:ring-red-500 @enderror"
                               required>
                    </div>
                    @error('repair_date')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Descripción y notas -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-gray-50 text-gray-600">
                    <i class="fas fa-sticky-note text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información adicional</h2>
                </div>

            <div class="space-y-5 sm:space-y-6">
                <!-- Descripción del problema -->
                <div>
                    <label for="issue_description" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Descripción del Problema <span class="text-red-500">*</span>
                    </label>
                    <textarea id="issue_description" name="issue_description" rows="4" 
                              class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all resize-none @error('issue_description') border-red-300 focus:ring-red-500 @enderror"
                              placeholder="Describe detalladamente el problema del dispositivo"
                              required>{{ old('issue_description') }}</textarea>
                    <p class="mt-1.5 text-xs text-gray-500">
                        Proporciona una descripción detallada del problema o falla del dispositivo
                    </p>
                    @error('issue_description')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Notas adicionales -->
                <div>
                    <label for="notes" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Notas adicionales
                    </label>
                    <textarea id="notes" name="notes" rows="3" 
                              class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all resize-none @error('notes') border-red-300 focus:ring-red-500 @enderror"
                              placeholder="Notas adicionales, observaciones o comentarios">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>
            
        <!-- Botones de Acción -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-4 border-t border-gray-100">
            <div class="text-xs sm:text-sm text-gray-500 flex items-center">
                <i class="fas fa-info-circle mr-1.5"></i>
                Los campos marcados con <span class="text-red-500 ml-1">*</span> son obligatorios
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="{{ route('repairs.index') }}" 
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-amber-600 bg-amber-600 text-white text-sm font-semibold hover:bg-amber-700 hover:border-amber-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 shadow-sm hover:shadow-md"
                        :disabled="loading">
                    <template x-if="!loading">
                    <i class="fas fa-save mr-2"></i>
                    </template>
                    <template x-if="loading">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                    </template>
                    <span x-text="loading ? 'Procesando...' : 'Crear Reparación'">Crear Reparación</span>
                </button>
            </div>
            </div>
        </form>
</div>

<!-- Modal para agregar nuevo cliente -->
<div id="customer-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50" style="display: none;">
    <div class="relative top-10 sm:top-20 mx-auto p-4 sm:p-6 border w-11/12 sm:w-2/3 lg:w-1/2 shadow-xl rounded-xl bg-white max-h-[90vh] overflow-y-auto">
        <div class="mt-3">
            <!-- Header del modal -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-4">
                <div class="flex items-center space-x-3">
                    <div class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                        <i class="fas fa-user-plus text-sm"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900">Nuevo Cliente</h3>
                </div>
                <button type="button" id="close-customer-modal" 
                        class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Formulario del cliente -->
            <form id="customer-form" class="space-y-4 sm:space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <!-- Nombre -->
                    <div class="sm:col-span-2">
                        <label for="modal_customer_name" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="modal_customer_name" name="name" required
                               class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                               placeholder="Ej: Juan Pérez García">
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="modal_customer_email" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Correo electrónico</label>
                        <input type="email" id="modal_customer_email" name="email"
                               class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                               placeholder="juan.perez@email.com">
                    </div>
                    
                    <!-- Teléfono -->
                    <div>
                        <label for="modal_customer_phone" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                        <input type="text" id="modal_customer_phone" name="phone"
                               class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                               placeholder="+1 (555) 123-4567">
                    </div>
                    
                    <!-- Dirección -->
                    <div class="sm:col-span-2">
                        <label for="modal_customer_address" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Dirección</label>
                        <input type="text" id="modal_customer_address" name="address"
                               class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                               placeholder="Calle, número, colonia">
                    </div>
                    
                    <!-- Ciudad -->
                    <div>
                        <label for="modal_customer_city" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Ciudad</label>
                        <input type="text" id="modal_customer_city" name="city"
                               class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                               placeholder="Ciudad">
                    </div>
                    
                    <!-- Estado -->
                    <div>
                        <label for="modal_customer_state" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Estado</label>
                        <input type="text" id="modal_customer_state" name="state"
                               class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                               placeholder="Estado">
                    </div>
                    
                    <!-- Código postal -->
                    <div>
                        <label for="modal_customer_zip_code" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Código postal</label>
                        <input type="text" id="modal_customer_zip_code" name="zip_code"
                               class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                               placeholder="12345">
                    </div>
                    
                    <!-- Notas -->
                    <div class="sm:col-span-2">
                        <label for="modal_customer_notes" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Notas adicionales</label>
                        <textarea id="modal_customer_notes" name="notes" rows="2"
                                  class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none"
                                  placeholder="Información adicional sobre el cliente..."></textarea>
                    </div>
                </div>
                
                <!-- Botones del modal -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-customer-modal" 
                            class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>
                    
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-emerald-600 bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 hover:border-emerald-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm hover:shadow-md">
                        <i class="fas fa-save mr-2"></i>
                        Crear Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerSelect = document.getElementById('customer_id');
    
    // Elementos del modal
    const addCustomerBtn = document.getElementById('add-customer-btn');
    const customerModal = document.getElementById('customer-modal');
    const closeCustomerModal = document.getElementById('close-customer-modal');
    const cancelCustomerModal = document.getElementById('cancel-customer-modal');
    const customerForm = document.getElementById('customer-form');

    // Funciones del modal
    function openCustomerModal() {
        customerModal.classList.remove('hidden');
        customerModal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        customerModal.classList.add('hidden');
        customerModal.style.display = 'none';
        document.body.style.overflow = 'auto';
        customerForm.reset();
    }

    // Event listeners para el modal
    if (addCustomerBtn) {
    addCustomerBtn.addEventListener('click', openCustomerModal);
    }
    if (closeCustomerModal) {
    closeCustomerModal.addEventListener('click', closeModal);
    }
    if (cancelCustomerModal) {
    cancelCustomerModal.addEventListener('click', closeModal);
    }
    
    // Cerrar modal al hacer clic fuera
    if (customerModal) {
    customerModal.addEventListener('click', function(e) {
        if (e.target === customerModal) {
            closeModal();
        }
    });
    }

    // Manejar envío del formulario de cliente
    if (customerForm) {
    customerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(customerForm);
        const submitBtn = customerForm.querySelector('button[type="submit"]');
            const originalHTML = submitBtn.innerHTML;
        
        // Mostrar loading
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creando...';
        submitBtn.disabled = true;
        
        fetch('{{ route("customers.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Agregar el nuevo cliente al select
                const newOption = document.createElement('option');
                newOption.value = data.customer.id;
                    newOption.textContent = data.customer.name + (data.customer.phone ? ' - ' + data.customer.phone : '');
                newOption.selected = true;
                customerSelect.appendChild(newOption);
                
                // Cerrar modal
                closeModal();
                
                // Mostrar mensaje de éxito
                showNotification('Cliente creado exitosamente', 'success');
            } else {
                showNotification('Error al crear el cliente: ' + (data.message || 'Error desconocido'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error al crear el cliente', 'error');
        })
        .finally(() => {
            // Restaurar botón
                submitBtn.innerHTML = originalHTML;
            submitBtn.disabled = false;
        });
    });
    }

    // Función para mostrar notificaciones
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg ${
            type === 'success' ? 'bg-emerald-100 text-emerald-800 border-2 border-emerald-200' : 'bg-red-100 text-red-800 border-2 border-red-200'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                <span class="text-sm font-medium">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            notification.style.transition = 'opacity 0.3s ease-out';
            notification.style.opacity = '0';
        setTimeout(() => {
            notification.remove();
            }, 300);
        }, 3000);
    }
});
</script>
@endpush
@endsection
