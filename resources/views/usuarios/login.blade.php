@extends('components.layouts.default')

@section('title', 'Inicio de sesión | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Define esta variable para ocultar el navbar y menú
@endphp

@section('content')

<section class="flex items-center justify-center w-screen text-gray-500 min-h-full-no-header bg-kulture-color-cuatro rounded-tl-4xl">
    <div class="flex flex-col items-center justify-center w-11/12 max-w-full my-5 bg-white main-container rounded-3xl md:w-5/6 md:mx-10 md:my-8 low-dpi:h-md md:h-2xl">
         @if (session('status'))
            <div class="w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center">
                {{ session('status') }}
            </div>
        @endif
        <div class="relative flex flex-col max-w-screen-xl gap-0 m-8 space-y-16 overflow-auto lg:flex-row lg:space-y-0 lg:w-5/6 scrollbar scrollbar-firefox sm:px-8 lg:px-6 lg:gap-32 low-dpi:mx-10 lg:mx-8">
          
   
            <div id="login" class="top-0 lg:sticky lg:w-1/2">
                <p class="text-2xl text-kulture-color-cuatro">Inicio de sesión</p>
                <form action="{{ route('usuarios.authenticate') }}" method="POST" class="w-full px-1 my-4">
                    @csrf
                    <!-- Email -->
                    <div class="mb-3">
                        <input type="text" name="email" class="w-full border-none rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" placeholder="Usuario" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <hr class="border border-gray-300">
                    </div>
                    <!-- Password -->
                    <div id="cpsw1" class="mt-3 mb-4 border-bottom">
                        <input type="password" name="clave" class="w-full border-none rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" placeholder="Contraseña" value="{{ old('clave') }}" required>
                        @error('clave')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <hr class="border border-gray-300">
                    </div>
                    <!-- Button -->
                    <div class="mt-8 mb-6 md:mb-4">
                        <button type="submit" class="flex justify-center items-center w-full px-7 py-2.5 rounded-lg bg-kulture-color-cuatro text-white shadow-md hover:text-kulture-color-cuatro hover:bg-white hover:shadow-gray-400 transform transition">
                            <i class="mr-3 text-2xl md:text-base bi bi-envelope"></i> Login
                        </button>
                    </div>
                    <!-- Password retrieval -->
                    <div>
                        <i class="text-kulture-color-cuatro bi bi-unlock"></i>
                        <a href="#" class="text-kulture-color-cuatro hover:border-b hover:border-b-kulture-color-cuatro" data-bs-toggle="modal" data-bs-target="#passwordResetModal">
                            Recordar contraseña
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Modal para Recuperación de Contraseña -->
<div class="modal fade" id="passwordResetModal" tabindex="-1" aria-labelledby="passwordResetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-kulture-color-cuatro" id="passwordResetModalLabel">Recuperación de contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Para recuperar la contraseña, introduce el correo electrónico asociado a la cuenta de Kulture.<br>
                   Si no encuentras el email, revisa la carpeta de correo no deseado o spam.
                </p>
                <form id="passwordResetForm" action="{{ route('usuarios.password.email') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <button type="submit" class="w-full lg:w-fit px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md hover:bg-green-100 hover:text-kulture-green">Recuperar contraseña</button>

                     
                </form>
                <!-- Mensajes de éxito o error -->
                @if (session('status'))
                    <p class="text-green-500 text-sm mt-3">{{ session('status') }}</p>
                @endif
                @error('email')
                    <p class="text-red-500 text-sm mt-3">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Scripts para Bootstrap -->
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
    function loadContent(url, hideMenu = false) {
        // Oculta o muestra el menú según el valor de hideMenu
        if (hideMenu) {
            $('.menu-container').addClass('hidden');
        } else {
            $('.menu-container').removeClass('hidden');
        }

        // Carga el contenido dinámicamente
        $.get(url, function(data) {
            $('#content-container').html(data);
        }).fail(function() {
            $('#content-container').html('<p>Error al cargar el contenido. Inténtalo nuevamente.</p>');
        });
    }
</script>
@endsection