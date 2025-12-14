@extends('layouts.app')

@section('title', 'Nueva Venta')
@section('header', 'Nueva Venta')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
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
                
            <div class="space-y-5 sm:space-y-6">
                <!-- Cliente -->
                <div>
                    <label for="customer_id" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Cliente <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-2">
                        <div class="relative flex-1">
                        <select name="customer_id" id="customer_id" required 
                                    class="block w-full border border-gray-300 rounded-xl text-sm @error('customer_id') border-red-300 @enderror">
                            <option value="">{{ old('customer_id') ? '' : 'Selecciona un cliente' }}</option>
                            @foreach($customers as $customer)
                                @php
                                    $displayText = $customer->name;
                                    if ($customer->taxProfile && $customer->taxProfile->identification) {
                                        $docType = $customer->taxProfile->identificationDocument ? 
                                            $customer->taxProfile->identificationDocument->code . ': ' : '';
                                        $docNumber = $customer->taxProfile->identification;
                                        $dv = $customer->taxProfile->dv ? '-' . $customer->taxProfile->dv : '';
                                        $displayText .= ' - ' . $docType . $docNumber . $dv;
                                    }
                                @endphp
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $displayText }}
                                </option>
                            @endforeach
                        </select>
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

                <!-- Fecha de Venta, Método de Pago, Forma de Pago -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
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

                <!-- Método de Pago -->
                <div>
                    <label for="payment_method_code" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Método de Pago
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-credit-card text-gray-400 text-sm"></i>
                        </div>
                        <select name="payment_method_code" id="payment_method_code"
                                class="block w-full pl-10 sm:pl-11 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none bg-white transition-all @error('payment_method_code') border-red-300 focus:ring-red-500 @enderror">
                            <option value="">Seleccione un método...</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->code }}" {{ old('payment_method_code', '10') == $method->code ? 'selected' : '' }}>
                                    {{ $method->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                    @error('payment_method_code')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Forma de Pago -->
                <div>
                    <label for="payment_form_code" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                        Forma de Pago
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-money-bill-wave text-gray-400 text-sm"></i>
                        </div>
                        <select name="payment_form_code" id="payment_form_code"
                                class="block w-full pl-10 sm:pl-11 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none bg-white transition-all @error('payment_form_code') border-red-300 focus:ring-red-500 @enderror">
                            <option value="">Seleccione una forma...</option>
                            @foreach($paymentForms as $form)
                                <option value="{{ $form->code }}" {{ old('payment_form_code', '1') == $form->code ? 'selected' : '' }}>
                                    {{ $form->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                    @error('payment_form_code')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

                <!-- Productos -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6" 
             x-data="saleProducts()" 
             x-init="init()">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <div class="p-2 rounded-xl bg-violet-50 text-violet-600">
                        <i class="fas fa-box text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Productos</h2>
                </div>
                <div class="text-sm text-gray-600">
                    <span x-text="items.length"></span> producto(s) agregado(s)
                </div>
            </div>

            <!-- Formulario para agregar producto -->
            <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-5 mb-4 sm:mb-6">
                <!-- Búsqueda por SKU / Escáner -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                        <i class="fas fa-barcode mr-1"></i>
                        Buscar por SKU / Escanear código
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-barcode text-gray-400 text-sm"></i>
                        </div>
                        <input type="text"
                               x-model="skuSearch"
                               @keydown.enter.prevent="searchBySku()"
                               @input="clearSkuError()"
                               placeholder="Escanee o ingrese el SKU del producto"
                               class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                               :class="skuError ? 'border-red-300 focus:ring-red-500' : ''">
                        <button type="button"
                                @click="searchBySku()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-emerald-600 hover:text-emerald-700 transition-colors">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </div>
                    <p x-show="skuError" class="mt-1.5 text-xs text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1.5"></i>
                        <span x-text="skuError"></span>
                    </p>
                </div>

                <!-- Campos del producto -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Producto -->
                    <div class="md:col-span-2 lg:col-span-1">
                        <label class="block text-xs font-semibold text-gray-700 mb-2">
                        Producto <span class="text-red-500">*</span>
                    </label>
                        <div class="relative">
                            <select x-model="newItem.product_id"
                                    x-ref="productSelect"
                                    @change="updateProductInfo()"
                                    class="block w-full border border-gray-300 rounded-lg text-sm">
                                <option value="">Selecciona un producto...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-price="{{ $product->price }}"
                                    data-stock="{{ $product->quantity }}"
                                    data-name="{{ $product->name }}"
                                    data-sku="{{ $product->sku }}">
                                        {{ $product->name }} - Stock: {{ $product->quantity }}
                            </option>
                        @endforeach
                    </select>
                        </div>
                </div>

                <!-- Cantidad -->
                <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">
                        Cantidad <span class="text-red-500">*</span>
                    </label>
                        <input type="number"
                               x-model.number="newItem.quantity"
                               x-bind="newItem.stock > 0 ? { min: '1', max: String(newItem.stock) } : {}"
                               :disabled="newItem.stock === 0 || !newItem.product_id"
                               @input="updateItemTotal(); validateQuantity()"
                               @blur="validateQuantity()"
                               class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed">
                        <div class="mt-1.5 text-xs" :class="newItem.stock === 0 ? 'text-red-600 font-semibold' : 'text-gray-500'">
                            Stock: <span x-text="newItem.stock || '-'"></span>
                            <span x-show="newItem.stock === 0" class="ml-1">(Sin stock disponible)</span>
                        </div>
                </div>

                <!-- Precio Unitario -->
                <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">
                        Precio Unitario <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-xs">$</span>
                            </div>
                            <input type="number"
                                   x-model.number="newItem.unit_price"
                                   step="0.01"
                                   min="0"
                                   @input="updateItemTotal()"
                                   class="block w-full pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Total y Botón -->
                    <div class="flex flex-col gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Total</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-xs">$</span>
                                </div>
                                <input type="text"
                                       :value="formatCurrency(newItem.total)"
                                       readonly
                                       class="block w-full pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 bg-gray-50 focus:outline-none font-semibold">
                            </div>
                        </div>
                        <button type="button"
                                @click="addItem()"
                                :disabled="!canAddItem()"
                                class="w-full px-4 py-2.5 rounded-lg border-2 border-emerald-600 bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 hover:border-emerald-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Agregar</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Lista de productos agregados -->
            <div x-show="items.length > 0" class="space-y-3">
                <!-- Tabla Desktop -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Precio Unit.</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-900" x-text="item.product_name"></td>
                                    <td class="px-4 py-3 text-sm text-gray-900" x-text="item.quantity"></td>
                                    <td class="px-4 py-3 text-sm text-gray-900" x-text="formatCurrency(item.unit_price)"></td>
                                    <td class="px-4 py-3 text-sm font-semibold text-emerald-600" x-text="formatCurrency(item.total)"></td>
                                    <td class="px-4 py-3 text-right">
                                        <button type="button"
                                                @click="removeItem(index)"
                                                class="text-red-600 hover:text-red-700 transition-colors"
                                                title="Eliminar">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-sm font-bold text-gray-900 text-right">Total General:</td>
                                <td class="px-4 py-3 text-lg font-bold text-emerald-600" x-text="formatCurrency(grandTotal)"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Cards Mobile/Tablet -->
                <div class="lg:hidden space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-semibold text-gray-900 truncate" x-text="item.product_name"></h3>
                                </div>
                                <button type="button"
                                        @click="removeItem(index)"
                                        class="ml-2 p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors flex-shrink-0"
                                        title="Eliminar">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Cantidad</p>
                                    <p class="text-sm font-semibold text-gray-900" x-text="item.quantity"></p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Precio Unit.</p>
                                    <p class="text-sm text-gray-900" x-text="formatCurrency(item.unit_price)"></p>
                                </div>
                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total</p>
                                    <p class="text-sm font-bold text-emerald-600" x-text="formatCurrency(item.total)"></p>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Total General Mobile -->
                    <div class="bg-emerald-50 rounded-xl border-2 border-emerald-200 p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-gray-900">Total General:</span>
                            <span class="text-xl font-bold text-emerald-600" x-text="formatCurrency(grandTotal)"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mensaje cuando no hay productos -->
            <div x-show="items.length === 0" class="text-center py-8 text-gray-500">
                <i class="fas fa-box text-3xl mb-2"></i>
                <p class="text-sm">Agrega productos a la venta</p>
            </div>

            <!-- Campos ocultos para el formulario -->
            <template x-for="(item, index) in items" :key="index">
                <div>
                    <input type="hidden" :name="`items[${index}][product_id]`" :value="item.product_id">
                    <input type="hidden" :name="`items[${index}][quantity]`" :value="item.quantity">
                    <input type="hidden" :name="`items[${index}][unit_price]`" :value="item.unit_price">
                </div>
            </template>
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

                <!-- Facturación Electrónica DIAN -->
                <div class="border-t border-gray-200 pt-4 mt-4"
                     x-data="modalCustomerElectronicInvoice()">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                                <i class="fas fa-file-invoice text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Facturación Electrónica DIAN</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Activa esta opción si el cliente requiere facturación electrónica</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                   name="requires_electronic_invoice"
                                   value="1"
                                   x-model="requiresElectronicInvoice"
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>

                    <!-- Campos DIAN (mostrar/ocultar dinámicamente) -->
                    <div x-show="requiresElectronicInvoice"
                         x-transition
                         class="space-y-4 border-t border-gray-200 pt-4">
                        
                        <!-- Mensaje informativo -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-2 text-sm"></i>
                                <div class="text-xs text-blue-800">
                                    <p class="font-semibold mb-1">Campos Obligatorios para Facturación Electrónica</p>
                                    <p>Complete todos los campos marcados con <span class="text-red-500 font-bold">*</span> para poder generar facturas electrónicas válidas según la normativa DIAN.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tipo de Documento -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Tipo de Documento <span class="text-red-500">*</span>
                                </label>
                                <select name="identification_document_id"
                                        x-model="identificationDocumentId"
                                        @change="updateRequiredFields()"
                                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm"
                                        :required="requiresElectronicInvoice">
                                    <option value="">Seleccione...</option>
                                    @foreach($identificationDocuments as $doc)
                                        <option value="{{ $doc->id }}" 
                                                data-code="{{ $doc->code }}"
                                                data-requires-dv="{{ $doc->requires_dv ? 'true' : 'false' }}">
                                            {{ $doc->name }}@if($doc->code) ({{ $doc->code }})@endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Identificación -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Número de Identificación <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="identification"
                                       x-model="identification"
                                       @input="calculateDV()"
                                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm"
                                       :required="requiresElectronicInvoice">
                            </div>
                        </div>

                        <!-- Dígito Verificador -->
                        <div x-show="requiresDV" 
                             x-transition
                             class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Dígito Verificador (DV) <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="dv"
                                       x-model="dv"
                                       maxlength="1"
                                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm"
                                       :required="requiresDV">
                                <p class="mt-1 text-xs text-gray-500">Se calcula automáticamente para NIT</p>
                            </div>
                        </div>

                        <!-- Razón Social / Nombre Comercial -->
                        <div x-show="isJuridicalPerson" 
                             x-transition
                             class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Razón Social / Empresa <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="company"
                                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm"
                                       :required="isJuridicalPerson">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Nombre Comercial
                                </label>
                                <input type="text"
                                       name="trade_name"
                                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm">
                            </div>
                        </div>

                        <!-- Nombres (solo para personas naturales) -->
                        <div x-show="!isJuridicalPerson" 
                             x-transition
                             class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Nombres
                                </label>
                                <input type="text"
                                       name="names"
                                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm"
                                       placeholder="Nombres completos de la persona natural">
                                <p class="mt-1 text-xs text-gray-500">Solo aplica para personas naturales</p>
                            </div>
                        </div>

                        <!-- Tipo de Organización Legal -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">
                                Tipo de Organización Legal
                            </label>
                            <select name="legal_organization_id"
                                    class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm">
                                <option value="">Seleccione...</option>
                                @foreach($legalOrganizations as $org)
                                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Municipio -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">
                                Municipio <span class="text-red-500">*</span>
                            </label>
                            @if($municipalities->isEmpty())
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <div class="flex items-start">
                                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5 mr-2 text-sm"></i>
                                        <div class="text-xs text-yellow-800">
                                            <p class="font-semibold mb-1">No hay municipios disponibles</p>
                                            <p>Ejecuta el comando <code class="bg-yellow-100 px-1 rounded">php artisan factus:sync-municipalities</code> para sincronizar los municipios desde Factus.</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="municipality_id" value="">
                            @else
                                <select name="municipality_id"
                                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm"
                                        :required="requiresElectronicInvoice">
                                    <option value="">Seleccione un municipio...</option>
                                    @php
                                        $currentDepartment = null;
                                    @endphp
                                    @foreach($municipalities as $municipality)
                                        @if($currentDepartment !== $municipality->department)
                                            @if($currentDepartment !== null)
                                                </optgroup>
                                            @endif
                                            <optgroup label="{{ $municipality->department }}">
                                            @php
                                                $currentDepartment = $municipality->department;
                                            @endphp
                                        @endif
                                        <option value="{{ $municipality->factus_id }}">
                                            {{ $municipality->name }}
                                        </option>
                                        @if($loop->last)
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Seleccione el municipio según el departamento</p>
                            @endif
                        </div>

                        <!-- Régimen Tributario -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">
                                Régimen Tributario
                            </label>
                            <select name="tribute_id"
                                    class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm">
                                <option value="">Seleccione...</option>
                                @foreach($tributes as $tribute)
                                    <option value="{{ $tribute->id }}">{{ $tribute->name }} ({{ $tribute->code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Información de Contacto Adicional -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Dirección Fiscal
                                </label>
                                <input type="text"
                                       name="address"
                                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm"
                                       placeholder="Dirección para facturación">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Email Fiscal
                                </label>
                                <input type="email"
                                       name="email"
                                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm"
                                       placeholder="email@ejemplo.com">
                                <p class="mt-1 text-xs text-gray-500">Email para envío de facturas electrónicas</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">
                                Teléfono Fiscal
                            </label>
                            <input type="text"
                                   name="phone"
                                   class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm"
                                   placeholder="Número de teléfono">
                        </div>
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

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 42px;
        border: 1px solid #d1d5db !important;
        border-radius: 0.75rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
        padding-left: 1rem;
        padding-right: 2rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 10px;
    }
    .select2-dropdown {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
    }
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    .select2-container {
        width: 100% !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
const productsData = @json($productsData);

function saleProducts() {
    return {
        items: [],
        skuSearch: '',
        skuError: null,
        newItem: {
            product_id: '',
            product_name: '',
            quantity: 1,
            unit_price: 0,
            stock: 0,
            total: 0
        },
        products: productsData,

        init() {
            // Initialize Select2 for product after Alpine renders
            this.$nextTick(() => {
                // Wait a bit more to ensure Select2 is loaded
                setTimeout(() => {
                    if (this.$refs.productSelect && typeof jQuery !== 'undefined' && jQuery().select2) {
                        const self = this;
                        const $productSelect = jQuery(this.$refs.productSelect);
                        if (!$productSelect.data('select2')) {
                            $productSelect.select2({
                                placeholder: 'Selecciona un producto',
                                allowClear: true,
                                language: {
                                    noResults: function() {
                                        return "No se encontraron productos";
                                    },
                                    searching: function() {
                                        return "Buscando...";
                                    }
                                },
                                ajax: {
                                    url: '/api/products/search',
                                    dataType: 'json',
                                    delay: 250,
                                    data: function (params) {
                                        return {
                                            q: params.term,
                                            page: params.page
                                        };
                                    },
                                    processResults: function (data) {
                                        return {
                                            results: data.results.map(function(item) {
                                                return {
                                                    id: item.id,
                                                    text: item.text,
                                                    price: item.price,
                                                    stock: item.stock,
                                                    name: item.name,
                                                    sku: item.sku
                                                };
                                            })
                                        };
                                    },
                                    cache: true
                                },
                                minimumInputLength: 0,
                                templateResult: function(product) {
                                    if (product.loading) {
                                        return product.text;
                                    }
                                    return product.text;
                                },
                                templateSelection: function(product) {
                                    return product.text || product.name;
                                }
                            });

                            // Sync Select2 with Alpine.js
                            $productSelect.on('select2:select', function(e) {
                                const data = e.params.data;
                                self.newItem.product_id = String(data.id);
                                // Find product in local data for full info
                                const localProduct = self.products.find(p => p.id == data.id);
                                if (localProduct) {
                                    self.newItem.unit_price = localProduct.price || 0;
                                    self.newItem.stock = localProduct.stock || 0;
                                } else {
                                    self.newItem.unit_price = data.price || 0;
                                    self.newItem.stock = data.stock || 0;
                                }
                                self.newItem.quantity = (self.newItem.stock || 0) > 0 ? 1 : 0;
                                self.updateProductInfo();
                            });

                            $productSelect.on('select2:clear', function() {
                                self.newItem.product_id = '';
                                self.updateProductInfo();
                            });
                        }
                    }
                }, 200);
            });

            // Focus on SKU search field for scanner
            this.$nextTick(() => {
                const skuInput = document.querySelector('[x-model="skuSearch"]');
                if (skuInput) {
                    skuInput.focus();
                }
            });
        },

        searchBySku() {
            if (!this.skuSearch || !this.skuSearch.trim()) {
                this.skuError = 'Por favor ingrese un SKU';
                return;
            }

            const sku = this.skuSearch.trim().toUpperCase();
            const product = this.products.find(p => p.sku && p.sku.toUpperCase() === sku);

            if (!product) {
                this.skuError = 'Producto no encontrado con el SKU: ' + sku;
                this.skuSearch = '';
                return;
            }

            // Check if product is already in items
            const existingIndex = this.items.findIndex(item => item.product_id === product.id);

            if (existingIndex !== -1) {
                this.skuError = 'Este producto ya está en la lista';
                this.skuSearch = '';
                return;
            }

            // Set the product
            this.newItem.product_id = product.id;
            this.updateProductInfo();
            this.skuSearch = '';
            this.skuError = null;

            // Focus on quantity field
            this.$nextTick(() => {
                const quantityInput = document.querySelector('[x-model.number="newItem.quantity"]');
                if (quantityInput) {
                    quantityInput.focus();
                    quantityInput.select();
                }
            });
        },

        clearSkuError() {
            this.skuError = null;
        },

        updateProductInfo() {
            const productId = this.newItem.product_id ? String(this.newItem.product_id) : '';
            if (!productId) {
                this.newItem.product_name = '';
                this.newItem.unit_price = 0;
                this.newItem.stock = 0;
                this.newItem.quantity = 0;
                this.newItem.total = 0;
                return;
            }
            
            const product = this.products.find(p => String(p.id) === productId);
            
            if (product) {
                this.newItem.product_name = product.name;
                this.newItem.unit_price = product.price || this.newItem.unit_price;
                this.newItem.stock = product.stock !== undefined ? product.stock : this.newItem.stock;
                // Si el stock es 0, establecer cantidad en 0, sino en 1
                if (this.newItem.quantity === 0 || !this.newItem.quantity) {
                    this.newItem.quantity = this.newItem.stock > 0 ? 1 : 0;
                }
                this.updateItemTotal();
            } else {
                // Si no está en los productos locales, los valores ya fueron establecidos por Select2
                if (this.newItem.quantity === 0 || !this.newItem.quantity) {
                    this.newItem.quantity = this.newItem.stock > 0 ? 1 : 0;
                }
                this.updateItemTotal();
            }
        },

        updateItemTotal() {
            const quantity = parseFloat(this.newItem.quantity) || 0;
            const unitPrice = parseFloat(this.newItem.unit_price) || 0;
            this.newItem.total = quantity * unitPrice;
        },

        validateQuantity() {
            // Solo validar si hay un producto seleccionado y stock disponible
            if (!this.newItem.product_id || this.newItem.stock === 0) {
                return;
            }

            // Validar y ajustar cantidad si es necesario
            if (this.newItem.quantity > this.newItem.stock) {
                this.newItem.quantity = this.newItem.stock;
                this.updateItemTotal();
                this.showNotification('La cantidad no puede exceder el stock disponible', 'error');
            } else if (this.newItem.quantity < 1 && this.newItem.stock > 0) {
                this.newItem.quantity = 1;
                this.updateItemTotal();
            }
        },

        canAddItem() {
            return this.newItem.product_id && 
                   this.newItem.stock > 0 &&
                   this.newItem.quantity > 0 && 
                   this.newItem.quantity <= this.newItem.stock &&
                   this.newItem.unit_price > 0;
        },

        addItem() {
            if (!this.canAddItem()) {
                if (this.newItem.stock === 0) {
                    this.showNotification('Este producto no tiene stock disponible', 'error');
                } else if (!this.newItem.product_id) {
                    this.showNotification('Por favor selecciona un producto', 'error');
                } else if (this.newItem.quantity <= 0) {
                    this.showNotification('La cantidad debe ser mayor a 0', 'error');
                } else if (this.newItem.quantity > this.newItem.stock) {
                    this.showNotification('La cantidad no puede exceder el stock disponible', 'error');
                } else {
                    this.showNotification('Por favor completa todos los campos correctamente', 'error');
                }
                return;
            }

            // Verificar que no se exceda el stock
            if (this.newItem.quantity > this.newItem.stock) {
                this.showNotification('La cantidad no puede exceder el stock disponible', 'error');
                return;
            }

            // Verificar si el producto ya está agregado
            const existingIndex = this.items.findIndex(item => item.product_id === this.newItem.product_id);
            if (existingIndex !== -1) {
                // Actualizar cantidad si ya existe
                const existingItem = this.items[existingIndex];
                const newQuantity = existingItem.quantity + this.newItem.quantity;
                
                if (newQuantity > this.newItem.stock) {
                    this.showNotification('La cantidad total excede el stock disponible', 'error');
                    return;
                }
                
                existingItem.quantity = newQuantity;
                existingItem.total = newQuantity * existingItem.unit_price;
            } else {
                // Agregar nuevo producto
                this.items.push({
                    product_id: this.newItem.product_id,
                    product_name: this.newItem.product_name,
                    quantity: this.newItem.quantity,
                    unit_price: this.newItem.unit_price,
                    total: this.newItem.total
                });
            }

            // Resetear formulario
            this.newItem = {
                product_id: '',
                product_name: '',
                quantity: 1,
                unit_price: 0,
                stock: 0,
                total: 0
            };
        },

        removeItem(index) {
            this.items.splice(index, 1);
        },

        get grandTotal() {
            return this.items.reduce((sum, item) => sum + item.total, 0);
        },

        formatCurrency(value) {
            return '$' + parseFloat(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        },

        showNotification(message, type) {
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

            setTimeout(() => {
                notification.style.transition = 'opacity 0.3s ease-out';
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
    };
}

// Alpine.js function for customer modal electronic invoice section
function modalCustomerElectronicInvoice() {
    return {
        requiresElectronicInvoice: false,
        identificationDocumentId: null,
        identification: '',
        dv: '',
        requiresDV: false,
        isJuridicalPerson: false,
        
        updateRequiredFields() {
            const select = document.querySelector('#customer-form select[name="identification_document_id"]');
            if (select && select.selectedIndex >= 0) {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption) {
                    this.requiresDV = selectedOption.dataset.requiresDv === 'true';
                    this.isJuridicalPerson = selectedOption.dataset.code === 'NIT';
                }
            }
        },
        
        calculateDV() {
            // Basic DV calculation placeholder
            if (this.requiresDV && this.isJuridicalPerson && this.identification && this.identification.length >= 9) {
                // Algoritmo de cálculo de DV puede ir aquí
            }
        }
    };
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for customer
    $('#customer_id').select2({
        placeholder: 'Selecciona un cliente',
        allowClear: true,
        language: {
            noResults: function() {
                return "No se encontraron clientes";
            },
            searching: function() {
                return "Buscando...";
            }
        },
        ajax: {
            url: '/api/customers/search',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        templateResult: function(customer) {
            if (customer.loading) {
                return customer.text;
            }
            return customer.text;
        },
        templateSelection: function(customer) {
            return customer.text || customer.name;
        }
    });

    // If there's an old value, set it
    @php
        $oldCustomerId = old('customer_id');
        $oldCustomerText = '';
        if ($oldCustomerId) {
            $oldCustomer = $customers->firstWhere('id', $oldCustomerId);
            if ($oldCustomer) {
                $oldCustomerText = $oldCustomer->name;
                if ($oldCustomer->taxProfile && $oldCustomer->taxProfile->identification) {
                    $docType = $oldCustomer->taxProfile->identificationDocument ? 
                        $oldCustomer->taxProfile->identificationDocument->code . ': ' : '';
                    $docNumber = $oldCustomer->taxProfile->identification;
                    $dv = $oldCustomer->taxProfile->dv ? '-' . $oldCustomer->taxProfile->dv : '';
                    $oldCustomerText .= ' - ' . $docType . $docNumber . $dv;
                }
            }
        }
    @endphp
    @if($oldCustomerId && $oldCustomerText)
        const oldCustomerId = {{ $oldCustomerId }};
        const oldCustomerText = @json($oldCustomerText);
        if (oldCustomerId && oldCustomerText) {
            const option = new Option(oldCustomerText, oldCustomerId, true, true);
            $('#customer_id').append(option).trigger('change');
        }
    @endif

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
                // Agregar el nuevo cliente al select2
                // Si tiene perfil fiscal, mostrar número de documento
                let customerText = data.customer.name;
                if (data.customer.tax_profile && data.customer.tax_profile.identification) {
                    const docType = data.customer.tax_profile.document_type ? data.customer.tax_profile.document_type + ': ' : '';
                    const docNumber = data.customer.tax_profile.identification;
                    const dv = data.customer.tax_profile.dv ? '-' + data.customer.tax_profile.dv : '';
                    customerText += ' - ' + docType + docNumber + dv;
                } else if (data.customer.email) {
                    customerText += ' - ' + data.customer.email;
                }
                const newOption = new Option(customerText, data.customer.id, true, true);
                $('#customer_id').append(newOption).trigger('change');
                
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

    // Validar que haya al menos un producto antes de enviar
    const saleForm = document.getElementById('sale-form');
    if (saleForm) {
        saleForm.addEventListener('submit', function(e) {
            const items = document.querySelectorAll('input[name^="items["]');
            if (items.length === 0) {
                e.preventDefault();
                showNotification('Debe agregar al menos un producto a la venta', 'error');
                return false;
            }
        });
    }
});
</script>
@endpush
@endsection
