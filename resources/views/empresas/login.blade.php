@extends('components.layouts.default')

@section('title', 'Inicio de sesión | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Define esta variable para ocultar el navbar y menú
@endphp

@section('content')

<section class="flex items-center justify-center w-screen text-gray-500 min-h-full-no-header bg-kulture-color-cuatro rounded-tl-4xl">
<div class="flex flex-col items-center justify-center w-11/12 max-w-full my-5 bg-white main-container rounded-3xl md:w-5/6 md:mx-10 md:my-8 low-dpi:h-md md:h-2xl">
				<!-- grid grid-cols-12 grid-rows-2 md:grid-rows-1 auto-rows-min -->
				<div class="relative flex flex-col max-w-screen-xl gap-0 m-8 space-y-16 overflow-auto lg:flex-row lg:space-y-0 lg:w-5/6 scrollbar scrollbar-firefox sm:px-8 lg:px-6 lg:gap-32 low-dpi:mx-10 lg:mx-8">        
        @if (session('status'))
            <div class="w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center">
                {{ session('status') }}
            </div>
        @endif
        <div class="relative flex flex-col max-w-screen-xl gap-16 m-8 overflow-auto lg:flex-row lg:w-5/6 scrollbar scrollbar-firefox sm:px-8 lg:px-6 low-dpi:mx-10 lg:mx-8">
          
            <div id="login" class="top-0 lg:sticky lg:w-2/3"> <!-- Cambiado de lg:w-1/2 a lg:w-2/3 -->
                <p class="text-2xl text-kulture-color-cuatro">Inicio de sesión</p>
                <form action="{{ route('empresas.authenticate') }}" method="POST" class="w-full px-1 my-4">
                    @csrf
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="block mb-1 text-sm font-semibold text-kulture-color-cuatro">Usuario</label>
                        <input type="text" name="email" class="w-full px-3 py-2 border rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" placeholder="Usuario" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Password -->
                    <div id="cpsw1" class="mt-3 mb-4">
                        <label for="clave" class="block mb-1 text-sm font-semibold text-kulture-color-cuatro">Contraseña</label>
                        <input type="password" name="clave" class="w-full px-3 py-2 border rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" placeholder="Contraseña" value="{{ old('clave') }}" required>
                        @error('clave')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
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
            
<div id="formRegistro" class="lg:w-1/3 lg:ml-32 mt-16 lg:mt-0" style="max-height: 400px; overflow-y: auto;"> <!-- Añadido mt-16 para más separación -->
    <p class="mb-4 text-2xl text-kulture-color-cuatro">Registro</p>
    <form role="form" id="registro" class="pb-2 w-full max-w-sm mx-auto" autocomplete="off" method="POST" action="{{ route('empresas.store') }}">
        @csrf
        <input type="hidden" id="x-icon" name="x-icon" value="Mw==">
        <div class="flex items-center justify-between hidden px-4 py-2 mb-4 text-white rounded-lg bg-kulture-color-cuatro">
            <div class="flex items-center justify-around hidden w-11/12 px-3 py-2 mx-auto mb-6 text-white rounded-lg alert alert-danger bg-kulture-color-cuatro" id="mensajeError2">
                <div class="flex items-center justify-center w-11/12">
                    <i class="mr-2 bi bi-exclamation-triangle"></i>
                    <span>Los campos marcados en rojo son obligatorios</span>
                </div>
                <button type="button" class="w-1/12" data-dismiss="alert" aria-hidden="true">×</button>
            </div>
            <div class="alert alert-dismissable hide" id="mensajePost">
                <i class="bi bi-x-lg"></i>
                <span id="mensajeAlert"></span>
            </div>
        </div>
        <input type="hidden" id="accion" name="accion" value="registroR">

        <!-- Name input -->
        <div class="mb-3">
            <label for="nombreEmpresa" class="block mb-1 text-sm font-semibold text-kulture-color-cuatro">Nombre / Razón Social</label>
            <input type="text" class="w-full px-3 py-2 border rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="nombreEmpresa" id="nombreEmpresa" placeholder="Nombre / Razón Social" value="{{ old('nombreEmpresa') }}" required>
            @error('nombreEmpresa')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- CIF input -->
        <div class="mb-3">
            <label for="cif" class="block mb-1 text-sm font-semibold text-kulture-color-cuatro">CIF</label>
            <input type="text" class="w-full px-3 py-2 border rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="cif" id="cif" placeholder="CIF" value="{{ old('cif') }}" required>
            @error('cif')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Phone input -->
        <div class="mb-3">
            <label for="telefono" class="block mb-1 text-sm font-semibold text-kulture-color-cuatro">Teléfono</label>
            <input type="text" class="w-full px-3 py-2 border rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="telefono" id="telefono" placeholder="Teléfono" value="{{ old('telefono') }}" required>
            @error('telefono')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Email input -->
        <div class="mb-3">
            <label for="emailRegistro" class="block mb-1 text-sm font-semibold text-kulture-color-cuatro">Email</label>
            <input type="email" class="w-full px-3 py-2 border rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="emailRegistro" id="emailRegistro" placeholder="Email" value="{{ old('emailRegistro') }}" autocomplete="off" required>
            @error('emailRegistro')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Confirm email input -->
        <div class="mb-3">
            <label for="emailConfirmar" class="block mb-1 text-sm font-semibold text-kulture-color-cuatro">Confirmar Email</label>
            <input type="email" class="w-full px-3 py-2 border rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="emailConfirmar" id="emailConfirmar" placeholder="Confirmar email" value="{{ old('emailConfirmar') }}" autocomplete="off" required>
            @error('emailConfirmar')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Password input -->
        <div class="mb-3">
            <label for="claveRegistro" class="block mb-1 text-sm font-semibold text-kulture-color-cuatro">Contraseña</label>
            <input type="password" class="w-full px-3 py-2 border rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="claveRegistro" id="claveRegistro" placeholder="Contraseña" autocomplete="off" required>
            @error('claveRegistro')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Confirm password input -->
        <div class="mb-3">
            <label for="claveRegistro_confirmation" class="block mb-1 text-sm font-semibold text-kulture-color-cuatro">Confirmar Contraseña</label>
            <input type="password" class="w-full px-3 py-2 border rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="claveRegistro_confirmation" id="claveRegistro_confirmation" placeholder="Confirmar contraseña" autocomplete="off" required>
            @error('claveRegistro_confirmation')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Business selector -->
        <div class="mb-3">
            <label for="tipoEmpresa" class="block mb-1 text-sm font-semibold text-kulture-color-cuatro">Tipo de empresa</label>
            <select class="w-full px-3 py-2 border rounded-md form-select focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="tipoEmpresa" id="tipoEmpresa" required>
                <option disabled selected value="">Seleccione una opción</option>
                <option value="1" {{ old('tipoEmpresa') == 1 ? 'selected' : '' }}>Inicial (1 - 10 empleados)</option>
                <option value="2" {{ old('tipoEmpresa') == 2 ? 'selected' : '' }}>Startup (11 - 50 empleados)</option>
                <option value="3" {{ old('tipoEmpresa') == 3 ? 'selected' : '' }}>Media (51 - 150 empleados)</option>
                <option value="4" {{ old('tipoEmpresa') == 4 ? 'selected' : '' }}>Grande (más de 150 empleados)</option>
            </select>
            @error('tipoEmpresa')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
         <div class="mb-6 space-y-3 form-group has-feedback">
            <div class="col-sm-12">
                <div class="checkbox">
                    <input type="checkbox" class="w-5 h-5 mr-1 border-gray-400 rounded shadow-md form-checkbox text-kulture-color-cuatro focus:border-red-600 focus:ring focus:ring-offset-0 focus:ring-red-100 focus:ring-opacity-50" id="condicionesContratacion" name="condicionesContratacion" onchange="if (this.checked==false) {this.value=''} else {this.value=1};" value="1" required>
                    <span>Acepto las <a target="_blank" class="text-kulture-color-cuatro hover:border-b hover:border-b-kulture-color-cuatro" href="https://konectadores.kulture.es/condiciones-generales/">condiciones generales de contratación</a></span>
                    <span class="text-naranja">y las</span>
                    <a target="_blank" class="text-kulture-color-cuatro hover:border-b hover:border-b-kulture-color-cuatro" href="https://konectadores.kulture.es/aviso-legal/">condiciones legales</a>.
                </div>
            </div>
            @error('condicionesContratacion')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
            <div class="form-group has-feedback">
                <div class="col-sm-12">
                    <div class="checkbox">
                        <input type="checkbox" class="w-5 h-5 mr-1 border-gray-400 rounded shadow-md form-checkbox text-kulture-color-cuatro focus:border-red-600 focus:ring focus:ring-offset-0 focus:ring-red-100 focus:ring-opacity-50" id="politicaEmails" name="politicaEmails" onchange="if (this.checked==false) {this.value=''} else {this.value=1};" value="1" required>
                        <span>Acepto la <a target="_blank" class="text-kulture-color-cuatro hover:border-b hover:border-b-kulture-color-cuatro" href="https://www.kulture.es/politica-privacidad/">política de privacidad y envío de emails</a>.</span>
                    </div>
                </div>
                @error('politicaEmails')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- Send button -->
        <button style="padding: 10px 0;" type="submit" id="crearCuenta" data-loading-text="Enviando..." class="flex items-center justify-center w-full text-white transition transform rounded-lg shadow-md px-7 bg-kulture-color-cuatro hover:text-kulture-color-cuatro hover:bg-white hover:shadow-gray-400"><i class="mr-1 text-2xl md:text-base md:mr-2 bi bi-send"></i> Enviar</button>
    </form>
</div>
    </form>
</div>

</div>
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
                <form id="passwordResetForm" action="{{ route('empresas.password.email') }}" method="POST" onsubmit="handlePasswordReset(event)">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div id="statusMessage" class="hidden text-sm mt-3"></div> <!-- Mensaje dinámico -->
                    <div id="spinner" class="hidden text-center mb-3">
                        <i class="fa fa-spinner fa-spin text-kulture-color-cuatro"></i> Enviando solicitud...
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