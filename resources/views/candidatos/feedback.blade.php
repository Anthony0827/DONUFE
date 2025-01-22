@extends('components.layouts.default')

@section('title', 'Información | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Define esta variable para ocultar el navbar y menú
@endphp

@section('content')

<!-- vista Feedback -->

<section class="overflow-hidden flex justify-center items-center min-h-screen w-screen text-gray-500 bg-kulture-color-cuatro rounded-tl-4xl">
   <div id="content-container">
<section class="flex justify-center min-h-full-no-header items-center w-screen  text-gray-500 bg-kulture-color-cuatro rounded-tl-4xl">
        <div class="flex flex-col justify-center w-11/12 max-w-full my-5 rounded-3xl bg-white md:w-5/6 md:mx-10 md:my-8 md:min-h-1xl">
          <div class="m-8 md:mx-28 lg:mx-48">
                <div class="space-y-4">
                <!-- Encabezado -->
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-kulture-color-cuatro">Enviar Feedback</h2>
                </div>

                <!-- Contenedor para el mensaje de éxito -->
                <div id="success-message" class="alert alert-success flex justify-between items-center bg-green-100 text-green-800 rounded-lg px-4 py-2 hidden">
                    ¡Feedback enviado con éxito!
                    <button type="button" class="text-green-800 hover:text-green-600" onclick="hideSuccessMessage()" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <!-- Formulario -->
                <form id="feedbackForm" method="POST" class="w-full space-y-4" onsubmit="enviarFeedback(event)">
                    @csrf
                    <!-- Selección de motivo -->
                    <div class="form-group w-full md:w-1/3">
                        <label for="motivo" class="block text-sm font-medium text-gray-700">¿Qué quieres compartir?</label>
                        <select name="motivo" id="motivo" class="form-select border border-gray-300 w-full rounded-md text-kulture-color-cuatro focus:ring-kulture-color-cuatro hover:cursor-pointer" required>
                            <option value="">Seleccione una opción</option>
                            <option value="Información">Información</option>
                            <option value="Felicitación">Felicitación</option>
                            <option value="Sugerencia">Sugerencia</option>
                            <option value="Algo va mal">Algo va mal</option>
                        </select>
                        @error('motivo')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Comentario -->
                    <div class="form-group">
                        <label for="comentario" class="block text-sm font-medium text-gray-700">Comentarios:</label>
                        <textarea name="comentario" id="comentario" rows="4" class="form-textarea border border-gray-300 w-full rounded-md text-kulture-color-cuatro focus:ring-kulture-color-cuatro" placeholder="Escribe tu comentario aquí..." required></textarea>
                        @error('comentario')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Botón de enviar -->
                    <div class="text-right">
                        <button type="submit" class="px-7 py-2.5 w-full md:w-auto rounded-lg bg-kulture-green text-white shadow-md shadow-green-400 hover:bg-green-100 hover:text-kulture-green hover:shadow-none" id="btnActualizar" data-loading-text="Enviando...">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')

@endsection
