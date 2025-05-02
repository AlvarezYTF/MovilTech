@extends('layouts.tabler')

@section('content')
<div class="page-body">
    @if($orders->isEmpty())
    <x-empty
        title="No hay órdenes"
        message="No hay órdenes registradas en el sistema."
        button_label="{{ __('Agrega tu primer orden') }}"
        button_route="{{ route('orders.create') }}"
    />
    @else
    <div class="container-xl">
        <x-alert/>

        <livewire:tables.order-table />
    </div>
    @endif
</div>
@endsection