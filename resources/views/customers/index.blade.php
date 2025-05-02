@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        @if ($customers->isEmpty())
            <x-empty title="No se encontraron clientes"
                message="Intenta ajustar tu búsqueda o filtro para encontrar lo que buscas."
                button_label="{{ __('Agregar tu primer Cliente') }}" button_route="{{ route('customers.create') }}" />
        @else
            <div class="container-xl">
                <x-alert />

                {{-- -
            <div class="card">
                <div class="card-body">
                    <livewire:power-grid.customers-table/>
                </div>
            </div>
            - --}}

                @livewire('tables.customer-table')
            </div>
        @endif
    </div>
@endsection
