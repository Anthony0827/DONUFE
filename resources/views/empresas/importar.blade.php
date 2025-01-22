@extends('components.layouts.default')

@section('title', 'Información | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Define esta variable para ocultar el navbar y menú
@endphp

@section('content')

<section class="flex justify-center min-h-full-no-header items-center text-gray-500 bg-kulture-color-cuatro rounded-tl-4xl">
    <div class="main-container grid grid-cols-1 w-11/12 max-w-full my-5 rounded-3xl bg-white md:w-5/6 md:mx-10 md:my-8 low-dpi:h-md md:h-2xl">
        <div class="overflow-auto grid auto-rows-min content-between gap-6 scrollbar scrollbar-firefox m-8 low-dpi:mx-10 md:mx-10 md:pr-2 lg:mx-20">
            <div class="space-y-4">
                <p class="text-2xl text-kulture-color-cuatro mb-4">
                    Importar Participantes
                </p>
            </div>
            <p class="mb-4">
                Es el momento de medir y analizar la cultura agile de tu organización:
            </p>
            <p class="mb-4">
                Para poder conocer el grado de madurez que existe dentro de tu grupo de trabajo a través de nuestra herramienta, carga a los participantes (empleados) para identificar y medir su felicidad, crear una cultura de alto rendimiento y analizar y proteger el entorno de salud del trabajador.
            </p>
            <p class="mb-4">
                <a href="{{ asset('downloads/plantilla_carga_participantes.xlsx') }}" class="hover:text-kulture-color-cuatro font-bold">Descarga</a> la plantilla que deberás completar con los datos de los participantes para luego subirla al sistema.
            </p>
            @if ($errors->any())
                <div class="mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('empresas.importar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col lg:flex-row gap-5 lg:justify-items-end">
                    <div>
                        <input type="file" name="file" required>
                    </div>
                    <div>
                        <input type="hidden" name="invitacion_enviada" value="true">
                        <button type="submit" class="w-auto px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md shadow-green-400">Subir archivos</button>
                    </div>
                </div>
            </form>
          


</section>



@endsection