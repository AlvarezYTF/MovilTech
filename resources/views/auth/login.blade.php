@extends('layouts.auth')

@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">
                Iniciar sesión en tu cuenta
            </h2>
            <form action="{{ route('login') }}" method="POST" autocomplete="off">
                @csrf

                <x-input name="email" :value="old('email')" placeholder="tu@email.com" required="true" />

                <x-input type="password" name="password" placeholder="Tu contraseña" required="true" />

                <div class="mb-2">
                    <label for="remember" class="form-check">
                        <input type="checkbox" id="remember" name="remember" class="form-check-input" />
                        <span class="form-check-label">Recordarme en este dispositivo</span>
                    </label>
                </div>

                <div class="form-footer">
                    <x-button type="submit" class="w-100">
                        {{ __('Sign in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-3 text-gray-600">
        <p>¿Aún no tienes una cuenta?
            <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700 focus:outline-none focus:underline"
                tabindex="-1">
                Registrarse
            </a>
        </p>

        <p class="mt-2">
            <a href="{{ route('password.request') }}"
                class="text-sm text-gray-500 hover:text-gray-700 focus:outline-none focus:underline">
                Olvidé mi contraseña
            </a>
        </p>
    </div>
@endsection
