@extends('components.layouts.default')

@section('title', 'Encuesta | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Variable para ocultar el navbar y menú
@endphp

<!-- FORMULARIO DE CANDIDATO -->

@section('content')

<div id="popupModal" class="absolute inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden">
    <div class="bg-white text-kulture-color-cuatro py-10 px-6 rounded-3xl shadow-lg w-full max-w-3xl border border-kulture-color-cuatro">
        <div class="text-center">
            <h2 class="text-2xl font-bold">¡Muchas gracias por tu Feedback!</h2>
            <p class="mt-8 text-kulture-color-cuatro text-lg">
                Estamos trabajando para intentar ser mejores.
                A continuación, te haremos una serie de preguntas para identificar y analizar la cultura de tu empresa.
                 <strong>NO</strong> serán utilizados estos datos en preguntas relacionadas con tu satisfacción personal.
                Todas las respuestas serán <strong>anónimas</strong>.
            </p>
        </div>

        <div class="mt-6 flex flex-col items-center">
            <button id="closeModalButton" class="px-6 py-2 bg-kulture-color-cuatro text-white rounded-full hover:bg-opacity-90">
                Entendido
            </button>
        </div>
    </div>
</div>
   

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
                  <!-- Item 1 -->
                <form action="{{ route('candidatos.update', ['idcandidato' => $candidatos->idcandidato]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-5 lg:flex-row">
                        <!-- Columna 1 -->
                        <div class="w-full space-y-4 md:mx-1">
                            <div>
                                <label for="nombres" class="block text-kulture-color-cuatro">Nombre</label>
                                <input type="text" id="nombres" name="nombres" class="form-input border-none w-full" value="{{ old('nombres', $candidatos->nombres) }}">
                                <hr>
                            </div>
                            <div>
                                <label for="apellidos" class="block text-kulture-color-cuatro">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-input border-none w-full" value="{{ old('apellidos', $candidatos->apellidos) }}">
                                <hr>
                            </div>
                            <div>
                                <label for="sexo" class="block text-kulture-color-cuatro">Sexo</label>
                                <select id="sexo" name="sexo" class="form-input border-none w-full">
                                    <option value="N" {{ old('sexo', $candidatos->sexo) == 'N' ? 'selected' : '' }}>No especificado</option>
                                    <option value="H" {{ old('sexo', $candidatos->sexo) == 'H' ? 'selected' : '' }}>Hombre</option>
                                    <option value="M" {{ old('sexo', $candidatos->sexo) == 'M' ? 'selected' : '' }}>Mujer</option>
                                </select>
                                <hr>
                            </div>
                            <div>
                                <x-select-rangoedad :select-tipo="old('idrangoedad', $candidatos->idrangoedad)" :listado="$listadoRangoEdad" name="idrangoedad" />
                                <hr>
                            </div>
                            <div>
                                <x-select-provincia :select-tipo="old('idprovincia', $candidatos->idprovincia)" :listado="$listadoProvincias" name="idprovincia" />
                                <hr>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="w-full space-y-4 md:mx-1">
                            <div>
                                <x-select-educacion :select-tipo="old('ideducacion', $candidatos->ideducacion)" :listado="$listadoEducacion" name="ideducacion" />
                                <hr>
                            </div>
                            <div>
                                <x-select-experiencia :select-tipo="old('idexperiencia', $candidatos->idexperiencia)" :listado="$listadoExperiencia" name="idexperiencia" />
                                <hr>
                            </div>
                            <div>
                                <x-select-perfil :select-tipo="old('idperfil', $candidatos->idperfil)" :listado="$listadoPerfil" name="idperfil" />
                                <hr>
                            </div>
                            <div>
                                <label for="archivocv" class="block text-kulture-color-cuatro">Foto de Perfil</label>
                                <input type="file" id="archivocv" name="archivocv" class="w-full border-none rounded-md form-input text-kulture-color-cuatro focus:ring-kulture-color-cuatro">
                                @if($candidatos->archivocv)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $candidatos->archivocv) }}" alt="Foto de perfil actual" class="img-thumbnail rounded-md" width="150">
                                        <p class="mt-1 text-kulture-color-cuatro">{{ $candidatos->nombres }}</p>
                                    </div>
                                @endif
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
            </div>
        </div>
    </div>



</section>


@endsection

@section('scripts')

@endsection
<!-- Script para cargar localidades según la provincia seleccionada
<script>
    $(document).ready(function() {
        $('#idprovincia').on('change', function() {
            const idProvincia = $(this).val();
            console.log('ID Provincia seleccionado:', idProvincia); // Verifica el valor seleccionado

            $('#idlocalidad').html('<option value="">Cargando localidades...</option>');

            if (idProvincia) {
                $.ajax({
                    url: "{{ route('localidades.get', '') }}/" + idProvincia,
                    type: 'GET',
                    success: function(data) {
                        console.log('Datos de localidades recibidos:', data); // Muestra los datos recibidos

                        $('#idlocalidad').empty().append('<option value="">Selecciona una localidad</option>');
                        $.each(data, function(index, localidad) {
                            $('#idlocalidad').append('<option value="' + localidad.idlocalidad + '">' + localidad.localidad + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar localidades:', xhr.responseText); // Muestra el error en la consola
                        alert('Hubo un error al cargar las localidades.');
                    }
                });
            } else {
                $('#idlocalidad').html('<option value="">Selecciona una provincia primero</option>');
            }
        });
    });
</script>
 -->


     <!-- Telefono -->

          <!--  <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" class="form-control" value="{{ old('telefono', $candidatos->telefono) }}">
            </div> -->

  <!-- Situación -->
            <!-- <x-select-situacion :select-tipo="old('idsituacion', $candidatos->idsituacion)" :listado="$listadoSituacion" name="idsituacion" /> -->

    <!-- Localidad -->
         <!--   <x-select-localidad 
    :select-tipo="old('idlocalidad', $candidatos->idlocalidad)" 
    :idprovincia="old('idprovincia', $candidatos->idprovincia)" 
    name="idlocalidad" 
/> -->

 <!-- Componentes de departamento, educación, experiencia, perfil y situación -->

            <!-- Departamento -->
            <!-- <x-select-departamento :select-tipo="old('iddepartamento', $candidatos->iddepartamento)" :listado="$listadoDepartamentos" name="iddepartamento" /> -->
