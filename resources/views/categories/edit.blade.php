@extends('layouts.app')

@section('title', 'Editar Categoría')
@section('header', 'Editar Categoría')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header mejorado con gradiente -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
            <div class="flex items-center">
                <div class="mr-4 p-3 rounded-lg bg-indigo-100 border border-indigo-200">
                    <i class="fas fa-edit text-indigo-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Editar Categoría</h3>
                    <p class="text-sm text-gray-600 mt-1">Modifica la información y personalización de "{{ $category->name }}"</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('categories.update', $category) }}" class="p-6 space-y-8" id="category-form">
            @csrf
            @method('PUT')
            
            <!-- Sección 1: Información Básica -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-info text-blue-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Información Básica</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-11">
                    <!-- Nombre -->
                    <div class="md:col-span-2">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag mr-2 text-gray-400"></i>
                            Nombre de la categoría <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $category->name) }}"
                               class="form-input @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" 
                               placeholder="Ej: Smartphones, Accesorios, Reparaciones..."
                               required>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Nombre descriptivo que identifique el tipo de productos
                        </p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Descripción -->
                    <div class="md:col-span-2">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left mr-2 text-gray-400"></i>
                            Descripción
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="form-input @error('description') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" 
                                  placeholder="Descripción opcional de la categoría...">{{ old('description', $category->description) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Información adicional sobre qué productos incluye esta categoría
                        </p>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección 2: Personalización Visual -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-palette text-purple-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Personalización Visual</h4>
                </div>
                
                <div class="pl-11">
                    <!-- Selector de color mejorado -->
                    <div class="space-y-4">
                        <label for="color" class="form-label">
                            <i class="fas fa-paint-brush mr-2 text-gray-400"></i>
                            Color de la categoría <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- Colores predefinidos -->
                        <div class="space-y-3">
                            <p class="text-sm text-gray-600">Colores sugeridos:</p>
                            <div class="grid grid-cols-6 gap-3">
                                <button type="button" class="color-option h-12 w-12 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition-colors" data-color="#3B82F6" style="background-color: #3B82F6;" title="Azul"></button>
                                <button type="button" class="color-option h-12 w-12 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition-colors" data-color="#10B981" style="background-color: #10B981;" title="Verde"></button>
                                <button type="button" class="color-option h-12 w-12 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition-colors" data-color="#F59E0B" style="background-color: #F59E0B;" title="Amarillo"></button>
                                <button type="button" class="color-option h-12 w-12 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition-colors" data-color="#EF4444" style="background-color: #EF4444;" title="Rojo"></button>
                                <button type="button" class="color-option h-12 w-12 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition-colors" data-color="#8B5CF6" style="background-color: #8B5CF6;" title="Púrpura"></button>
                                <button type="button" class="color-option h-12 w-12 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition-colors" data-color="#EC4899" style="background-color: #EC4899;" title="Rosa"></button>
                            </div>
                        </div>
                        
                        <!-- Selector personalizado -->
                        <div class="flex items-center space-x-3">
                            <input type="color" 
                                   id="color" 
                                   name="color" 
                                   value="{{ old('color', $category->color) }}"
                                   class="h-12 w-16 rounded-lg border-2 border-gray-300 cursor-pointer @error('color') border-red-300 @enderror">
                            <input type="text" 
                                   id="color_text" 
                                   value="{{ old('color', $category->color) }}"
                                   class="form-input flex-1 @error('color') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                   placeholder="#3B82F6"
                                   pattern="^#[0-9A-Fa-f]{6}$"
                                   required>
                        </div>
                        
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            El color se usará para identificar la categoría en listas y formularios
                        </p>
                        @error('color')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección 3: Configuración -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-cog text-green-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Configuración</h4>
                </div>
                
                <div class="pl-11">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                   class="form-checkbox h-5 w-5 text-green-600 transition duration-150 ease-in-out border-2 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                            <span class="ml-3 text-sm font-medium text-gray-700">Categoría activa</span>
                        </label>
                        <p class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Las categorías inactivas no aparecerán en los formularios de productos
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Vista previa mejorada -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-eye text-gray-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Vista Previa</h4>
                </div>
                
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center space-x-4">
                        <div class="h-12 w-12 rounded-xl flex items-center justify-center shadow-sm border border-gray-200" 
                             id="preview-icon" 
                             data-bg-color="{{ old('color', $category->color) ?: '#3B82F6' }}">
                            <i class="fas fa-tag text-lg" data-color="{{ old('color', $category->color) ?: '#3B82F6' }}"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-lg font-semibold text-gray-900" id="preview-name">{{ old('name', $category->name) }}</div>
                            <div class="text-sm text-gray-600" id="preview-description">{{ old('description', $category->description) ?: 'Sin descripción' }}</div>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" 
                                      id="preview-badge" 
                                      data-bg-color="{{ old('color', $category->color) ?: '#3B82F6' }}"
                                      data-text-color="{{ old('color', $category->color) ?: '#3B82F6' }}">
                                    <i class="fas fa-circle mr-1" data-color="{{ old('color', $category->color) ?: '#3B82F6' }}"></i>
                                    Categoría activa
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Información del Sistema -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-info-circle text-gray-600 text-sm"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Información del Sistema</h4>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-hashtag text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">ID de la Categoría</div>
                                    <div class="text-lg font-semibold text-gray-900">#{{ $category->id }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-boxes text-green-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Productos Asociados</div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $category->products->count() }} productos</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-calendar-plus text-purple-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Fecha de Creación</div>
                                    <div class="text-sm text-gray-900">{{ $category->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-lg bg-orange-100 flex items-center justify-center">
                                    <i class="fas fa-calendar-edit text-orange-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Última Actualización</div>
                                    <div class="text-sm text-gray-900">{{ $category->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones mejorados -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Los campos marcados con <span class="text-red-500">*</span> son obligatorios
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('categories.index') }}" 
                       class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Categoría
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorInput = document.getElementById('color');
    const colorText = document.getElementById('color_text');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const isActiveCheckbox = document.querySelector('input[name="is_active"]');
    const previewIcon = document.getElementById('preview-icon');
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    const previewBadge = document.getElementById('preview-badge');
    const colorOptions = document.querySelectorAll('.color-option');
    
    // Inicializar selección de color actual
    const currentColor = colorText.value;
    updateColorSelection(currentColor);
    
    // Manejar colores predefinidos
    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            const color = this.getAttribute('data-color');
            colorInput.value = color;
            colorText.value = color;
            
            // Actualizar selección visual
            colorOptions.forEach(opt => opt.classList.remove('ring-2', 'ring-blue-500'));
            this.classList.add('ring-2', 'ring-blue-500');
            
            updatePreview();
        });
    });
    
    // Sincronizar color picker con input de texto
    colorInput.addEventListener('input', function() {
        colorText.value = this.value;
        updateColorSelection(this.value);
        updatePreview();
    });
    
    colorText.addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            colorInput.value = this.value;
            updateColorSelection(this.value);
            updatePreview();
        }
    });
    
    // Actualizar selección de color predefinido
    function updateColorSelection(color) {
        colorOptions.forEach(option => {
            if (option.getAttribute('data-color') === color) {
                option.classList.add('ring-2', 'ring-blue-500');
            } else {
                option.classList.remove('ring-2', 'ring-blue-500');
            }
        });
    }
    
    // Actualizar vista previa
    function updatePreview() {
        const color = colorText.value;
        const name = nameInput.value || 'Nombre de la categoría';
        const description = descriptionInput.value || 'Sin descripción';
        const isActive = isActiveCheckbox.checked;
        
        // Actualizar icono y colores
        previewIcon.style.backgroundColor = color + '20';
        previewIcon.querySelector('i').style.color = color;
        
        // Actualizar texto
        previewName.textContent = name;
        previewDescription.textContent = description;
        
        // Actualizar badge de estado
        if (isActive) {
            previewBadge.style.backgroundColor = color + '20';
            previewBadge.style.color = color;
            previewBadge.querySelector('i').style.color = color;
            previewBadge.innerHTML = '<i class="fas fa-circle mr-1"></i>Categoría activa';
        } else {
            previewBadge.style.backgroundColor = '#6B728020';
            previewBadge.style.color = '#6B7280';
            previewBadge.querySelector('i').style.color = '#6B7280';
            previewBadge.innerHTML = '<i class="fas fa-pause-circle mr-1"></i>Categoría inactiva';
        }
    }
    
    // Aplicar colores iniciales desde data attributes
    function applyInitialColors() {
        const bgColor = previewIcon.getAttribute('data-bg-color');
        const textColor = previewIcon.querySelector('i').getAttribute('data-color');
        const badgeBgColor = previewBadge.getAttribute('data-bg-color');
        const badgeTextColor = previewBadge.getAttribute('data-text-color');
        const badgeIconColor = previewBadge.querySelector('i').getAttribute('data-color');
        
        if (bgColor) {
            previewIcon.style.backgroundColor = bgColor + '20';
        }
        if (textColor) {
            previewIcon.querySelector('i').style.color = textColor;
        }
        if (badgeBgColor) {
            previewBadge.style.backgroundColor = badgeBgColor + '20';
        }
        if (badgeTextColor) {
            previewBadge.style.color = badgeTextColor;
        }
        if (badgeIconColor) {
            previewBadge.querySelector('i').style.color = badgeIconColor;
        }
    }
    
    // Actualizar vista previa cuando cambien los inputs
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    isActiveCheckbox.addEventListener('change', updatePreview);
    
    // Validación en tiempo real
    nameInput.addEventListener('blur', function() {
        if (this.value.trim().length < 2) {
            this.classList.add('border-red-300');
        } else {
            this.classList.remove('border-red-300');
        }
    });
    
    colorText.addEventListener('blur', function() {
        if (!/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            this.classList.add('border-red-300');
        } else {
            this.classList.remove('border-red-300');
        }
    });
    
    // Efectos visuales para los campos
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-blue-200', 'ring-opacity-50');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-blue-200', 'ring-opacity-50');
        });
    });
    
    // Animación de entrada para la vista previa
    const previewContainer = document.querySelector('.bg-gradient-to-r.from-gray-50.to-gray-100');
    previewContainer.style.opacity = '0';
    previewContainer.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        previewContainer.style.transition = 'all 0.5s ease-out';
        previewContainer.style.opacity = '1';
        previewContainer.style.transform = 'translateY(0)';
    }, 300);
    
    // Animación de entrada para la información del sistema
    const systemInfoContainer = document.querySelector('.bg-gray-50.rounded-lg.p-6.border.border-gray-200');
    systemInfoContainer.style.opacity = '0';
    systemInfoContainer.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        systemInfoContainer.style.transition = 'all 0.5s ease-out';
        systemInfoContainer.style.opacity = '1';
        systemInfoContainer.style.transform = 'translateY(0)';
    }, 500);
    
    // Aplicar colores iniciales
    applyInitialColors();
    
    // Inicializar vista previa
    updatePreview();
    
    // Mostrar mensaje de confirmación si hay cambios
    let hasChanges = false;
    const originalValues = {
        name: nameInput.value,
        description: descriptionInput.value,
        color: colorText.value,
        isActive: isActiveCheckbox.checked
    };
    
    function checkForChanges() {
        hasChanges = (
            nameInput.value !== originalValues.name ||
            descriptionInput.value !== originalValues.description ||
            colorText.value !== originalValues.color ||
            isActiveCheckbox.checked !== originalValues.isActive
        );
    }
    
    // Verificar cambios en los inputs
    nameInput.addEventListener('input', checkForChanges);
    descriptionInput.addEventListener('input', checkForChanges);
    colorText.addEventListener('input', checkForChanges);
    isActiveCheckbox.addEventListener('change', checkForChanges);
    
    // Mostrar advertencia si hay cambios sin guardar
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = 'Tienes cambios sin guardar. ¿Estás seguro de que quieres salir?';
        }
    });
});
</script>
@endpush
@endsection
