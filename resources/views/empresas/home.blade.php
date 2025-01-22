@extends('components.layouts.default')

@section('title', 'Información | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Define esta variable para ocultar el navbar y menú
@endphp

@section('content')


<section class="flex items-center justify-center text-gray-500 min-h-full-no-header bg-kulture-color-cuatro rounded-tl-4xl">
	<div class="grid w-11/12 max-w-full grid-cols-1 my-5 bg-white main-container rounded-3xl md:w-5/6 md:mx-10 md:my-8 low-dpi:h-md md:h-2xl">
		<div class="grid content-between gap-6 m-8 overflow-auto auto-rows-min scrollbar scrollbar-firefox low-dpi:mx-10 md:mx-10 md:pr-2 lg:mx-20">
			<div class="space-y-4">
				
				<div class="space-y-3">
				      <p class="text-2xl text-kulture-color-cuatro">
                    Información | Kulture Team
                </p>
            </div>
            <p>
                Gracias por utilizar Kulture Team y por ayudar a mejorar la felicidad y productividad de tu equipo de trabajo, alineándolos para la consecución de objetivos claves.
            </p>
            <p>
                ¿Qué es Kulture Team?
            </p>
            <p>
                Es una herramienta SaaS que facilita una implementación eficaz de las prácticas de desarrollo ágil. Midiendo la cultura Agile, analizando el grado de madurez de los equipos a través de la compatibilidad cultural de cada empleado y la felicidad de cada grupo de trabajo, Creando una cultura de alto rendimiento y protegiendo el entorno de salud (estrés laboral) del trabajador.
            </p>
            <p>
                ¡Vamos a ello!
            </p>
        </div>
			          <div class="mt-5 w-full text-center lg:text-right">
                <button id="btnContinuar"  class="w-full lg:w-fit px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md shadow-green-400 hover:bg-green-100 hover:text-kulture-green hover:shadow-none"onclick="continuar(1, 1)">Continuar</button>
              </div>    
               
            </div>
        </div>
		
	</div>
</section>
@endsection

@section('scripts')

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

 
@endsection