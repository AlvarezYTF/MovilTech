@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        @if ($products->isEmpty())
            <x-empty title="No se encontraron productos"
                message="Intenta ajustar tu búsqueda o filtro para encontrar lo que estás buscando."
                button_label="{{ __('Agregar tu primer Producto') }}" button_route="{{ route('products.create') }}" />
        @else
            <div class="container container-xl">
                <x-alert />

                @livewire('tables.product-table')
            </div>
        @endif
    </div>
@endsection
