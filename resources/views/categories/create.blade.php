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
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="card-body">
                        <livewire:name />

                        <livewire:slug />
                    </div>

                    <div class="card-footer text-end">
                        <x-button.save type="submit">
                            {{ __('Guardar') }}
                        </x-button.save>

                        <x-button.back route="{{ route('categories.index') }}">
                            {{ __('Cancelar') }}
                        </x-button.back>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
