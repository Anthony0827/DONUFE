
@extends('components.layouts.inicio')

@section('title', 'Encuesta | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Variable para ocultar el navbar y menú
@endphp


@section('content')

<div class="flex flex-col relative md:space-x-4 lg:space-x-20 h-full justify-center items-center md:flex-row">
    <div class="text-center rounded-xl p-3 mt-3 mb-4 md:mt-0 md:mb-0 md:p-0 z-20">
        <img src="{{ asset('images/logo_horizontal_blanco.png') }}" class="rounded-3xl" alt="Trabajadores celebrando">
    </div>
    <div class="max-w-sm text-white p-3 md:p-0 md:pl-3 text-center md:text-start z-10">
        <div class="bg-kulture-color-cuatro h-72 left-10 rounded-l-3xl w-screen -z-10 top-1/2 -translate-y-1/2 hidden md:block absolute"></div>
        <div class="bg-kulture-color-cuatro rounded-b-3xl">
            <!-- Aumentar margen inferior del título -->
            <p class="mb-12 text-4xl lg:mb-16">Iniciar sesión como:</p>
        </div>
        <div class="bg-kulture-color-cuatro rounded-b-3xl">
            <!-- Formulario con margen superior más amplio -->
            <form class="z-20 flex flex-row gap-4 pb-4 lg:pb-0 mt-10" role="form" name="FormInicioCliente" id="FormInicioCliente" method="post" enctype="application/x-www-form-urlencoded">
                <button class="flex items-center justify-center px-7 py-2.5 rounded-lg bg-white text-kulture-color-cuatro shadow-md hover:-translate-y-0.5 transform transition" type="button" id="ingresoCandidato" data-loading-text="Enviando..." onclick="redirectToRegistro()">
                    <i class="bi bi-person-check mr-2"></i> Soy empleado
                </button>
                <button class="flex items-center justify-center px-7 py-2.5 rounded-lg bg-white text-kulture-color-cuatro shadow-md hover:-translate-y-0.5 transform transition" type="button" id="ingresoEmpresa" data-loading-text="Enviando..." onclick="redirectToRegistroEmp()">
                    <i class="bi bi-building-check mr-2"></i> Soy empresa
                </button>
            </form>
        </div>
    </div>
</div>

				

@endsection

@section('scripts')

@endsection

<script>
    function redirectToRegistro() {
        window.location.href = "{{ route('usuarios.login') }}";
    }

       function redirectToRegistroEmp() {
        window.location.href = "{{ route('empresas.login') }}";
    }

  

   
</script>

</body>

</html>


    


