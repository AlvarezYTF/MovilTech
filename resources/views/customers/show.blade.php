@extends('layouts.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl mb-3">
            <div class="row g-2 align-items-center mb-3">
                <div class="col">
                    <h2 class="page-title">
                        {{ $customer->name }}
                    </h2>
                </div>
            </div>

            @include('partials._breadcrumbs', ['model' => $customer])
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">
                                    {{ __('Imagen de Perfil') }}
                                </h3>

                                <img class="img-account-profile mb-2"
                                    src="{{ asset('assets/img/demo/user-placeholder.svg') }}" id="image-preview">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ __('Detalles del Cliente') }}
                                </h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                                    <tbody>
                                        <tr>
                                            <td>{{ __('Nombre') }}</td>
                                            <td>{{ $customer->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Correo Electrónico') }}</td>
                                            <td>{{ $customer->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Número de Teléfono') }}</td>
                                            <td>{{ $customer->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Dirección') }}</td>
                                            <td>{{ $customer->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Titular de la Cuenta') }}</td>
                                            <td>{{ $customer->account_holder }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Número de Cuenta') }}</td>
                                            <td>{{ $customer->account_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Nombre del Banco') }}</td>
                                            <td>{{ $customer->bank_name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer text-end">
                                <x-button.edit route="{{ route('customers.edit', $customer) }}">
                                    {{ __('Editar') }}
                                </x-button.edit>

                                <x-button.back route="{{ route('customers.index') }}">
                                    {{ __('Cancelar') }}
                                </x-button.back>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
