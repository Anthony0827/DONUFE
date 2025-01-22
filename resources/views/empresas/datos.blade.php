@extends('components.layouts.default')

@section('title', 'Encuesta | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Variable para ocultar el navbar y menú
@endphp

<!-- FORMULARIO DE Empresa -->

@section('content')

   

        <section class="flex justify-center min-h-full-no-header items-center w-screen  text-gray-500 bg-kulture-color-cuatro rounded-tl-4xl">
        <div class="grid grid-cols-1 items-center w-11/12 max-w-full my-5 rounded-3xl bg-white md:w-5/6 md:mx-10 md:my-8 md:min-h-1xl">
          <div class="m-8 md:mx-10 lg:mx-28">
             <div class="bg-white text-kulture-color-cuatro py-4 px-6 rounded-t-3xl border-b border-kulture-color-cuatro">
            <h1 class="text-xl font-bold">Datos personales</h1>
        </div>




            <!-- Form -->
          
              <div class="flex flex-col lg:flex-row gap-5">
                <!-- Column 1 -->
                <div class="w-full space-y-4">
 <form action="{{ route('empresas.update', ['idempresa' => $empresa->idempresa]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="flex flex-col gap-5 lg:flex-row">
        <!-- Columna 1 -->
        <div class="w-full space-y-4 md:mx-1">
            <!-- Razón Social -->
            <div>
                <label for="nombreEmpresa" class="block text-kulture-color-cuatro">Razón Social</label>
                <input type="text" id="nombreEmpresa" name="nombreEmpresa" class="form-input border-none w-full bg-gray-100" 
                       value="{{ old('nombreEmpresa', $empresa->nombreEmpresa) }}" readonly>
                <hr>
            </div>

            <!-- CIF -->
            <div>
                <label for="cif" class="block text-kulture-color-cuatro">CIF</label>
                <input type="text" id="cif" name="cif" class="form-input border-none w-full bg-gray-100" 
                       value="{{ old('cif', $empresa->cif) }}" readonly>
                <hr>
            </div>

            <!-- Correo Electrónico -->
            <div>
                <label for="email" class="block text-kulture-color-cuatro">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-input border-none w-full bg-gray-100" 
                       value="{{ old('email', $email) }}" readonly>
                <hr>
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono" class="block text-kulture-color-cuatro">Teléfono</label>
                <input type="text" id="telefono" name="telefono" class="form-input border-none w-full" 
                       value="{{ old('telefono', $empresa->telefono) }}">
                <hr>
            </div>

            <!-- Provincia -->


            <div>

           

<x-select-provincia :select-tipo="old('idprovincia', $empresa->idprovincia)" :listado="$listadoProvincias" name="idprovincia" id="provincia" />
                <hr>
            </div>
        </div>

        <!-- Columna 2 -->
        <div class="w-full space-y-4 md:mx-1">
            <!-- Tipo de Empresa -->
            <div>
                          @php
    $tiposEmpresa = [
        1 => 'Inicial (1 - 10 empleados)',
        2 => 'Startup (11 - 50 empleados)',
        3 => 'Media (51 - 150 empleados)',
        4 => 'Grande',
    ];
@endphp
                <label for="tipoEmpresa" class="block text-kulture-color-cuatro">Tipo de Empresa</label>
                <input type="text" id="tipoEmpresa" name="tipoEmpresa" class="form-input border-none w-full bg-gray-100" 
       value="{{ $tiposEmpresa[$empresa->tipoEmpresa] ?? 'Desconocido' }}" readonly>
                <hr>
            </div>

            <!-- Fecha de Registro -->
            <div>
                <label for="fechaRegistro" class="block text-kulture-color-cuatro">Fecha de Registro</label>
                <input type="text" id="fechaRegistro" name="fechaRegistro" class="form-input border-none w-full bg-gray-100" 
                       value="{{ old('fechaRegistro', $empresa->fecharegistro) }}" readonly>
                <hr>
            </div>

            <!-- Localidad -->
            <div>


<x-select-localidad 
    :select-tipo="old('idlocalidad', $empresa->idlocalidad)" 
    :idprovincia="$empresa->idprovincia" 
    name="idlocalidad" 
    id="localidad" 
/>

                <hr>
            </div>

            <!-- Sector -->
            <div>
                <x-select-sector :select-tipo="old('idsector', $empresa->idsector)" :listado="$listadoSector" name="idsector" />
                <hr>
            </div>

            <!-- Dirección -->
            <div>
                <label for="direccion" class="block text-kulture-color-cuatro">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="form-input border-none w-full" 
                       value="{{ old('direccion', $empresa->direccion) }}">
                <hr>
            </div>
        </div>
    </div>

    <div class="mt-5 w-full text-center lg:text-right">
        <button type="submit" class="w-full lg:w-fit px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md shadow-green-400 hover:bg-green-100 hover:text-kulture-green hover:shadow-none">
            Guardar
        </button>
    </div>
</form>
@endsection
