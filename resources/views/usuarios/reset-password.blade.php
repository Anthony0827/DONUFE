@extends('components.layouts.default')

@section('content')

<section class="overflow-hidden flex justify-center items-center min-h-screen w-screen text-gray-500 bg-kulture-color-cuatro">
    <div class="flex flex-col justify-center w-11/12 max-w-lg my-5 p-6 rounded-3xl bg-white shadow-lg md:w-5/6 md:mx-10 md:my-8">
        <h1 class="text-2xl font-semibold text-kulture-color-cuatro mb-6 text-center">Restablecimiento de contraseña</h1>
        
        <form action="{{ route('usuarios.password.update') }}" method="POST" class="flex flex-col items-center">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-6 w-4/5">
                <label for="email" class="block text-sm font-medium text-gray-700 text-center mb-2">Correo electrónico</label>
                <input type="email" name="email" id="email" 
                       class="form-input w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-kulture-color-cuatro focus:border-kulture-color-cuatro"
                       required>
            </div>
            
            <div class="mb-6 w-4/5">
                <label for="password" class="block text-sm font-medium text-gray-700 text-center mb-2">Nueva contraseña</label>
                <input type="password" name="password" id="password" 
                       class="form-input w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-kulture-color-cuatro focus:border-kulture-color-cuatro"
                       required>
            </div>
            
            <div class="mb-6 w-4/5">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 text-center mb-2">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       class="form-input w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-kulture-color-cuatro focus:border-kulture-color-cuatro"
                       required>
            </div>
            
            <div class="mt-8 w-4/5"> <!-- Aumenté el margen superior aquí -->
                <button type="submit" 
                        class="w-full px-6 py-3 rounded-lg bg-kulture-green text-white shadow-md hover:bg-green-600 hover:shadow-lg text-center transition">
                    Restablecer contraseña
                </button>
            </div>
        </form>
        
    </div>
</section>

@endsection
