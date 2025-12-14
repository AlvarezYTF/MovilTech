@extends('layouts.app')

@section('title', 'Detalle de Reparación')
@section('header', 'Detalle de Reparación')

@section('content')
<div class="max-w-6xl mx-auto space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2.5 sm:p-3 rounded-xl bg-amber-50 text-amber-600">
                    <i class="fas fa-tools text-lg sm:text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Reparación #{{ $repair->id }}</h1>
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-2">
                        @if($repair->repair_status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                <i class="fas fa-clock mr-1.5"></i>
                                Pendiente
                            </span>
                        @elseif($repair->repair_status === 'in_progress')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                <i class="fas fa-tools mr-1.5"></i>
                                En Progreso
                            </span>
                        @elseif($repair->repair_status === 'completed')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                <i class="fas fa-check-circle mr-1.5"></i>
                                Completado
                            </span>
                        @elseif($repair->repair_status === 'delivered')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-violet-50 text-violet-700">
                                <i class="fas fa-handshake mr-1.5"></i>
                                Entregado
                            </span>
                        @endif
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-mobile-alt mr-1.5"></i>
                            {{ $repair->phone_model }}
                        </span>
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-dollar-sign mr-1.5"></i>
                            ${{ number_format($repair->repair_cost, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="{{ route('repairs.edit', $repair) }}"
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>

                <a href="{{ route('repairs.index') }}"
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-amber-600 bg-amber-600 text-white text-sm font-semibold hover:bg-amber-700 hover:border-amber-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 shadow-sm hover:shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Información principal de la reparación -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Información de la reparación -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                        <i class="fas fa-info-circle text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Información de la reparación</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                                <i class="fas fa-hashtag text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">ID de la Reparación</div>
                                <div class="text-base sm:text-lg font-bold text-gray-900">#{{ $repair->id }}</div>
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
                                    @if($repair->repair_status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                            <i class="fas fa-clock mr-1.5"></i>
                                            Pendiente
                                        </span>
                                    @elseif($repair->repair_status === 'in_progress')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                            <i class="fas fa-tools mr-1.5"></i>
                                            En Progreso
                                        </span>
                                    @elseif($repair->repair_status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                            <i class="fas fa-check-circle mr-1.5"></i>
                                            Completado
                                        </span>
                                    @elseif($repair->repair_status === 'delivered')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-violet-50 text-violet-700">
                                            <i class="fas fa-handshake mr-1.5"></i>
                                            Entregado
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shadow-sm">
                                <i class="fas fa-calendar-alt text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Fecha de Reparación</div>
                                <div class="text-sm font-semibold text-gray-900">{{ $repair->repair_date->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-sm">
                                <i class="fas fa-calendar-plus text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Fecha de Creación</div>
                                <div class="text-sm font-semibold text-gray-900">{{ $repair->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    @if($repair->updated_at != $repair->created_at)
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-gray-50 text-gray-600 flex items-center justify-center shadow-sm">
                                <i class="fas fa-calendar-edit text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Última Actualización</div>
                                <div class="text-sm font-semibold text-gray-900">{{ $repair->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shadow-sm">
                                <i class="fas fa-mobile-alt text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Modelo del Teléfono</div>
                                <div class="text-base sm:text-lg font-bold text-gray-900 truncate">{{ $repair->phone_model }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                                <i class="fas fa-fingerprint text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Número IMEI</div>
                                <div class="text-sm sm:text-base font-mono font-semibold text-gray-900 truncate">{{ $repair->imei }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descripción del problema -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-red-50 text-red-600">
                        <i class="fas fa-exclamation-triangle text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Descripción del problema</h2>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 sm:p-5 border border-gray-200">
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $repair->issue_description }}</p>
                </div>
            </div>

            <!-- Notas adicionales -->
            @if($repair->notes)
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-gray-50 text-gray-600">
                        <i class="fas fa-sticky-note text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Notas adicionales</h2>
                </div>
                <div class="bg-blue-50 rounded-xl p-4 sm:p-5 border border-blue-200">
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $repair->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Panel lateral -->
        <div class="space-y-4 sm:space-y-6">
            <!-- Resumen financiero -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                        <i class="fas fa-dollar-sign text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Resumen financiero</h2>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Costo de reparación</span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-amber-600">
                            ${{ number_format($repair->repair_cost, 2) }}
                        </div>
                    </div>

                    <div class="border-t-2 border-gray-200 pt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-base sm:text-lg font-semibold text-gray-900">Total</span>
                            <span class="text-xl sm:text-2xl font-bold text-amber-600">
                                ${{ number_format($repair->repair_cost, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del cliente -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                        <i class="fas fa-user text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Cliente</h2>
                </div>

                <div class="flex items-center mb-4 pb-4 border-b border-gray-200">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-sm font-semibold shadow-sm mr-3 flex-shrink-0">
                        {{ strtoupper(substr($repair->customer->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-base sm:text-lg font-semibold text-gray-900 truncate">{{ $repair->customer->name }}</div>
                        @if($repair->customer->phone)
                            <div class="text-xs sm:text-sm text-gray-500 truncate">{{ $repair->customer->phone }}</div>
                        @endif
                    </div>
                </div>

                <div class="space-y-3">
                    @if($repair->customer->email)
                    <div class="flex items-start space-x-3">
                        <div class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Email</div>
                            <a href="mailto:{{ $repair->customer->email }}" class="text-sm text-blue-600 hover:text-blue-700 truncate block">
                                {{ $repair->customer->email }}
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($repair->customer->address)
                    <div class="flex items-start space-x-3">
                        <div class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Dirección</div>
                            <div class="text-sm text-gray-900">{{ $repair->customer->address }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-6">
                    <div class="p-2 rounded-xl bg-gray-50 text-gray-600">
                        <i class="fas fa-bolt text-sm"></i>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Acciones rápidas</h2>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('repairs.edit', $repair) }}"
                       class="w-full inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-amber-600 bg-amber-600 text-white text-sm font-semibold hover:bg-amber-700 hover:border-amber-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 shadow-sm hover:shadow-md">
                        <i class="fas fa-edit mr-2"></i>
                        Editar reparación
                    </a>

                    <button type="button"
                            onclick="openDeleteModal({{ $repair->id }}, {{ json_encode($repair->phone_model) }}, {{ json_encode($repair->customer->name) }})"
                            class="w-full inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar reparación
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50" style="display: none;">
    <div class="relative top-10 sm:top-20 mx-auto p-4 sm:p-6 border w-11/12 sm:w-96 shadow-xl rounded-xl bg-white max-h-[90vh] overflow-y-auto">
        <div class="mt-3">
            <!-- Header del modal -->
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="p-2.5 rounded-xl bg-red-50 text-red-600">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900">Eliminar Reparación</h3>
                </div>
                <button type="button" onclick="closeDeleteModal()"
                        class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Contenido del modal -->
            <div class="mb-6">
                <p class="text-sm text-gray-600 mb-4">
                    ¿Estás seguro de que deseas eliminar esta reparación? Esta acción no se puede deshacer.
                </p>

                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 rounded-lg bg-red-100 text-red-600 flex-shrink-0">
                            <i class="fas fa-tools text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-900 mb-1" id="delete-repair-device"></div>
                            <div class="text-xs text-gray-600" id="delete-repair-customer"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <form id="delete-form" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeDeleteModal()"
                            class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 rounded-xl border-2 border-red-600 bg-red-600 text-white text-sm font-semibold hover:bg-red-700 hover:border-red-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm hover:shadow-md">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar Reparación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openDeleteModal(repairId, deviceModel, customerName) {
    const modal = document.getElementById('delete-modal');
    const form = document.getElementById('delete-form');
    const deviceElement = document.getElementById('delete-repair-device');
    const customerElement = document.getElementById('delete-repair-customer');

    // Establecer la acción del formulario
    form.action = '{{ route("repairs.destroy", ":id") }}'.replace(':id', repairId);

    // Establecer los datos de la reparación
    deviceElement.textContent = deviceModel;
    customerElement.textContent = 'Cliente: ' + customerName;

    // Mostrar el modal
    modal.classList.remove('hidden');
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal al hacer clic fuera
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Cerrar modal con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('delete-modal');
        if (!modal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    }
});
</script>
@endpush
@endsection
