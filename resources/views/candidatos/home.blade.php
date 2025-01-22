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
				<p class="text-2xl text-kulture-color-cuatro">Información | Kulture Team</p>
				<div class="space-y-3">
					<p class="text-start">¿De qué se trata este Análisis cultural, Felicidad laboral, Factores sociales y Burnout?</p>
					<p class="text-start">El objetivo de este estudio es poder conocer la cultura de tu empresa y el grado de madurez agile de los equipos, analiza su felicidad, activar las palancas necesarias para comenzar a construir una cultura de alto rendimiento e iniciar una transformación cultural agile de integración y bienestar sostenible.</p>
					<p class="text-start">Para ello, te pediremos que realices 4 analisis: <span class="font-semibold">Cultural</span> - <span class="font-semibold">Felicidad Laboral</span> - <span class="font-semibold">Factores Sociales</span> y <span class="font-semibold">Burnout</span>.</p>
					<p class="text-start">A continuación, encontrarás una serie de declaraciones sobre comportamientos determinados. Lee cada uno de ellos atentamente y ordénalos de mayor a menor importancia, usando la escala de:</p>
					<p class="text-start">1 (Muy Importante) - 4 (Poco importante).</p>
					<p class="text-start">Por favor, contesta las preguntas con total sinceridad y transparencia.</p>
					<p class="text-start">Dispones de un apartado de feedback que te servirá para comunicar de forma totalmente anónima, cualquier información, felicitación, sugerencia o algo que tu creas que va mal.</p>
                    <p class="text-start">Como así también, dispones de un tablero en forma de tarjetas (método visual) para que puedas ir registrando tus tareas y puedas tener una visión genérica de tu carga de trabajo.</p>
                    <p class="text-start">¡Vamos a ello!</p>
                </div>
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