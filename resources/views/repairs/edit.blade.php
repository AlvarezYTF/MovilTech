@extends('layouts.app')

@section('title', 'Editar Reparación')
@section('header', 'Editar Reparación')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('repairs.update', $repair) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cliente -->
                <div>
                    <label for="customer_id" class="form-label">Cliente *</label>
                    <select id="customer_id" name="customer_id" 
                            class="form-input @error('customer_id') border-red-500 @enderror" required>
                        <option value="">Seleccionar cliente</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" 
                                {{ old('customer_id', $repair->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} - {{ $customer->phone ?? 'Sin teléfono' }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Modelo del teléfono -->
                <div>
                    <label for="phone_model" class="form-label">Modelo del Teléfono *</label>
                    <input type="text" id="phone_model" name="phone_model" value="{{ old('phone_model', $repair->phone_model) }}" 
                           class="form-input @error('phone_model') border-red-500 @enderror" 
                           placeholder="Ej: iPhone 12, Samsung Galaxy S21" required>
                    @error('phone_model')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IMEI -->
                <div>
                    <label for="imei" class="form-label">IMEI *</label>
                    <input type="text" id="imei" name="imei" value="{{ old('imei', $repair->imei) }}" 
                           class="form-input @error('imei') border-red-500 @enderror" 
                           placeholder="Número IMEI del dispositivo" required>
                    @error('imei')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado de la reparación -->
                <div>
                    <label for="repair_status" class="form-label">Estado de la Reparación *</label>
                    <select id="repair_status" name="repair_status" 
                            class="form-input @error('repair_status') border-red-500 @enderror" required>
                        <option value="pending" {{ old('repair_status', $repair->repair_status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_progress" {{ old('repair_status', $repair->repair_status) == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completed" {{ old('repair_status', $repair->repair_status) == 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="delivered" {{ old('repair_status', $repair->repair_status) == 'delivered' ? 'selected' : '' }}>Entregado</option>
                    </select>
                    @error('repair_status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Costo de la reparación -->
                <div>
                    <label for="repair_cost" class="form-label">Costo de la Reparación *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" id="repair_cost" name="repair_cost" value="{{ old('repair_cost', $repair->repair_cost) }}" 
                               class="form-input pl-8 @error('repair_cost') border-red-500 @enderror" 
                               step="0.01" min="0" placeholder="0.00" required>
                    </div>
                    @error('repair_cost')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha de la reparación -->
                <div>
                    <label for="repair_date" class="form-label">Fecha de la Reparación *</label>
                    <input type="date" id="repair_date" name="repair_date" value="{{ old('repair_date', $repair->repair_date->format('Y-m-d')) }}" 
                           class="form-input @error('repair_date') border-red-500 @enderror" required>
                    @error('repair_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción del problema -->
                <div class="col-span-2">
                    <label for="issue_description" class="form-label">Descripción del Problema *</label>
                    <textarea id="issue_description" name="issue_description" rows="4" 
                              class="form-input @error('issue_description') border-red-500 @enderror" 
                              placeholder="Describe detalladamente el problema del dispositivo">{{ old('issue_description', $repair->issue_description) }}</textarea>
                    @error('issue_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notas adicionales -->
                <div class="col-span-2">
                    <label for="notes" class="form-label">Notas Adicionales</label>
                    <textarea id="notes" name="notes" rows="3" 
                              class="form-input @error('notes') border-red-500 @enderror" 
                              placeholder="Notas adicionales, observaciones o comentarios">{{ old('notes', $repair->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('repairs.show', $repair) }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar Reparación
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
