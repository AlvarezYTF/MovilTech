@extends('layouts.app')

@section('title', 'Editar Reparación')
@section('header', 'Editar Reparación')

@section('content')
<div class="max-w-4xl mx-auto space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2.5 sm:p-3 rounded-xl bg-amber-50 text-amber-600">
                <i class="fas fa-edit text-lg sm:text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Editar Reparación #{{ $repair->id }}</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Modifica la información de la reparación</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('repairs.update', $repair) }}" id="repair-form" x-data="{ loading: false }" @submit="loading = true">
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
                        <select id="customer_id" name="customer_id"
                                class="block w-full pl-10 sm:pl-11 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent appearance-none bg-white transition-all @error('customer_id') border-red-300 focus:ring-red-500 @enderror"
                                required>
                            <option value="">Seleccionar cliente</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id', $repair->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}@if($customer->phone) - {{ $customer->phone }}@endif
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
                            <option value="pending" {{ old('repair_status', $repair->repair_status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="in_progress" {{ old('repair_status', $repair->repair_status) == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                            <option value="completed" {{ old('repair_status', $repair->repair_status) == 'completed' ? 'selected' : '' }}>Completado</option>
                            <option value="delivered" {{ old('repair_status', $repair->repair_status) == 'delivered' ? 'selected' : '' }}>Entregado</option>
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
                        <input type="text" id="phone_model" name="phone_model" value="{{ old('phone_model', $repair->phone_model) }}"
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
                        <input type="text" id="imei" name="imei" value="{{ old('imei', $repair->imei) }}"
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
                        <input type="number" id="repair_cost" name="repair_cost" value="{{ old('repair_cost', $repair->repair_cost) }}"
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
                        <input type="date" id="repair_date" name="repair_date" value="{{ old('repair_date', $repair->repair_date->format('Y-m-d')) }}"
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
                              required>{{ old('issue_description', $repair->issue_description) }}</textarea>
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
                              placeholder="Notas adicionales, observaciones o comentarios">{{ old('notes', $repair->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Información del sistema -->
        <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                <div class="p-2 rounded-xl bg-gray-50 text-gray-600">
                    <i class="fas fa-info-circle text-sm"></i>
                </div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información del sistema</h2>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 sm:p-5 border border-gray-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-sm">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">ID de la reparación</div>
                        <div class="text-sm font-semibold text-gray-900">#{{ $repair->id }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Fecha de creación</div>
                        <div class="text-sm text-gray-900">{{ $repair->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @if($repair->updated_at != $repair->created_at)
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Última actualización</div>
                        <div class="text-sm text-gray-900">{{ $repair->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
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
                <a href="{{ route('repairs.show', $repair) }}"
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
                    <span x-text="loading ? 'Procesando...' : 'Actualizar Reparación'">Actualizar Reparación</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
