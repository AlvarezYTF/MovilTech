@extends('layouts.app')

@section('title', 'Editar Venta')
@section('header', 'Editar Venta')

@section('content')
<div class="max-w-4xl mx-auto space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2.5 sm:p-3 rounded-xl bg-emerald-50 text-emerald-600">
                <i class="fas fa-edit text-lg sm:text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Editar Venta</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Modifica la información de la venta #{{ $sale->invoice_number }}</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('sales.update', $sale) }}" id="sale-form" x-data="{ loading: false }" @submit="loading = true">
        @csrf
        @method('PUT')

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
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400 text-sm"></i>
                        </div>
                        <select name="customer_id" id="customer_id" required
                                class="block w-full pl-10 sm:pl-11 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none bg-white transition-all @error('customer_id') border-red-300 focus:ring-red-500 @enderror">
                            <option value="">Selecciona un cliente</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                        {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}@if($customer->email) - {{ $customer->email }}@endif
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
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
                               value="{{ old('sale_date', $sale->sale_date ? $sale->sale_date->format('Y-m-d') : $sale->created_at->format('Y-m-d')) }}"
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

            <!-- Formulario para agregar/editar producto -->
            <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-5 mb-4 sm:mb-6"
                 :class="editingIndex !== null ? 'border-blue-300 bg-blue-50' : ''">
                <div x-show="editingIndex !== null" class="mb-4 p-3 bg-blue-100 border border-blue-200 rounded-lg">
                    <div class="flex items-center text-blue-800 text-sm font-semibold">
                        <i class="fas fa-edit mr-2"></i>
                        <span>Editando producto: <span x-text="newItem.product_name"></span></span>
                    </div>
                </div>

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
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-box text-gray-400 text-xs"></i>
                            </div>
                            <select x-model="newItem.product_id"
                                    @change="updateProductInfo()"
                                    :disabled="editingIndex !== null"
                                    class="block w-full pl-9 pr-8 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none bg-white disabled:bg-gray-100 disabled:cursor-not-allowed">
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
                            <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </div>
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
                        <div class="flex gap-2">
                            <button type="button"
                                    x-show="editingIndex === null"
                                    @click="addItem()"
                                    :disabled="!canAddItem()"
                                    class="flex-1 px-4 py-2.5 rounded-lg border-2 border-emerald-600 bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 hover:border-emerald-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                <i class="fas fa-plus mr-2"></i>
                                <span>Agregar</span>
                            </button>
                            <template x-if="editingIndex !== null">
                                <div class="flex gap-2 flex-1">
                                    <button type="button"
                                            @click="updateItem()"
                                            :disabled="!canAddItem()"
                                            class="flex-1 px-4 py-2.5 rounded-lg border-2 border-emerald-600 bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 hover:border-emerald-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                        <i class="fas fa-save mr-2"></i>
                                        <span>Guardar</span>
                                    </button>
                                    <button type="button"
                                            @click="cancelEdit()"
                                            class="px-4 py-2.5 rounded-lg border-2 border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 flex items-center justify-center">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
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
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button"
                                                    @click="editItem(index)"
                                                    class="text-blue-600 hover:text-blue-700 transition-colors"
                                                    title="Editar">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                            <button type="button"
                                                    @click="removeItem(index)"
                                                    class="text-red-600 hover:text-red-700 transition-colors"
                                                    title="Eliminar">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
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
                                <div class="flex items-center gap-2 ml-2">
                                    <button type="button"
                                            @click="editItem(index)"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors flex-shrink-0"
                                            title="Editar">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button type="button"
                                            @click="removeItem(index)"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors flex-shrink-0"
                                            title="Eliminar">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
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
                          placeholder="Agrega notas adicionales sobre la venta...">{{ old('notes', $sale->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1.5"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-gray-50 text-gray-600">
                    <i class="fas fa-info-circle text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información del Sistema</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-hashtag text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Número de Factura</div>
                            <div class="text-base sm:text-lg font-bold text-gray-900">{{ $sale->invoice_number }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-check-circle text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Estado</div>
                            <div>
                                @if($sale->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                        <i class="fas fa-check-circle mr-1.5"></i>
                                        Completada
                                    </span>
                                @elseif($sale->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                        <i class="fas fa-clock mr-1.5"></i>
                                        Pendiente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                        <i class="fas fa-times-circle mr-1.5"></i>
                                        Cancelada
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-calendar-plus text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Fecha de Creación</div>
                            <div class="text-sm font-semibold text-gray-900">{{ $sale->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-calendar-edit text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Última Actualización</div>
                            <div class="text-sm font-semibold text-gray-900">{{ $sale->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
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
                <a href="{{ route('sales.show', $sale) }}"
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
                    <span x-text="loading ? 'Procesando...' : 'Actualizar Venta'">Actualizar Venta</span>
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
const productsData = @json($productsData);
const existingItems = @json($existingItems);

function saleProducts() {
    return {
        items: existingItems || [],
        editingIndex: null,
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
            // Los items existentes ya están cargados en this.items
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

            // Check if product is already in items (excluding the one being edited)
            const existingIndex = this.editingIndex !== null ?
                this.items.findIndex((item, idx) => item.product_id === product.id && idx !== this.editingIndex) :
                this.items.findIndex(item => item.product_id === product.id);

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
            const productId = parseInt(this.newItem.product_id);
            const product = this.products.find(p => p.id === productId);

            if (product) {
                // Check if this product is already in the sale items (excluding the one being edited)
                const existingItemIndex = this.editingIndex !== null ?
                    this.items.findIndex((item, idx) => item.product_id === productId && idx !== this.editingIndex) :
                    this.items.findIndex(item => item.product_id === productId);
                const existingItem = existingItemIndex !== -1 ? this.items[existingItemIndex] : null;

                const currentStock = existingItem ?
                    product.stock + existingItem.quantity :
                    product.stock;
                
                this.newItem.product_name = product.name;
                if (this.editingIndex === null) {
                    this.newItem.unit_price = product.price;
                }
                this.newItem.stock = currentStock;
                if (this.editingIndex === null) {
                    this.newItem.quantity = currentStock > 0 ? 1 : 0;
                }
                this.updateItemTotal();
            } else {
                this.newItem.product_name = '';
                if (this.editingIndex === null) {
                    this.newItem.unit_price = 0;
                }
                this.newItem.stock = 0;
                if (this.editingIndex === null) {
                    this.newItem.quantity = 0;
                }
                this.newItem.total = 0;
            }
        },

        updateItemTotal() {
            const quantity = parseFloat(this.newItem.quantity) || 0;
            const unitPrice = parseFloat(this.newItem.unit_price) || 0;
            this.newItem.total = quantity * unitPrice;
        },

        validateQuantity() {
            if (!this.newItem.product_id || this.newItem.stock === 0) {
                return;
            }

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

            // Check if product already exists in items (excluding the one being edited)
            const existingIndex = this.editingIndex !== null ?
                this.items.findIndex((item, idx) => item.product_id === this.newItem.product_id && idx !== this.editingIndex) :
                this.items.findIndex(item => item.product_id === this.newItem.product_id);
                
            if (existingIndex !== -1) {
                const existingItem = this.items[existingIndex];
                const newQuantity = existingItem.quantity + this.newItem.quantity;
                
                if (newQuantity > this.newItem.stock) {
                    this.showNotification('La cantidad total excede el stock disponible', 'error');
                    return;
                }
                
                existingItem.quantity = newQuantity;
                existingItem.total = newQuantity * existingItem.unit_price;
            } else {
                this.items.push({
                    product_id: this.newItem.product_id,
                    product_name: this.newItem.product_name,
                    quantity: this.newItem.quantity,
                    unit_price: this.newItem.unit_price,
                    total: this.newItem.total
                });
            }

            // Reset form
            this.resetForm();
        },

        editItem(index) {
            const item = this.items[index];
            const product = this.products.find(p => p.id === item.product_id);

            if (product) {
                // Calculate available stock (current stock + quantity of this item)
                const existingItemIndex = this.items.findIndex((itm, idx) => itm.product_id === item.product_id && idx !== index);
                const existingItem = existingItemIndex !== -1 ? this.items[existingItemIndex] : null;
                const currentStock = existingItem ?
                    product.stock + existingItem.quantity :
                    product.stock + item.quantity;
                
                this.editingIndex = index;
                this.newItem = {
                    product_id: item.product_id,
                    product_name: item.product_name,
                    quantity: item.quantity,
                    unit_price: item.unit_price,
                    stock: currentStock,
                    total: item.total
                };
                
                // Scroll to form
                document.querySelector('[x-data="saleProducts()"]').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },

        updateItem() {
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

            if (this.editingIndex !== null) {
                // Check if product changed and already exists in other items
                const originalItem = this.items[this.editingIndex];
                const productChanged = originalItem.product_id !== this.newItem.product_id;

                if (productChanged) {
                    const existingIndex = this.items.findIndex((item, idx) =>
                        item.product_id === this.newItem.product_id && idx !== this.editingIndex
                    );

                    if (existingIndex !== -1) {
                        this.showNotification('Este producto ya está en la lista', 'error');
                        return;
                    }
                }

                // Update the item
                this.items[this.editingIndex] = {
                    product_id: this.newItem.product_id,
                    product_name: this.newItem.product_name,
                    quantity: this.newItem.quantity,
                    unit_price: this.newItem.unit_price,
                    total: this.newItem.total
                };

                this.showNotification('Producto actualizado correctamente', 'success');
                this.resetForm();
            }
        },

        cancelEdit() {
            this.resetForm();
        },

        resetForm() {
            this.editingIndex = null;
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

document.addEventListener('DOMContentLoaded', function() {
    const saleForm = document.getElementById('sale-form');
    if (saleForm) {
        saleForm.addEventListener('submit', function(e) {
            const items = document.querySelectorAll('input[name^="items["]');
            if (items.length === 0) {
                e.preventDefault();
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg bg-red-100 text-red-800 border-2 border-red-200';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="text-sm font-medium">Debe agregar al menos un producto a la venta</span>
                    </div>
                `;
                document.body.appendChild(notification);
                setTimeout(() => {
                    notification.style.transition = 'opacity 0.3s ease-out';
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
                return false;
            }
        });
    }
});
</script>
@endpush
@endsection
