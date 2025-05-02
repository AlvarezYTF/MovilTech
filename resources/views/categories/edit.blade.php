@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">
                            {{ __('Detalles de la Categoría') }}
                        </h3>
                    </div>

                    <div class="card-actions">
                        <x-action.close route="{{ route('categories.index') }}" />
                    </div>
                </div>
                <form action="{{ route('categories.update', $category->slug) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <x-input label="{{ __('Nombre') }}" id="name" name="name" :value="old('name', $category->name)" required />

                        <x-input label="{{ __('URL amigable') }}" id="slug" name="slug" :value="old('slug', $category->slug)" required />
                    </div>
                    <div class="card-footer text-end">
                        <x-button type="submit">
                            {{ __('Actualizar') }}
                        </x-button>

                        <x-button.back route="{{ route('categories.index') }}">
                            {{ __('Cancelar') }}
                        </x-button.back>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@pushonce('page-scripts')
    <script>
        // Generador de Slug
        const title = document.querySelector("#name");
        const slug = document.querySelector("#slug");
        title.addEventListener("keyup", function() {
            let preslug = title.value;
            preslug = preslug.replace(/ /g, "-");
            slug.value = preslug.toLowerCase();
        });
    </script>
@endpushonce
