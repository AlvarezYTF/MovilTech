@extends('layouts.app')

@section('title', 'Nueva Venta')
@section('header', 'Nueva Venta')

@section('content')
<div class="max-w-4xl mx-auto space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2.5 sm:p-3 rounded-xl bg-emerald-50 text-emerald-600">
                <i class="fas fa-shopping-cart text-lg sm:text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Nueva Venta</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Registra una nueva venta en el sistema</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('sales.store') }}" id="sale-form" x-data="{ loading: false }" @submit="loading = true">
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
                            <select name="customer_id" id="customer_id" required
                                    class="block w-full pl-10 sm:pl-11 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none bg-white transition-all @error('customer_id') border-red-300 focus:ring-red-500 @enderror">
                                <option value="">Selecciona un cliente</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}@if($customer->email) - {{ $customer->email }}@endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        <button type="button" id="add-customer-btn"
                                class="inline-flex items-center justify-center px-3 sm:px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
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

                <!-- Fecha de Venta -->
                <div>
                    <label for="sale_date" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Fecha de Venta <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                        </div>
                        <input type="date" name="sale_date" id="sale_date" required
                               value="{{ old('sale_date', date('Y-m-d')) }}"
                               class="block w-full pl-10 sm:pl-11 pr-3 sm:pr-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('sale_date') border-red-300 focus:ring-red-500 @enderror">
                    </div>
                    @error('sale_date')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Productos -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-violet-50 text-violet-600">
                    <i class="fas fa-box text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Productos</h2>
            </div>

            <div class="space-y-5 sm:space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                    <!-- Producto -->
                    <div>
                        <label for="product_id" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            Producto <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-box text-gray-400 text-sm"></i>
                            </div>
                            <select name="product_id" id="product_id" required
                                    class="block w-full pl-10 sm:pl-11 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none bg-white transition-all @error('product_id') border-red-300 focus:ring-red-500 @enderror">
                                <option value="">Selecciona un producto</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                            data-price="{{ $product->price }}"
                                            data-stock="{{ $product->quantity }}"
                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - Stock: {{ $product->quantity }} - ${{ number_format($product->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        @error('product_id')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Cantidad -->
                    <div>
                        <label for="quantity" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            Cantidad <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="quantity" id="quantity" min="1" required
                                   value="{{ old('quantity', 1) }}"
                                   class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('quantity') border-red-300 focus:ring-red-500 @enderror">
                        </div>
                        <div class="mt-1.5 flex items-center space-x-2">
                            <span class="text-xs text-gray-500">Stock disponible:</span>
                            <span id="stock-display" class="text-xs font-semibold text-gray-900">-</span>
                        </div>
                        @error('quantity')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                    <!-- Precio Unitario -->
                    <div>
                        <label for="unit_price" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            Precio Unitario <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">$</span>
                            </div>
                            <input type="number" name="unit_price" id="unit_price" step="0.01" min="0" required
                                   value="{{ old('unit_price', '0.00') }}"
                                   class="block w-full pl-10 sm:pl-11 pr-3 sm:pr-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('unit_price') border-red-300 focus:ring-red-500 @enderror">
                        </div>
                        @error('unit_price')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Total -->
                    <div>
                        <label for="total" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            Total <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">$</span>
                            </div>
                            <input type="number" name="total" id="total" step="0.01" min="0" required readonly
                                   value="{{ old('total', '0.00') }}"
                                   class="block w-full pl-10 sm:pl-11 pr-3 sm:pr-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 bg-gray-50 focus:outline-none">
                        </div>
                        @error('total')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Notas -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-gray-50 text-gray-600">
                    <i class="fas fa-sticky-note text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información Adicional</h2>
            </div>

            <div>
                <label for="notes" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                    Notas adicionales
                </label>
                <textarea name="notes" id="notes" rows="3"
                          class="block w-full px-3 sm:px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none @error('notes') border-red-300 focus:ring-red-500 @enderror"
                          placeholder="Agrega notas adicionales sobre la venta...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1.5"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-4 border-t border-gray-100">
            <div class="text-xs sm:text-sm text-gray-500 flex items-center">
                <i class="fas fa-info-circle mr-1.5"></i>
                Los campos marcados con <span class="text-red-500 ml-1">*</span> son obligatorios
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="{{ route('sales.index') }}"
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-emerald-600 bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 hover:border-emerald-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm hover:shadow-md"
                        :disabled="loading">
                    <template x-if="!loading">
                        <i class="fas fa-save mr-2"></i>
                    </template>
                    <template x-if="loading">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                    </template>
                    <span x-text="loading ? 'Procesando...' : 'Crear Venta'">Crear Venta</span>
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
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const totalInput = document.getElementById('total');
    const stockDisplay = document.getElementById('stock-display');
    const customerSelect = document.getElementById('customer_id');

    // Elementos del modal
    const addCustomerBtn = document.getElementById('add-customer-btn');
    const customerModal = document.getElementById('customer-modal');
    const closeCustomerModal = document.getElementById('close-customer-modal');
    const cancelCustomerModal = document.getElementById('cancel-customer-modal');
    const customerForm = document.getElementById('customer-form');

    function updateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalInput.value = total.toFixed(2);
    }

    function updateStock() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.stock) {
            const stock = parseInt(selectedOption.dataset.stock);
            stockDisplay.textContent = stock;
            quantityInput.max = stock;
            
            // Validar cantidad actual si es mayor que el stock
            if (parseInt(quantityInput.value) > stock) {
                quantityInput.value = stock;
                updateTotal();
            }
        } else {
            stockDisplay.textContent = '-';
            quantityInput.removeAttribute('max');
        }
    }

    function updatePrice() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.price) {
            unitPriceInput.value = parseFloat(selectedOption.dataset.price).toFixed(2);
            updateTotal();
        }
    }

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
                    newOption.textContent = data.customer.name + (data.customer.email ? ' - ' + data.customer.email : '');
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

    // Event listeners para productos
    if (productSelect) {
        productSelect.addEventListener('change', function() {
            updatePrice();
            updateStock();
        });
    }

    if (quantityInput) {
        quantityInput.addEventListener('input', function() {
            updateTotal();
            // Validar que no exceda el stock disponible
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (selectedOption && selectedOption.dataset.stock) {
                const stock = parseInt(selectedOption.dataset.stock);
                if (parseInt(this.value) > stock) {
                    this.value = stock;
                    updateTotal();
                    showNotification('La cantidad no puede exceder el stock disponible', 'error');
                }
            }
        });
    }

    if (unitPriceInput) {
        unitPriceInput.addEventListener('input', updateTotal);
    }

    // Inicializar
    if (productSelect && productSelect.value) {
        updatePrice();
        updateStock();
    }
    updateTotal();
});
</script>
@endpush
@endsection
