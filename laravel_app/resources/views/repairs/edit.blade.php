@extends('layouts.app')

@section('title', 'Editar Reparación')
@section('header', 'Editar Reparación')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="mr-3 p-2 rounded-lg bg-orange-50 border border-orange-100">
                    <i class="fas fa-edit text-orange-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Editar Reparación #{{ $repair->id }}</h3>
                    <p class="text-sm text-gray-500">Modifica la información de la reparación</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('repairs.update', $repair) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
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
                    <select id="customer_id" name="customer_id" 
                            class="form-input @error('customer_id') border-red-300 @enderror" required>
                        <option value="">Seleccionar cliente</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" 
                                {{ old('customer_id', $repair->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} - {{ $customer->phone ?? 'Sin teléfono' }}
                            </option>
                        @endforeach
                    </select>
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
                        <option value="pending" {{ old('repair_status', $repair->repair_status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_progress" {{ old('repair_status', $repair->repair_status) == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completed" {{ old('repair_status', $repair->repair_status) == 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="delivered" {{ old('repair_status', $repair->repair_status) == 'delivered' ? 'selected' : '' }}>Entregado</option>
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
                    <input type="text" id="phone_model" name="phone_model" value="{{ old('phone_model', $repair->phone_model) }}" 
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
                    <input type="text" id="imei" name="imei" value="{{ old('imei', $repair->imei) }}" 
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
                        <input type="number" id="repair_cost" name="repair_cost" value="{{ old('repair_cost', $repair->repair_cost) }}" 
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
                    <input type="date" id="repair_date" name="repair_date" value="{{ old('repair_date', $repair->repair_date->format('Y-m-d')) }}" 
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
                              placeholder="Describe detalladamente el problema del dispositivo">{{ old('issue_description', $repair->issue_description) }}</textarea>
                    @error('issue_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notas adicionales -->
                <div class="md:col-span-2">
                    <label for="notes" class="form-label">Notas adicionales</label>
                    <textarea id="notes" name="notes" rows="3" 
                              class="form-input @error('notes') border-red-300 @enderror" 
                              placeholder="Notas adicionales, observaciones o comentarios">{{ old('notes', $repair->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Información adicional -->
                <div class="md:col-span-2">
                    <h4 class="text-md font-medium text-gray-900 mb-4 mt-6">Información adicional</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <dt class="font-medium text-gray-500">ID de la reparación</dt>
                                <dd class="text-gray-900">#{{ $repair->id }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Fecha de creación</dt>
                                <dd class="text-gray-900">{{ $repair->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            @if($repair->updated_at != $repair->created_at)
                            <div>
                                <dt class="font-medium text-gray-500">Última actualización</dt>
                                <dd class="text-gray-900">{{ $repair->updated_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('repairs.show', $repair) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar Reparación
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
