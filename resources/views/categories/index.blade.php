@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        @if ($categories->isEmpty())
            <x-empty title="No se encontraron categorías"
                message="Intenta ajustar tu búsqueda o filtro para encontrar lo que estás buscando."
                button_label="{{ __('Agregar tu primera Categoría') }}" button_route="{{ route('categories.create') }}" />
        @else
            <div class="container-xl">
                <x-alert />

                @livewire('tables.category-table')
            </div>
        @endif
    </div>
@endsection
