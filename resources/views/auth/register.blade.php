@extends('layouts.auth')

@section('content')
    <form class="card card-md" action="{{ route('register') }}" method="POST" autocomplete="off">
        @csrf

        <div class="card-body">
            <h2 class="card-title text-center mb-4">Crear nueva cuenta</h2>

            <x-input name="name" :value="old('name')" placeholder="Tu nombre" required="true" />

            <x-input name="email" :value="old('email')" placeholder="tu@email.com" required="true" />

            <x-input name="username" :value="old('username')" placeholder="Tu usuario" required="true" />

            <x-input name="password" :value="old('password')" placeholder="Contraseña" required="true" />

            <x-input name="password_confirmation" :value="old('password_confirmation')" placeholder="Confirmar contraseña" required="true"
                label="Confirmación de Contraseña" />

            <div class="mb-3">
                <label class="form-check">
                    <input type="checkbox" name="terms-of-service" id="terms-of-service"
                        class="form-check-input @error('terms-of-service') is-invalid @enderror">
                    <span class="form-check-label">
                        Acepto los <a href="./terms-of-service.html" tabindex="-1">
                            términos y condiciones</a>.
                    </span>
                </label>
            </div>

            <div class="form-footer">
                <x-button type="submit" class="w-100">
                    {{ __('Crear nueva cuenta') }}
                </x-button>
            </div>
        </div>
    </form>

    <div class="text-center text-secondary mt-3">
        ¿Ya tienes una cuenta? <a href="{{ route('login') }}" tabindex="-1">
            Iniciar sesión
        </a>
    </div>
@endsection
