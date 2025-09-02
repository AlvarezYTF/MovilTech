@extends('layouts.app')

@section('title', 'Nueva Categoría')
@section('header', 'Crear Nueva Categoría')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="mr-3 p-2 rounded-lg bg-blue-50 border border-blue-100">
                    <i class="fas fa-plus text-blue-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Nueva Categoría</h3>
                    <p class="text-sm text-gray-500">Completa la información para crear una nueva categoría</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('categories.store') }}" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="md:col-span-2">
                    <label for="name" class="form-label">
                        Nombre de la categoría <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="form-input @error('name') border-red-300 @enderror" 
                           placeholder="Ej: Smartphones, Accesorios, Reparaciones..."
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="form-input @error('description') border-red-300 @enderror" 
                              placeholder="Descripción opcional de la categoría...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Color -->
                <div>
                    <label for="color" class="form-label">
                        Color <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-3">
                        <input type="color" 
                               id="color" 
                               name="color" 
                               value="{{ old('color', '#3B82F6') }}"
                               class="h-10 w-16 rounded border border-gray-300 cursor-pointer @error('color') border-red-300 @enderror">
                        <input type="text" 
                               id="color_text" 
                               value="{{ old('color', '#3B82F6') }}"
                               class="form-input flex-1 @error('color') border-red-300 @enderror" 
                               placeholder="#3B82F6"
                               pattern="^#[0-9A-Fa-f]{6}$"
                               required>
                    </div>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Selecciona un color para identificar la categoría</p>
                </div>
                
                <!-- Estado -->
                <div>
                    <label class="form-label">Estado</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
                            <span class="ml-2 text-sm text-gray-700">Categoría activa</span>
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Las categorías inactivas no aparecerán en los formularios</p>
                </div>
            </div>
            
            <!-- Vista previa -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Vista previa</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-lg flex items-center justify-center mr-3" 
                             id="preview-icon" 
                             style="background-color: #3B82F620;">
                            <i class="fas fa-tag text-sm" style="color: #3B82F6;"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900" id="preview-name">Nombre de la categoría</div>
                            <div class="text-xs text-gray-500" id="preview-description">Descripción de la categoría</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Crear Categoría
                </button>
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
    const previewIcon = document.getElementById('preview-icon');
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    
    // Sincronizar color picker con input de texto
    colorInput.addEventListener('input', function() {
        colorText.value = this.value;
        updatePreview();
    });
    
    colorText.addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            colorInput.value = this.value;
            updatePreview();
        }
    });
    
    // Actualizar vista previa
    function updatePreview() {
        const color = colorText.value;
        const name = nameInput.value || 'Nombre de la categoría';
        const description = descriptionInput.value || 'Descripción de la categoría';
        
        previewIcon.style.backgroundColor = color + '20';
        previewIcon.querySelector('i').style.color = color;
        previewName.textContent = name;
        previewDescription.textContent = description;
    }
    
    // Actualizar vista previa cuando cambien los inputs
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    
    // Inicializar vista previa
    updatePreview();
});
</script>
@endpush
@endsection
