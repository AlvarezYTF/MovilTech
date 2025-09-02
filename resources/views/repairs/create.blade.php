@extends('layouts.app')

@section('title', 'Nueva Reparación')
@section('header', 'Nueva Reparación')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="mr-3 p-2 rounded-lg bg-orange-50 border border-orange-100">
                    <i class="fas fa-tools text-orange-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Nueva Reparación</h3>
                    <p class="text-sm text-gray-500">Registra una nueva reparación en el sistema</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('repairs.store') }}" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información básica -->
                <div class="md:col-span-2">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Información básica</h4>
                </div>
                
                <!-- Cliente -->
                <div>
                    <label for="customer_id" class="form-label">
                        Cliente <span class="text-red-500">*</span>
                    </label>
                    <div class="flex space-x-2">
                        <select id="customer_id" name="customer_id" 
                                class="form-input flex-1 @error('customer_id') border-red-300 @enderror" required>
                            <option value="">Seleccionar cliente</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} - {{ $customer->phone ?? 'Sin teléfono' }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" id="add-customer-btn" 
                                class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200"
                                title="Agregar nuevo cliente">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    @error('customer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado de la reparación -->
                <div>
                    <label for="repair_status" class="form-label">
                        Estado de la Reparación <span class="text-red-500">*</span>
                    </label>
                    <select id="repair_status" name="repair_status" 
                            class="form-input @error('repair_status') border-red-300 @enderror" required>
                        <option value="pending" {{ old('repair_status', 'pending') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_progress" {{ old('repair_status') == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completed" {{ old('repair_status') == 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="delivered" {{ old('repair_status') == 'delivered' ? 'selected' : '' }}>Entregado</option>
                    </select>
                    @error('repair_status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Información del dispositivo -->
                <div class="md:col-span-2">
                    <h4 class="text-md font-medium text-gray-900 mb-4 mt-6">Información del dispositivo</h4>
                </div>

                <!-- Modelo del teléfono -->
                <div>
                    <label for="phone_model" class="form-label">
                        Modelo del Teléfono <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="phone_model" name="phone_model" value="{{ old('phone_model') }}" 
                           class="form-input @error('phone_model') border-red-300 @enderror" 
                           placeholder="Ej: iPhone 12, Samsung Galaxy S21" required>
                    @error('phone_model')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IMEI -->
                <div>
                    <label for="imei" class="form-label">
                        IMEI <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="imei" name="imei" value="{{ old('imei') }}" 
                           class="form-input @error('imei') border-red-300 @enderror" 
                           placeholder="Número IMEI del dispositivo" required>
                    @error('imei')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Información financiera -->
                <div class="md:col-span-2">
                    <h4 class="text-md font-medium text-gray-900 mb-4 mt-6">Información financiera</h4>
                </div>

                <!-- Costo de la reparación -->
                <div>
                    <label for="repair_cost" class="form-label">
                        Costo de la Reparación <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" id="repair_cost" name="repair_cost" value="{{ old('repair_cost') }}" 
                               class="form-input pl-8 @error('repair_cost') border-red-300 @enderror" 
                               step="0.01" min="0" placeholder="0.00" required>
                    </div>
                    @error('repair_cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha de la reparación -->
                <div>
                    <label for="repair_date" class="form-label">
                        Fecha de la Reparación <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="repair_date" name="repair_date" value="{{ old('repair_date', date('Y-m-d')) }}" 
                           class="form-input @error('repair_date') border-red-300 @enderror" required>
                    @error('repair_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción del problema -->
                <div class="md:col-span-2">
                    <label for="issue_description" class="form-label">
                        Descripción del Problema <span class="text-red-500">*</span>
                    </label>
                    <textarea id="issue_description" name="issue_description" rows="4" 
                              class="form-input @error('issue_description') border-red-300 @enderror" 
                              placeholder="Describe detalladamente el problema del dispositivo">{{ old('issue_description') }}</textarea>
                    @error('issue_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notas adicionales -->
                <div class="md:col-span-2">
                    <label for="notes" class="form-label">Notas adicionales</label>
                    <textarea id="notes" name="notes" rows="3" 
                              class="form-input @error('notes') border-red-300 @enderror" 
                              placeholder="Notas adicionales, observaciones o comentarios">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('repairs.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Crear Reparación
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para agregar nuevo cliente -->
<div id="customer-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header del modal -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Nuevo Cliente</h3>
                <button type="button" id="close-customer-modal" 
                        class="text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Formulario del cliente -->
            <form id="customer-form" class="mt-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    <div class="md:col-span-2">
                        <label for="modal_customer_name" class="form-label">
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="modal_customer_name" name="name" required
                               class="form-input" placeholder="Ej: Juan Pérez García">
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="modal_customer_email" class="form-label">Correo electrónico</label>
                        <input type="email" id="modal_customer_email" name="email"
                               class="form-input" placeholder="juan.perez@email.com">
                    </div>
                    
                    <!-- Teléfono -->
                    <div>
                        <label for="modal_customer_phone" class="form-label">Teléfono</label>
                        <input type="text" id="modal_customer_phone" name="phone"
                               class="form-input" placeholder="+1 (555) 123-4567">
                    </div>
                    
                    <!-- Dirección -->
                    <div class="md:col-span-2">
                        <label for="modal_customer_address" class="form-label">Dirección</label>
                        <input type="text" id="modal_customer_address" name="address"
                               class="form-input" placeholder="Calle, número, colonia">
                    </div>
                    
                    <!-- Ciudad -->
                    <div>
                        <label for="modal_customer_city" class="form-label">Ciudad</label>
                        <input type="text" id="modal_customer_city" name="city"
                               class="form-input" placeholder="Ciudad">
                    </div>
                    
                    <!-- Estado -->
                    <div>
                        <label for="modal_customer_state" class="form-label">Estado</label>
                        <input type="text" id="modal_customer_state" name="state"
                               class="form-input" placeholder="Estado">
                    </div>
                    
                    <!-- Código postal -->
                    <div>
                        <label for="modal_customer_zip_code" class="form-label">Código postal</label>
                        <input type="text" id="modal_customer_zip_code" name="zip_code"
                               class="form-input" placeholder="12345">
                    </div>
                    
                    <!-- Notas -->
                    <div class="md:col-span-2">
                        <label for="modal_customer_notes" class="form-label">Notas adicionales</label>
                        <textarea id="modal_customer_notes" name="notes" rows="2"
                                  class="form-input" placeholder="Información adicional sobre el cliente..."></textarea>
                    </div>
                </div>
                
                <!-- Botones del modal -->
                <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-customer-modal" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
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
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        customerModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        customerForm.reset();
    }

    // Event listeners para el modal
    addCustomerBtn.addEventListener('click', openCustomerModal);
    closeCustomerModal.addEventListener('click', closeModal);
    cancelCustomerModal.addEventListener('click', closeModal);
    
    // Cerrar modal al hacer clic fuera
    customerModal.addEventListener('click', function(e) {
        if (e.target === customerModal) {
            closeModal();
        }
    });

    // Manejar envío del formulario de cliente
    customerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(customerForm);
        const submitBtn = customerForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Mostrar loading
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creando...';
        submitBtn.disabled = true;
        
        fetch('{{ route("customers.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Agregar el nuevo cliente al select
                const newOption = document.createElement('option');
                newOption.value = data.customer.id;
                newOption.textContent = data.customer.name + ' - ' + (data.customer.email || 'Sin email');
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
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    // Función para mostrar notificaciones
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${
            type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
@endpush
@endsection
