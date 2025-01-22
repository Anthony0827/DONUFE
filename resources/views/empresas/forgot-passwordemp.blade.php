@extends('components.layouts.default')

@section('content')
<section class="flex justify-center items-center min-h-screen bg-kulture-color-cuatro">
    <div class="w-11/12 max-w-md bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-kulture-color-cuatro mb-4">Recuperar contraseña</h1>
        <form action="{{ route('empresas.password.email') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-input mt-1 block w-full" required>
            </div>
            @if (session('status'))
                <p class="text-green-500 text-sm">{{ session('status') }}</p>
            @endif
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full bg-kulture-color-cuatro text-white py-2 px-4 rounded-md mt-4">
                Enviar enlace de recuperación
            </button>
        </form>
    </div>
</section>
@endsection
